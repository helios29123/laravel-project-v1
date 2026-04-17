<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'Administrator',
            'email' => 'admin@electrogear.com',
            'password_hash' => Hash::make('admin123'),
            'phone_number' => '0123456789',
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}