<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    //
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // Giữ lại created_at, nhưng tắt updated_at
    public function setUpdatedAt($value)
    {
        // Không làm gì cả để chặn updated_at được ghi
    }

    public function getUpdatedAtColumn()
    {
        return null; // Tắt hoàn toàn updated_at
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
