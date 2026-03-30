<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'email',
        'password_hash',
        'full_name',
        'phone_number',
        'role',
        'status',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_hash' => 'hashed',
        ];
    }

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Relationships
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class, 'user_id', 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'user_vouchers', 'user_id', 'voucher_id')
            ->withPivot('is_used', 'used_at')
            ->withTimestamps();
    }
}
