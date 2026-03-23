<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

