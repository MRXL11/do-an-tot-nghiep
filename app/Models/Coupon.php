<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $code
 * @property string $discount_type
 * @property string $discount_value
 * @property string|null $min_order_value
 * @property string|null $max_discount
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int|null $usage_limit
 * @property int|null $user_usage_limit
 * @property int $used_count
 * @property array<array-key, mixed>|null $applicable_categories
 * @property array<array-key, mixed>|null $applicable_products
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $status_badge
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereApplicableCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereApplicableProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMaxDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereMinOrderValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUserUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon withoutTrashed()
 * @mixin \Eloquent
 */
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