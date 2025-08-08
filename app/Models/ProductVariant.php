<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        
        'status',
        'import_price',
        'price',
        'stock_quantity',
        'sku',
        'image',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * [THÊM MỚI]
     * Lấy các giá trị thuộc tính (màu, size,...) của biến thể này.
     */
    public function attributes()
    {
        // Định nghĩa mối quan hệ nhiều-nhiều tới AttributeValue
        // thông qua bảng trung gian 'product_variant_attributes'
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attributes');
    }
}