<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return back()->with(
            $status === Password::RESET_LINK_SENT
                ? ['success' => '📩 Đã gửi liên kết đặt lại mật khẩu!']
                : ['error' => '❌ Không thể gửi email đến địa chỉ này.']
        );
    }
}

