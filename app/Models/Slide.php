<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'description',
        'order',
        'status',
        'news_id',
        'views'
    ];

    /**
     * Tự động chuyển đổi kiểu dữ liệu.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean', // Tự động chuyển 0/1 trong CSDL thành false/true
    ];

    /**
     * Định nghĩa quan hệ với News.
     */
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    /**
     * Tạo một thuộc tính ảo để lấy URL đầy đủ của ảnh.
     * Cách dùng: $slide->image_url
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        // Kiểm tra xem slide có ảnh và file có tồn tại không
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            // Trả về URL chính xác
            return Storage::url($this->image);
        }

        // Nếu không có ảnh, trả về ảnh mặc định
        return 'https://via.placeholder.com/1200x500.png?text=Slide+Image';
    }
}