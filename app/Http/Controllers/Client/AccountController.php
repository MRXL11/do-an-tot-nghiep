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
        $orders = Order::with('orderDetails.productVariant.product', 'coupon', 'returnRequest')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // Duyệt qua từng đơn hàng để tính discount (nếu có coupon)
        foreach ($orders as $order) {
            $discount = 0;

            // Tính subtotal (chưa bao gồm phí ship)
            $subtotal = $order->orderDetails->sum('subtotal');

            if ($order->coupon) {
                if ($order->coupon->discount_type === 'fixed') {
                    $discount = $order->coupon->discount_value;
                } elseif ($order->coupon->discount_type === 'percent') {
                    $discount = round($subtotal * $order->coupon->discount_value / 100);
                }
            }

            // Gán giảm giá tạm thời vào order (không cần lưu DB)
            $order->calculated_discount = $discount;

            // Gán subtotal để hiển thị
            $order->total = $subtotal;

            // Tính tổng tiền cuối cùng sau khi giảm giá
            $order->final_price = $order->total_price;
            // Nếu total đã bao gồm ship
        }

        $totalOrderCount = Order::where('user_id', auth()->id())->count();

        return view('client.pages.account', compact('user', 'orders', 'totalOrderCount'));
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
