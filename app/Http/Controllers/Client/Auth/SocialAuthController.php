<?php
namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
       return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Nếu ứng dụng dùng session (mặc định Laravel), bỏ 'stateless()'
            // $googleUser = Socialite::driver('google')->user();

            // Nếu ứng dụng không dùng session (ví dụ: API), giữ 'stateless()'
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)), // Tăng độ dài mật khẩu lên 16
                    'email_verified_at' => now(),
                    'status' => 'active',
                    'role_id' => 2,
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]
            );

            Auth::login($user);

            // Chuyển hướng dựa trên role_id
            return match ($user->role_id) {
                1 => redirect('/admin'),
                2 => redirect('/'),
                default => redirect('/login')->withErrors(['msg' => 'Tài khoản không có quyền truy cập']),
            };
        } catch (Exception $e) {
            // Xử lý lỗi nếu đăng nhập thất bại
            return redirect('/login')->withErrors(['msg' => 'Đăng nhập bằng Google thất bại. Vui lòng thử lại.']);
        }
    }
}