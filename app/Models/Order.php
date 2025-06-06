<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

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
            'shipped' => ['label' => 'Đã giao', 'color' => 'bg-info'],
            'delivered' => ['label' => 'Đã hoàn thành', 'color' => 'bg-success'],
            'cancelled' => ['label' => 'Đã hủy', 'color' => 'bg-danger'],
        ];

        return $statuses[$this->status] ?? ['label' => 'Không xác định', 'color' => 'bg-secondary'];
    }
}
