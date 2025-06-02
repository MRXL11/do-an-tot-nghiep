<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;


Route::get('/admin', function () {
    return view('admin.others_menu.statistical');
})->name('statistical');

Route::get('/users', function () {
    return view('admin.users.users');
})->name('users');

Route::resource('/products', AdminProductController::class)->names('admin.products');

Route::post('/admin/products/{id}/restore', [AdminProductController::class, 'restore'])
    ->name('admin.products.restore');
Route::post('/admin/products/{id}/addVariants', [AdminProductController::class, 'addVariants'])
    ->name('admin.products.addVariants');


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
route::get('/page', function () {
    return view('client.pages.page-layout');
});
route::get('/products-client', function () {
    return view('client.pages.products-client');
});
route::get('/cart', function () {
    return view('client.pages.cart');
});
route::get('/checkout', function () {
    return view('client.pages.checkout');
});
route::get('/about', function () {
    return view('client.pages.about');
});

route::get('/contact', function () {
    return view('client.pages.contact');
});

route::get('/wishlist', function () {
    return view('client.pages.wishlist');
});

route::get('/account', function () {
    return view('client.pages.account');
});
route::get('/detail-product', function () {
    return view('client.pages.detail-product');
});

route::get('/login', function () {
    return view('client.pages.login');
});
route::get('/register', function () {
    return view('client.pages.register');
});
route::get('/notifications-client', function () {
    return view('client.pages.notifications-client');
});
