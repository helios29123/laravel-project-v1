<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $primaryKey = 'attribute_id';

    protected $fillable = [
        'name',
        'category_id'
    ];

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'attribute_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
