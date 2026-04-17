<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    if (User::where('email', 'admin@electrogear.com')->exists()) {
        echo "Admin user already exists!\n";
        exit(1);
    }

    User::create([
        'full_name' => 'Administrator',
        'email' => 'admin@electrogear.com',
        'password_hash' => Hash::make('admin123'),
        'phone_number' => '0123456789',
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
    ]);

    echo "Admin user created successfully!\n";
    echo "Email: admin@electrogear.com\n";
    echo "Password: admin123\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}