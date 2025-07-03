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
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập và hiển thị cảnh báo
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thanh toán.');
        }

        // ✅ Lấy dữ liệu người dùng hiện tại
        $user = User::with('shippingAddresses')->find(Auth::id());

        // ✅ Lấy danh sách ID sản phẩm từ query string: ?cart_item_ids=1,2,3
        $rawIds = explode(',', $request->query('cart_item_ids', ''));

        // ✅ Lọc ra các ID hợp lệ (chỉ giữ lại ID là số nguyên dương)
        $validIds = array_filter($rawIds, function ($id) {
            return is_numeric($id) && intval($id) > 0;
        });

        // ✅ Nếu không có ID nào hợp lệ → quay lại giỏ hàng
        if (empty($validIds)) {
            return redirect()->route('cart.index')->with('warning', 'Danh sách sản phẩm không hợp lệ.');
        }

        // ✅ Truy vấn các sản phẩm trong giỏ hàng của user hiện tại, dựa trên danh sách ID hợp lệ
        $cartItems = Cart::with(['productVariant', 'user'])
            ->where('user_id', Auth::id()) // Đảm bảo chỉ lấy cart của người dùng hiện tại
            ->whereIn('id', $validIds)     // Chỉ lấy những cart_item có ID nằm trong danh sách đã chọn
            ->get();

        // ✅ Nếu không tìm thấy sản phẩm nào → redirect về giỏ hàng và hiển thị thông báo
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Không tìm thấy sản phẩm nào phù hợp.');
        }

        // ✅ Nếu có sản phẩm không hợp lệ bị loại ra → thông báo nhẹ để người dùng biết
        if (count($validIds) !== $cartItems->count()) {
            session()->flash('warning', 'Một số sản phẩm bạn chọn đã ngừng bán hoặc không còn tồn tại và sẽ không được hiển thị.');
        }

        // ✅ Tính tổng tiền tạm tính (subtotal)
        $subtotal = $cartItems->sum(function ($item) {
            return $item->productVariant->price * $item->quantity;
        });

        // ✅ Truyền dữ liệu sang view checkout để hiển thị
        return view('client.pages.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $subtotal, // Có thể thêm phí ship sau nếu cần
            'user' => $user, // Truyền dữ liệu người dùng để hiển thị địa chỉ đã lưu
        ]);
    }

    public function submit(Request $request)
    {
        // ✅ Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thanh toán.');
        }

        // ✅ Validate dữ liệu đầu vào
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

        // ✅ Lấy danh sách sản phẩm trong giỏ hàng đã chọn từ form
        $cartItemIds = $request->input('cart_item_ids');
        if (empty($cartItemIds)) {
            return redirect()->route('cart.index')->with('warning', 'Vui lòng chọn sản phẩm để thanh toán.');
        }
        
        // Chuyển string thành array nếu cần
        if (is_string($cartItemIds)) {
            $cartItemIds = explode(',', $cartItemIds);
        }
        
        // Lọc các ID hợp lệ
        $cartItemIds = array_filter($cartItemIds, function ($id) {
            return is_numeric($id) && intval($id) > 0;
        });

        // ✅ Lấy các sản phẩm trong giỏ hàng
        $cartItems = Cart::with(['productVariant.product'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartItemIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Không tìm thấy sản phẩm để thanh toán.');
        }

        try {
            DB::beginTransaction();

            // ✅ Tạo hoặc tìm địa chỉ giao hàng
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

            // ✅ Tính tổng tiền
            $subtotal = $cartItems->sum(function ($item) {
                return $item->productVariant->price * $item->quantity;
            });
            $shippingFee = 20000; // Phí vận chuyển cố định
            $totalPrice = $subtotal + $shippingFee;

            // ✅ Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => $request->paymentMethod === 'momo' ? 'online' : 'cod',
                'payment_status' => 'pending',
                'note' => $request->note ?? null,
                'shipping_address_id' => $shippingAddress->id,
                'coupon_id' => null, // Có thể thêm logic xử lý coupon sau
            ]);

            // ✅ Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->productVariant->price,
                    'discount' => 0,
                    'subtotal' => $item->productVariant->price * $item->quantity,
                ]);
            }

            // ✅ Xóa các sản phẩm đã đặt hàng khỏi giỏ hàng
            Cart::where('user_id', Auth::id())
                ->whereIn('id', $cartItemIds)
                ->delete();

            DB::commit();

            // ✅ Chuyển hướng dựa trên phương thức thanh toán
            if ($request->paymentMethod === 'momo') {
                // Lưu order_id vào session để sử dụng ở trang thanh toán momo
                session(['pending_order_id' => $order->id]);
                return redirect()->route('pay')->with('success', 'Đơn hàng đã được tạo. Vui lòng thanh toán để hoàn tất.');
            }

            // ✅ COD hoặc các phương thức khác - chuyển về trang account
            return redirect()->route('account.show')->with('order-success', 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.')
                ->withInput();
        }
    }
}
