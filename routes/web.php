<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\Auth\RegisterController;
use App\Http\Controllers\Client\Auth\VerifyController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\Auth\Mail\ResetPasswordController;
use App\Http\Controllers\Client\Auth\Mail\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\Admin\CouponController;

use App\Http\Controllers\Client\Auth\SocialAuthController; // dăng nhập bằng gôogle

// ✅ Route cho Admin
// Route cho Admin
Route::middleware(['auth', 'restrict.admin'])->group(function () {

    // Dashboard admin
    Route::get('/admin', function () {
        return view('admin.others_menu.statistical');
    })->name('statistical');

    // Nhóm route admin với prefix và name
    Route::prefix('admin')->name('admin.')->group(function () {
        // Sản phẩm (Products)
        Route::resource('products', AdminProductController::class);
        Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
        Route::post('/products/{id}/addVariants', [AdminProductController::class, 'addVariants'])->name('products.addVariants');

        // Đơn hàng (Orders)
        Route::resource('orders', OrderController::class)
            ->except(['store', 'create', 'edit', 'destroy']);
        Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');


        // Danh mục (Categories)
        Route::get('/categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
        Route::resource('categories', CategoryController::class);

        Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('/categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        // Thương hiệu (Brands)
        Route::resource('brands', BrandController::class)->except(['show']);
        Route::patch('/brands/{id}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
        //voucher
        Route::get('/coupons/trashed', [CouponController::class, 'trashed'])->name('coupons.trashed');
        Route::resource('coupons', CouponController::class);
        Route::post('/coupons/{id}/restore', [CouponController::class, 'restore'])->name('coupons.restore');
        Route::delete('/coupons/{id}/force-delete', [CouponController::class, 'forceDelete'])->name('coupons.forceDelete');

    });

    // Người dùng (Users)
    Route::get('/users', function () {
        return view('admin.users.users');
    })->name('users');

    // Đơn hàng (Orders)
    Route::get('/orders', function () {
        return view('admin.orders.orders');
    })->name('orders');

    
    // Voucher


    // Đánh giá (Reviews)
    Route::get('/reviews', function () {
        return view('admin.others_menu.reviews');
    })->name('reviews');

    // Thông báo (Notifications)
    Route::get('/notifications', function () {
        return view('admin.others_menu.notifications');
    })->name('notifications');
});

// ✅ Route cho Khách hàng (Client)
Route::get('/', function () {
    return view('client.layouts.index');
})->name('home');

Route::get('/page', function () {
    return view('client.pages.page-layout');
})->name('page');

Route::get('/products-client', function () {
    return view('client.pages.products-client');
})->name('products-client');

Route::get('/cart', function () {
    return view('client.pages.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('client.pages.checkout');
})->name('checkout');

Route::get('/about', function () {
    return view('client.pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('client.pages.contact');
})->name('contact');

Route::get('/wishlist', function () {
    return view('client.pages.wishlist');
})->name('wishlist');

Route::get('/account', function () {
    return view('client.pages.account');
})->name('account');

Route::post('/account', [AccountController::class, 'update'])->name('account.update');

Route::get('/detail-product', function () {
    return view('client.pages.detail-product');
})->name('detail-product');

Route::get('/notifications-client', function () {
    return view('client.pages.notifications-client');
})->name('notifications-client');

// ✅ Route xác thực (Auth)
Route::middleware('web')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.submit');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/login')->with('success', 'Bạn đã đăng xuất');
    })->name('logout');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'handleRegister'])->name('register.submit');
});

// Xác thực email 
Route::post('/register/otp/send', [RegisterController::class, 'sendOtp'])->name('register.otp.send');
Route::post('/register/otp/submit', [RegisterController::class, 'registerWithOtp'])->name('register.submit.otp');
Route::post('/verify/send', [VerifyController::class, 'send'])->name('verify.send');
Route::post('/verify/check', [VerifyController::class, 'check'])->name('verify.check');
// đặt lại mật khẩu
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// ✅ Đăng nhập Google (Socialite)
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');
