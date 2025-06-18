<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'sku',
        'thumbnail',
        'description',
        'short_description',
        'slug',
        'status',
        
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Quan hệ với model Category

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
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

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

        return '0 VNĐ'; // Fallback if no variants
    }
}

