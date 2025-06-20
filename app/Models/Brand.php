<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Brand extends Model
{
    // Nếu tên bảng không theo quy ước, bạn có thể khai báo:
    // protected $table = 'brands';
    use SoftDeletes;
    use HasFactory;
    // Cho phép gán giá trị hàng loạt cho các trường này (nếu cần)
    protected $fillable = ['name', 'slug', 'status', 'image'];
}
