<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'image',
        'slug',
        'status',
        'published_at',
        'views'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Lấy URL đầy đủ của ảnh.
     * Thuộc tính này sẽ được gọi bằng: $news->image_url
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        // Kiểm tra xem bài viết có ảnh và file ảnh có thực sự tồn tại trong storage không
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            // Nếu có, trả về URL đầy đủ đến file
            return Storage::url($this->image);
        }

        // Nếu không có ảnh, trả về một ảnh placeholder mặc định
        return 'https://via.placeholder.com/800x600.png?text=No+Image';
    }
}