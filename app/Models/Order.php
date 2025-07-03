<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
protected $fillable = [
        'user_id',
        'order_code', // Thêm order_code
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'note',
        'shipping_address_id',
        'coupon_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function getStatusLabel()
    {
        $statuses = [
            'pending' => ['label' => 'Đang chờ xử lý', 'color' => 'bg-warning'],
            'processing' => ['label' => 'Đang xử lý', 'color' => 'bg-primary'],
            'shipped' => ['label' => 'Đang giao hàng', 'color' => 'bg-info'],
            'delivered' => ['label' => 'Đã hoàn thành', 'color' => 'bg-success'],
            'cancelled' => ['label' => 'Đơn đã hủy', 'color' => 'bg-danger'],
        ];

        return $statuses[$this->status] ?? ['label' => 'Không xác định', 'color' => 'bg-secondary'];
    }

    public static function getStatusMeta($status)
    {
        $statuses = [
            'pending'    => ['label' => 'Đang chờ xử lý', 'color' => 'bg-warning'],
            'processing' => ['label' => 'Đang xử lý',     'color' => 'bg-primary'],
            'shipped'    => ['label' => 'Đang giao hàng', 'color' => 'bg-info'],
            'delivered'  => ['label' => 'Đã hoàn thành',  'color' => 'bg-success'],
            'cancelled'  => ['label' => 'Đơn đã hủy',     'color' => 'bg-danger'],
        ];

        return $statuses[$status] ?? ['label' => 'Không xác định', 'color' => 'bg-secondary'];
    }
}
