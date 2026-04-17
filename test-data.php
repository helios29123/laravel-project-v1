<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

// Create test user
User::create([
    'full_name' => 'Test User',
    'email' => 'test@example.com',
    'password_hash' => bcrypt('password'),
    'role' => 'customer',
    'status' => 'active'
]);

// Create test category
$category = Category::create([
    'name' => 'Test Electronics',
    'status' => 'active'
]);

// Create test product
$product = Product::create([
    'category_id' => $category->category_id,
    'name' => 'Arduino Uno R3',
    'description' => 'Test Arduino board',
    'status' => 'active'
]);

// Create test variant
$variant = ProductVariant::create([
    'product_id' => $product->product_id,
    'sku' => 'ARDUINO-UNO-R3',
    'price' => 125000,
    'stock_quantity' => 50
]);

echo "Test data created successfully!\n";
echo "User: test@example.com / password\n";
echo "Product: {$product->name}\n";
echo "Variant ID: {$variant->product_variant_id}\n";