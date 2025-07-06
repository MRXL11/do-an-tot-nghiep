<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateAccountClientRequest;
use App\Models\Order;
use App\Models\User;

class AccountController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
        }

        // Lấy danh sách đơn hàng của người dùng 
        $orders = Order::with('orderDetails.productVariant.product', 'coupon')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Duyệt qua từng đơn hàng để tính discount (nếu có coupon)
        foreach ($orders as $order) {
            $discount = 0;

            if ($order->coupon) {
                if ($order->coupon->discount_type === 'fixed') {
                    $discount = $order->coupon->discount_value;
                } elseif ($order->coupon->discount_type === 'percent') {
                    $discount = round($order->total_price * $order->coupon->discount_value / 100);
                }
            }

            // Gán giảm giá tạm thời vào order (không cần lưu DB)
            $order->calculated_discount = $discount;

            // Nếu bạn muốn hiển thị tổng tiền sau giảm giá:
            $order->final_price = max(0, $order->total_price - $discount);

            $order->total = $order->orderDetails->sum('subtotal');
        }

        return view('client.pages.account', compact('user', 'orders'));
    }


    public function update(UpdateAccountClientRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;

        if (!$user->google_id && $request->filled('new_password')) {
            if (!$request->filled('old_password')) {
                return back()->withErrors(['old_password' => 'Vui lòng nhập mật khẩu cũ khi thay đổi mật khẩu.']);
            }
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng']);
            }
            $user->password = Hash::make($request->new_password);
        } else {

            $user->save();

            return redirect()->back()->with('success', '✅ Cập nhật tài khoản thành công!');
        }
    }
}
