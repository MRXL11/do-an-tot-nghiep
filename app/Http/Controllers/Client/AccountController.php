<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{   
    // Đổi mật khẩu
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'old_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->address = $request->address;

        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng']);
            }
        }

        $user->save();

        return back()->with('success', '✅ Cập nhật tài khoản thành công!');
    }

    //Lịch sử đơn hàng
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->with(['orderDetails.productVariant.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.pages.account', compact('user', 'orders'));
    }

    public function cancel(Order $order)
    {
        // Kiểm tra: chỉ chủ sở hữu mới được hủy và chỉ khi đơn đang 'pending'
        if ($order->user_id !== auth()->id()) {
            return back()->with('error', 'Bạn không có quyền hủy đơn này.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn đang chờ xử lý.');
        }

        // Cập nhật trạng thái đơn hàng
        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

}
