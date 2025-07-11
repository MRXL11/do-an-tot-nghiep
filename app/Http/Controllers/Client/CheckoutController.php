<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thanh toán.');
        }

        // Lấy dữ liệu người dùng hiện tại
        $user = User::with('shippingAddresses')->find(Auth::id());

        // Lấy danh sách ID sản phẩm từ query string: ?cart_item_ids=1,2,3
        $rawIds = explode(',', $request->query('cart_item_ids', ''));

        // Lọc ra các ID hợp lệ (chỉ giữ lại ID là số nguyên dương)
        $validIds = array_filter($rawIds, function ($id) {
            return is_numeric($id) && intval($id) > 0;
        });

        // Nếu không có ID nào hợp lệ → quay lại giỏ hàng
        if (empty($validIds)) {
            return redirect()->route('cart.index')->with('warning', 'Danh sách sản phẩm không hợp lệ.');
        }

        // Truy vấn các sản phẩm trong giỏ hàng của user hiện tại, dựa trên danh sách ID hợp lệ
        $cartItems = Cart::with(['productVariant', 'user'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $validIds)
            ->get();

        // Nếu không tìm thấy sản phẩm nào → redirect về giỏ hàng
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Không tìm thấy sản phẩm nào phù hợp.');
        }

        // Nếu có sản phẩm không hợp lệ bị loại ra → thông báo nhẹ
        if (count($validIds) !== $cartItems->count()) {
            session()->flash('warning', 'Một số sản phẩm bạn chọn đã ngừng bán hoặc không còn tồn tại.');
        }

        // Tính tổng tiền tạm tính (subtotal)
        $subtotal = $cartItems->sum(function ($item) {
            return $item->productVariant->price * $item->quantity;
        });

        // Truyền dữ liệu sang view checkout
        return view('client.pages.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $subtotal + 20000, // Thêm phí ship
            'user' => $user,
        ]);
    }

    public function submit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thanh toán.');
        }

        // Validate dữ liệu đầu vào
        $request->validate([
            'paymentMethod' => 'required|in:cod,momo,card',
            'name' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'ward' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
        ], [
            'paymentMethod.required' => 'Vui lòng chọn phương thức thanh toán.',
            'name.required' => 'Vui lòng nhập họ tên người nhận.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'address.required' => 'Vui lòng nhập địa chỉ giao hàng.',
        ]);

        // Lấy danh sách sản phẩm trong giỏ hàng đã chọn từ form
        $cartItemIds = $request->input('cart_item_ids');
        Log::info('Raw cart_item_ids: ' . var_export($cartItemIds, true));

        if (empty($cartItemIds)) {
            Log::warning('cart_item_ids is empty');
            return redirect()->route('cart.index')->with('warning', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        if (is_string($cartItemIds)) {
            $cartItemIds = array_filter(explode(',', $cartItemIds), function ($id) {
                return is_numeric($id) && intval($id) > 0;
            });
        }

        Log::info('Filtered cart_item_ids: ' . var_export($cartItemIds, true));

        if (empty($cartItemIds)) {
            Log::warning('Filtered cart_item_ids is empty');
            return redirect()->route('cart.index')->with('warning', 'Danh sách sản phẩm không hợp lệ.');
        }

        // Truy vấn các sản phẩm trong giỏ hàng
        $cartItems = Cart::with(['productVariant'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartItemIds)
            ->get();

        if ($cartItems->isEmpty()) {
            Log::warning('No cart items found for user_id: ' . Auth::id() . ', cart_item_ids: ' . implode(',', $cartItemIds));
            return redirect()->route('cart.index')->with('warning', 'Không tìm thấy sản phẩm để thanh toán.');
        }

        DB::beginTransaction();
        try {
            // Tạo địa chỉ giao hàng
            $shippingAddress = ShippingAddress::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'ward' => $request->ward,
                'district' => $request->district,
                'city' => $request->city,
                'is_default' => false,
            ]);

            // Tính tổng tiền
            $subtotal = $cartItems->sum(function ($item) {
                return $item->productVariant->price * $item->quantity;
            });
            $shippingFee = 20000;
            $totalPrice = $subtotal + $shippingFee;

            // Tạo mã đơn hàng duy nhất
            $orderCode = 'ORD-' . strtoupper(Str::random(8));

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $orderCode,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => $request->paymentMethod === 'momo' ? 'online' : 'cod',
                'payment_status' => 'pending',
                'note' => $request->note ?? null,
                'shipping_address_id' => $shippingAddress->id,
                'coupon_id' => null,
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'import_price' => $item->productVariant->import_price, // Thêm cột import_price
                    'price' => $item->productVariant->price,
                    'discount' => 0,
                    'subtotal' => $item->productVariant->price * $item->quantity,
                ]);
            }

            // Xóa sản phẩm khỏi giỏ hàng nếu chọn COD
            if ($request->paymentMethod === 'cod') {
                Cart::where('user_id', Auth::id())
                    ->whereIn('id', $cartItemIds)
                    ->delete();
            } else {
                // Lưu cart_item_ids vào session để sử dụng sau khi thanh toán Momo thành công
                session(['pending_cart_item_ids' => $cartItemIds]);
            }

            DB::commit();
            Log::info('Checkout completed successfully', ['order_id' => $order->id]);

            if ($request->paymentMethod === 'momo') {
                session(['pending_order_id' => $order->id]);
                return redirect()->route('pay')->with('success', 'Đơn hàng đã được tạo. Vui lòng thanh toán để hoàn tất.');
            }

            return redirect()->route('account.show')->with('order-success', 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'cart_item_ids' => $cartItemIds
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage())->withInput();
        }
    }
}
