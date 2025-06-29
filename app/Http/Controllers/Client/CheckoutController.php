<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $paymentMethod = $request->input('paymentMethod'); // hoặc $request->paymentMethod;
        // ✅ Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thanh toán.');
        }

        // ✅ Xử lý logic thêm đơn hàng vào db ở đây
        // ...

        if ($paymentMethod === 'momo') {
            // ✅ Chuyển hướng đến trang thanh toán Momo
            return redirect()->route('pay');
        }

        // ✅ Nếu không phải thanh toán Momo, xử lý logic đặt hàng thông thường
        return redirect()->route('account.show')->with('order-success', 'Đã đặt hàng thành công.');
    }
}
