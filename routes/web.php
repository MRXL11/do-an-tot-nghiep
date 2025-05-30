<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;

// khi làm route admin mọi người hãy sửa lại đường dẫn cho đúng với tên thư mục của mình nhé
// ví dụ như url admin/user/edit-user
// nằm trong admin thì sẽ là admin/.....
Route::get('/admin/statistical', function () {
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


Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands');
Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
Route::post('/admin/brands', [BrandController::class, 'store'])->name('brands.store');
Route::get('/admin/brands/{id}', [BrandController::class, 'show'])->name('brands.show');
Route::get('/admin/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');


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
route ::get('/page', function () {
    return view('client.pages.page-layout');
});
route ::get('/products-client', function () {
    return view('client.pages.products-client');
});
route ::get('/cart', function () {
    return view('client.pages.cart');
});
route ::get('/checkout', function () {
    return view('client.pages.checkout');
});
route ::get('/about', function () {
    return view('client.pages.about');
});

route ::get('/contact', function () {
    return view('client.pages.contact');
});

route ::get('/wishlist', function () {
    return view('client.pages.wishlist');
});

route ::get('/account', function () {
    return view('client.pages.account');
});
route ::get('/detail-product', function () {
    return view('client.pages.detail-product');
});

route ::get('/login', function () {
    return view('client.pages.login');
});
route ::get('/register', function () {
    return view('client.pages.register');
});
route ::get('/notifications-client', function () {
    return view('client.pages.notifications-client');
});
