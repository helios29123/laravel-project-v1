<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserVoucher extends Pivot
{
    protected $table = 'user_vouchers';

    protected $primaryKey = 'user_voucher_id';
    
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'is_used',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'is_used' => 'boolean',
            'used_at' => 'datetime',
        ];
    }
}
