    <?php

    use App\Http\Controllers\Admin\CouponController;
    use App\Http\Controllers\Admin\ProductController as AdminProductController;
    use App\Http\Controllers\Admin\UserController;
    use App\Http\Controllers\Admin\BrandController;
    use App\Http\Controllers\Admin\CategoryController;
    use App\Http\Controllers\Admin\OrderController;
    use App\Http\Controllers\Admin\AdminNotificationController;
    use App\Http\Controllers\Admin\CustomerNotificationController;
    use App\Http\Controllers\Client\Auth\LoginController;
    use App\Http\Controllers\Client\Auth\RegisterController;
    use App\Http\Controllers\Client\Auth\VerifyController;
    use App\Http\Controllers\Client\ClientNotificationController;
    use App\Http\Controllers\Client\AccountController;
    use App\Http\Controllers\Client\Auth\Mail\ResetPasswordController;
    use App\Http\Controllers\Client\Auth\Mail\ForgotPasswordController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
    use Laravel\Socialite\Facades\Socialite;
    use App\Models\User;

    use App\Http\Controllers\Admin\ReviewController; // Đánh giá (Reviews)

    use App\Http\Controllers\Client\Auth\SocialAuthController; // dăng nhập bằng gôogle
    use App\Http\Controllers\Client\ProductController;
    use App\Http\Controllers\Client\WishlistController;

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
            // Voucher được câoj nhật lại
            Route::get('/coupons/trashed', [CouponController::class, 'trashed'])->name('admin.coupons.trashed');
            Route::resource('coupons', CouponController::class);
            Route::post('/coupons/{id}/restore', [CouponController::class, 'restore'])->name('admin.coupons.restore');
        });

        // Người dùng (Users)
        Route::resource('/users', UserController::class)->names('admin.users');
        Route::get('/admin/users/banned', [UserController::class, 'banned'])->name('admin.users.banned');
        Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('admin.users.restore');
        Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('admin.users.forceDelete');

        // Đơn hàng (Orders)
        Route::get('/orders', function () {
            return view('admin.orders.orders');
        })->name('orders');

        // Đánh giá (Reviews)
        Route::get('/reviews', function () {
            return view('admin.others_menu.reviews');
        })->name('reviews');
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
        Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

        // thông báo admin: Admin xem nhận thông báo
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
        Route::get('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('admin.notifications.markAllRead');
        // admin gửi thông báo cho khách hàng
        Route::get('/customer-notifications', [CustomerNotificationController::class, 'index'])->name('customer-notifications');
        Route::get('/customer-notifications/create', [CustomerNotificationController::class, 'create'])->name('admin.customer-notifications.create');
        Route::post('/customer-notifications', [CustomerNotificationController::class, 'store'])->name('admin.customer-notifications.store');
    });

    // ✅ Route riêng cho Khách hàng (Client) đã đăng nhập
    Route::middleware('auth')->prefix('client')->group(function () {
        Route::post('/wishlist/store', [WishlistController::class, 'store'])
            ->name('wishlist.store');
        Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])
            ->name('wishlist.destroy');
    });

    // ✅ Route cho Khách hàng (Client) chung (không cần đăng nhập cũng được)
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

    // Route hiển thị danh sách yêu thích
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/guest', [WishlistController::class, 'getGuestWishlist'])->name('wishlist.guest');

    // Route đồng bộ hóa wishlist lên server khi người dùng đăng nhập
    Route::post('/wishlist/sync', [WishlistController::class, 'sync'])->name('wishlist.sync');

    // Route kiểm tra status sản phẩm trước khi thêm vào wishlist
    Route::get('/wishlist/check/product/{id}', [WishlistController::class, 'check'])
        ->name('wishlist.check');

    // Route cho tài khoản khách hàng
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account/client', [AccountController::class, 'update'])->name('account.update');

    Route::get('/detail-product/{id}', [ProductController::class, 'show'])->name('detail-product');


    // đây là phần thông báo được gửi tới khách hàng
    Route::get('/client/notifications', [ClientNotificationController::class, 'index'])->name('client.notifications');
    Route::post('/client/notifications/mark-all-read', [ClientNotificationController::class, 'markAllRead'])->name('client.notifications.markAllRead');

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
