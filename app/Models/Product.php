<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'status',
    ];

    protected $appends = ['image', 'price'];

    public function getImageAttribute()
    {
        $image = $this->images()->first();
        return $image ? $image->image_url : null;
    }

    public function getPriceAttribute()
    {
        $variant = $this->variants()->first();
        return $variant ? $variant->price : 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }
}
