<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'status', 'group_id'];

    protected $casts = [
        'status' => 'string',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function group()
    {
        return $this->belongsTo(CategoryGroup::class, 'group_id');
    }
}

