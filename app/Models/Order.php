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

    public function returnRequest()
    {
        return $this->hasOne(ReturnRequest::class);
    }

    // gán hiển thị tiếng việt và định dạng cho trạng thái đơn hàng
    public function getStatusLabel()
    {
        $statuses = [
            'pending' => ['label' => 'Đang chờ xử lý', 'color' => 'bg-warning'],
            'processing' => ['label' => 'Đang xử lý', 'color' => 'bg-primary'],
            'shipped' => ['label' => 'Đang giao hàng', 'color' => 'bg-info'],
            'delivered' => ['label' => 'Đã giao hàng', 'color' => 'bg-success'],
            'completed' => ['label' => 'Đã hoàn thành', 'color' => 'bg-secondary'],
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
            'delivered'  => ['label' => 'Đã giao hàng',  'color' => 'bg-success'],
            'completed' => ['label' => 'Đã hoàn thành', 'color' => 'bg-secondary'],
            'cancelled'  => ['label' => 'Đơn đã hủy',     'color' => 'bg-danger'],
        ];

        return $statuses[$status] ?? ['label' => 'Không xác định', 'color' => 'bg-secondary'];
    }

    // gán hiển thị tiếng việt và định dạng cho phương thức thanh toán
    public function getPaymentMethod($paymentMethod)
    {
        $methods = [
            'cod' => ['label' => 'Thanh toán khi nhận hàng', 'color' => '#CC6666'],
            'online' => ['label' => 'Thanh toán trực tuyến', 'color' => '#6699CC'],
            'bank_transfer' => ['label' => 'Thanh toán qua ngân hàng', 'color' => '#CC66CC'],
        ];

        return $methods[$paymentMethod] ?? ['label' => 'Không xác định'];
    }

    // gán hiển thị tiếng việt và định dạng cho trạng thái thanh toán
    public function getPaymentStatus($paymentStatus)
    {
        $paymentStatuses = [
            'pending' => ['label' => 'Chờ thanh toán', 'color' => '#FF9966'],
            'completed' => ['label' => 'Đã thanh toán', 'color' => '#009900'],
            'refund_in_processing' => ['label' => 'Đang xử lý hoàn tiền', 'color' => '#6699FF'],
            'refunded' => ['label' => 'Đã hoàn tiền', 'color' => '#33CC99'],
            'failed' => ['label' => 'Thanh toán thất bại', 'color' => '#666666'],
        ];

        return $paymentStatuses[$paymentStatus] ?? ['label' => 'Không xác định'];
    }
}
