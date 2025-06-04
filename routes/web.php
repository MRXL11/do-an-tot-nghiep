<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
});
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

// Đây là khách hàng
Route::get('/', function () {
    return view('client.layouts.index');
});
Route::get('/page', function () {
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
Route::get('/detail-product', function () {
    return view('client.pages.detail-product');
});
Route::get('/login', function () {
    return view('client.pages.login');
});
Route::get('/register', function () {
    return view('client.pages.register');
});
Route::get('/notifications-client', function () {
    return view('client.pages.notifications-client');
});
