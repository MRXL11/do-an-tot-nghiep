<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'color',
        'size',
        'status',
        'import_price', // Thêm trường giá nhập để phục vụ tính lợi nhuận
        'price',
        'stock_quantity',
        'sku',
        'image',
    ];
    protected $casts = [
        'status' => 'string', // Can use enum cast if needed: 'enum' => ['active', 'inactive']
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
