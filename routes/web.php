<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;

// ----- ROUTE BREEZE (AUTH) -----
Route::redirect('/dashboard', '/admin')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ----- ROUTE FRONTEND (KHÁCH HÀNG) -----
Route::get('/', [HomeController::class, 'index']);

Route::get('/products', function () {
    $products = \App\Models\Product::where('status', 'active')->paginate(15);
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

// Chú ý: Đã gỡ bỏ Route cũ của /login và /register vì gói Breeze đã tự động xử lý qua file auth.php

// ----- ROUTE ADMIN -----
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::patch('categories/{id}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::patch('products/{id}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('categories/{id}/attributes', [App\Http\Controllers\Admin\ProductController::class, 'getAttributes'])->name('admin.categories.attributes');
    
    // User Routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::patch('users/{id}/toggle-role', [UserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::patch('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
