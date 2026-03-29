<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/products', function () {
    $products = \App\Models\Product::paginate(15);
    return view('products', [
        'products' => $products,
        'sale_status' => true
    ]);
});

Route::get('/products/{id}', [HomeController::class, 'show'])->name('product.show');

Route::get('/about', function (){
    return view('about');
});

Route::get('/contact', function() {
    return view('contact');
});

Route::get('/cart', function() {
    return view('cart');
});

Route::get('/checkout', function() {
    return view('checkout');
});

Route::get('/login', function() {
    return view('login');
});

Route::get('/register', function() {
    return view('register');
});

//admin_route here
Route::prefix('admin')->group(function() {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('categories/{id}/attributes', [App\Http\Controllers\Admin\ProductController::class, 'getAttributes'])->name('admin.categories.attributes');
});