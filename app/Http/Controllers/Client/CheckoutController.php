<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // ✅ Lưu cart ids đã chọn vào session để sử dụng khi submit
        session(['selected_cart_ids' => $validIds]);

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
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'ward' => 'required|string|max:100',
            'district' => 'required|string|max:100', 
            'city' => 'required|string|max:100',
            'coupon_code' => 'nullable|string'
        ]);

        try {
            // ✅ Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
            return DB::transaction(function () use ($request) {
                
                // ✅ Lấy cart items từ session (đã chọn từ trang cart)
                $selectedCartIds = session('selected_cart_ids', []);
                
                if (empty($selectedCartIds)) {
                    // Nếu không có session, lấy tất cả cart items
                    $cartItems = Cart::with(['productVariant.product'])
                        ->where('user_id', Auth::id())
                        ->get();
                } else {
                    // Lấy những cart items đã được chọn
                    $cartItems = Cart::with(['productVariant.product'])
                        ->where('user_id', Auth::id())
                        ->whereIn('id', $selectedCartIds)
                        ->get();
                }

                if ($cartItems->isEmpty()) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Không có sản phẩm nào để đặt hàng!');
                }

                // ✅ Tính tổng tiền
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->productVariant->price * $item->quantity;
                });

                $shippingFee = 20000; // Phí ship cố định
                $discount = 0; // Có thể thêm logic mã giảm giá sau
                $totalPrice = $subtotal + $shippingFee - $discount;

                // ✅ Tạo địa chỉ giao hàng
                $fullAddress = $request->address . ', ' . $request->ward . ', ' . 
                              $request->district . ', ' . $request->city;

                $shippingAddress = ShippingAddress::create([
                    'user_id' => Auth::id(),
                    'full_name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'ward' => $request->ward,
                    'district' => $request->district,
                    'city' => $request->city,
                    'full_address' => $fullAddress,
                    'is_default' => false
                ]);

                // ✅ Tạo mã đơn hàng unique
                do {
                    $orderCode = 'ORD' . date('Ymd') . strtoupper(Str::random(6));
                } while (Order::where('order_code', $orderCode)->exists());

                // ✅ Tạo đơn hàng
                $order = Order::create([
                    'order_code' => $orderCode,
                    'user_id' => Auth::id(),
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                    'payment_method' => $request->paymentMethod,
                    'payment_status' => $request->paymentMethod === 'cod' ? 'pending' : 'pending',
                    'note' => $request->note ?? '',
                    'shipping_address_id' => $shippingAddress->id,
                    'coupon_id' => null // Có thể thêm logic mã giảm giá sau
                ]);

                // ✅ Tạo chi tiết đơn hàng
                foreach ($cartItems as $cartItem) {
                    $variant = $cartItem->productVariant;
                    
                    // Kiểm tra tồn kho
                    if ($variant->stock_quantity < $cartItem->quantity) {
                        throw new \Exception("Sản phẩm {$variant->product->name} không đủ số lượng trong kho!");
                    }

                    $itemSubtotal = $variant->price * $cartItem->quantity;

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $variant->id,
                        'quantity' => $cartItem->quantity,
                        'price' => $variant->price,
                        'discount' => 0,
                        'subtotal' => $itemSubtotal
                    ]);

                    // ✅ Giảm tồn kho
                    $variant->decrement('stock_quantity', $cartItem->quantity);
                }

                // ✅ Xóa những cart items đã đặt hàng thành công
                $cartItemIds = $cartItems->pluck('id')->toArray();
                Cart::whereIn('id', $cartItemIds)->delete();
                
                // ✅ Xóa session selected_cart_ids
                session()->forget('selected_cart_ids');

                // ✅ Xử lý theo phương thức thanh toán
                if ($request->paymentMethod === 'momo') {
                    // Chuyển hướng đến trang thanh toán Momo
                    return redirect()->route('pay')
                        ->with('order_id', $order->id)
                        ->with('order_code', $orderCode);
                }

                // ✅ Với COD hoặc thẻ, chuyển về trang tài khoản với thông báo thành công
                return redirect()->route('account.show')
                    ->with('order-success', "Đặt hàng thành công! Mã đơn hàng: {$orderCode}")
                    ->with('order_code', $orderCode);

            });

        } catch (\Exception $e) {
            // ✅ Xử lý lỗi
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }
}
