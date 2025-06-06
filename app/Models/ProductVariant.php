<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    //
    protected $fillable = [
        'product_id',
        'color',
        'size',
        'status',
        'price',
        'stock_quantity',
        'sku',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
}
