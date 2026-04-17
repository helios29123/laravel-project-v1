<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

// Debug route
Route::get('/debug/auth', function() {
    return response()->json([
        'user_id' => Auth::id(),
        'user' => Auth::user(),
        'check' => Auth::check(),
        'session_id' => session()->getId()
    ]);
});

Route::get('/debug/product/{id}', function($id) {
    $product = \App\Models\Product::with('variants')->find($id);
    return response()->json([
        'product' => $product,
        'variants_count' => $product ? $product->variants->count() : 0,
        'first_variant' => $product && $product->variants->count() > 0 ? $product->variants->first() : null
    ]);
});

Route::get('/create-test-data', function() {
    try {
        // Create test user
        $user = \App\Models\User::create([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'password_hash' => bcrypt('password'),
            'role' => 'customer',
            'status' => 'active'
        ]);

        // Create test category
        $category = \App\Models\Category::create([
            'name' => 'Test Electronics',
            'status' => 'active'
        ]);

        // Create test product
        $product = \App\Models\Product::create([
            'category_id' => $category->category_id,
            'name' => 'Arduino Uno',
            'description' => 'Test Arduino board',
            'status' => 'active'
        ]);

        // Create test variant
        $variant = \App\Models\ProductVariant::create([
            'product_id' => $product->product_id,
            'sku' => 'ARDUINO-UNO-TEST',
            'price' => 125000,
            'stock_quantity' => 10
        ]);

        return response()->json([
            'message' => 'Test data created successfully',
            'user_id' => $user->user_id,
            'product_id' => $product->product_id,
            'variant_id' => $variant->product_variant_id
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

Route::match(['get','post'], '/payment/momo/callback', [CheckoutController::class, 'momoCallback'])->name('payment.momo.callback');

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

    // Order Routes
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('admin.orders.update');
});
