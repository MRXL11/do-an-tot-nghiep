<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Client\Auth\Mail\SendVerificationCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $otp = strtoupper(Str::random(6));
        session([
            'otp_register' => $otp,
            'register_data' => $request->only('name', 'email', 'password')
        ]);

        Mail::to($request->email)->send(new SendVerificationCode($otp));

        return back()->with('otp_sent', true);
    }

    public function registerWithOtp(Request $request)
    {
        if ($request->otp !== session('otp_register')) {
            return back()->withErrors(['otp' => '❌ Mã xác minh không đúng']);
        }

        $data = session('register_data');
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
            'role_id' => 2,
        ]);

        session()->forget(['otp_register', 'register_data']);

        return redirect()->route('login')->with('success', '✅ Đăng ký thành công, mời bạn đăng nhập.');
}
}
