<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Quan hệ với model Brand
    // public function brand()
    // {
    //     return $this->belongsTo(Brand::class);
    // }

    // Quan hệ với model ProductVariant
    // public function variants()
    // {
    //     return $this->hasMany(ProductVariant::class);
    // }
}