<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'price',
        'discount',
        'subtotal'
    ];

    public $timestamps = false; // OrderDetail không có timestamps

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
