<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
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

    public function index()
    {
        $user = Auth::user();

        // Nạp đơn hàng cùng chi tiết sản phẩm
        $orders = $user->orders()
            ->with(['orderDetails.productVariant.product']) // nạp toàn bộ sản phẩm, màu, size, v.v.
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.pages.account', compact('user', 'orders'));
    }
}
