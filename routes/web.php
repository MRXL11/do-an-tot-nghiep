<?php



use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\Auth\RegisterController;
use App\Http\Controllers\Client\VerifyController;
use App\Http\Controllers\Client\AccountController;

use App\Http\Controllers\Client\Auth\Mail\ResetPasswordController;
use App\Http\Controllers\Client\Auth\Mail\ForgotPasswordController;






Route::get('/admin', function () {
    return view('admin.others_menu.statistical');
})->name('statistical');

Route::get('/users', function () {
    return view('admin.users.users');
})->name('users');

Route::get('/products', function () {
    return view('admin.products.products');
})->name('products');

Route::get('/orders', function () {
    return view('admin.orders.orders');
})->name('orders');

Route::get('/categories', function () {
    return view('admin.categories.categories');
})->name('categories');

Route::get('/reviews', function () {
    return view('admin.others_menu.reviews');
})->name('reviews');

Route::get('/brands', function () {
    return view('admin.brands.brands');
})->name('brands');

Route::get('/vouchers', function () {
    return view('admin.vouchers.vouchers');
})->name('vouchers');
Route::get('/notifications', function () {
    return view('admin.others_menu.notifications');
})->name('notifications');

// đây là khách hàng
Route::get('/', function () {
   return view('client.layouts.index');
});
Route ::get('/page', function () {
    return view('client.pages.page-layout');
});
Route::get('/products-client', function () {
    return view('client.pages.products-client');
});
Route::get('/cart', function () {
    return view('client.pages.cart');
});
Route::get('/checkout', function () {
    return view('client.pages.checkout');
});
Route::get('/about', function () {
    return view('client.pages.about');
});

Route::get('/contact', function () {
    return view('client.pages.contact');
});

Route::get('/wishlist', function () {
    return view('client.pages.wishlist');
});

Route::get('/account', function () {
    return view('client.pages.account');
});
Route::post('/account', [AccountController::class, 'update'])->name('account.update');
Route::get('/detail-product', function () {
    return view('client.pages.detail-product');
});


Route::middleware('web')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.submit');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/login')->with('success', 'Bạn đã đăng xuất');
    })->name('logout');
});

Route::get('/register', function () {
    return view('client.pages.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'handleRegister'])->name('register.submit');



Route::get('/notifications-client', function () {
    return view('client.pages.notifications-client');
});

// Xác thực email
Route::post('/register/otp/send', [RegisterController::class, 'sendOtp'])->name('register.otp.send');
Route::post('/register/otp/submit', [RegisterController::class, 'registerWithOtp'])->name('register.submit.otp');
Route::post('/verify/send', [VerifyController::class, 'send'])->name('verify.send');
Route::post('/verify/check', [VerifyController::class, 'check'])->name('verify.check');

// Gửi email chứa link đặt lại mật khẩu
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Trang form nhập mật khẩu mới
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Đăng nhập bằng mạng xã hội
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = \App\Models\User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'password' => bcrypt(Str::random(12)),
        'email_verified_at' => now(),
        'status' => 'active',
        'role_id' => 2
    ]);

    Auth::login($user);
    return redirect('/');
});







