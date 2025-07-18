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
        return $this->belongsTo(Category::class, 'category_id');
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

    /**
     * Lấy khoảng giá của sản phẩm dựa trên các biến thể (variants).
     *
     * - Nếu sản phẩm có biến thể:
     *     + Lấy giá thấp nhất và cao nhất trong các biến thể.
     *     + Nếu giống nhau → hiển thị 1 mức giá, ví dụ: "100.000 VNĐ".
     *     + Nếu khác nhau → hiển thị khoảng giá, ví dụ: "100.000 - 200.000 VNĐ".
     * - Nếu không có biến thể → trả về "Liên hệ".
     *
     * @return string Chuỗi định dạng giá, có phân cách hàng nghìn và đơn vị VNĐ.
     */
    public function getPriceRangeAttribute()
    {
        if ($this->variants()->exists()) {
            // Lấy giá thấp nhất từ các biến thể
            $minPrice = $this->variants()->min('price');

            // Lấy giá cao nhất từ các biến thể
            $maxPrice = $this->variants()->max('price');

            // Định dạng giá theo dạng 100.000 VNĐ 
            $format = fn($price) => number_format($price, 0, ',', '.') . ' VNĐ';

            // Nếu giá thấp nhất và cao nhất giống nhau, trả về một mức giá
            // Nếu khác nhau, trả về khoảng giá
            // Ví dụ: "100.000 VNĐ" hoặc "100.000 - 200.000 VNĐ"
            return $minPrice == $maxPrice
                ? $format($minPrice)
                : $format($minPrice) . ' - ' . $format($maxPrice);
        }

        // Trả về "Liên hệ" nếu không có biến thể
        return 'Liên hệ';
    }
    
}
