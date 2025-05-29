<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'short_description',
        'category_id',
        'brand_id',
        'thumbnail',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    // public function reviews()
    // {
    //     return $this->hasMany(Review::class);
    // }
    public function getPriceRangeAttribute()
    {
        if ($this->variants()->exists()) {
            $minPrice = $this->variants()->min('price');
            $maxPrice = $this->variants()->max('price');

            if ($minPrice == $maxPrice) {
                return number_format($minPrice) . ' VNĐ';
            }

            return number_format($minPrice) . ' - ' . number_format($maxPrice) . ' VNĐ';
        }

        return number_format($this->price) . ' VNĐ';
    }
}
