<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_value',
        'max_discount',
        'start_date',
        'end_date',
        'usage_limit',
        'user_usage_limit',
        'used_count',
        'applicable_categories',
        'applicable_products',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'applicable_categories' => 'array',
        'applicable_products' => 'array',
    ];

    public function getStatusBadgeAttribute()
    {
        $today = now();
        if ($this->end_date < $today) {
            return '<span class="badge bg-danger">Hết hạn</span>';
        } elseif ($this->end_date->diffInDays($today) <= 7) {
            return '<span class="badge bg-warning">Sắp hết hạn</span>';
        } else {
            return '<span class="badge bg-success">Active</span>';
        }
    }
}