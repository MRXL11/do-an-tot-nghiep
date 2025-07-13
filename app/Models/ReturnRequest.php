<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    //
    protected $fillable = ['order_id', 'user_id', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getReturnStatusAttribute()
    {
        $statusLabels = [
            'requested' => [
                'label' => 'Yêu cầu trả hàng đã được gửi. Quý khách vui lòng chờ xử lý.',
                'color' => 'warning',
                'title' => 'Chờ xử lý',
                'icon'  => 'bi-clock' // Đồng hồ chờ
            ],
            'approved'  => [
                'label' => 'Yêu cầu trả hàng của bạn đã được chấp nhận',
                'color' => 'primary',
                'title' => 'Đã chấp nhận',
                'icon'  => 'bi-check-circle' // Chấp nhận
            ],
            'rejected'  => [
                'label' => 'Yêu cầu trả hàng của bạn bị từ chối',
                'color' => 'danger',
                'title' => 'Đã từ chối',
                'icon'  => 'bi-x-circle' // Từ chối
            ],
            'refunded'  => [
                'label' => ($this->order->payment_status === 'pending' && $this->order->payment_method === 'cod')
                    ? 'Hàng đã được hoàn trả lại'
                    : 'Đã hoàn tiền',
                'color' => 'success',
                'title' => ($this->order->payment_status === 'pending' && $this->order->payment_method === 'cod')
                    ? 'Đã nhận lại hàng'
                    : 'Đã hoàn tiền',
                'icon'  => ($this->order->payment_status === 'pending' && $this->order->payment_method === 'cod')
                    ? 'bi-box-arrow-in-left' // Icon nhận lại hàng
                    : 'bi-cash-coin'         // Icon hoàn tiền
            ]
        ];

        return $statusLabels[$this->status] ?? [
            'label' => 'Không xác định',
            'color' => 'dark',
            'icon'  => 'bi-question-circle'
        ];
    }

    public static function getStatusLabelStatic($status)
    {
        $statusLabels = [
            'requested' => ['label' => 'Đã gửi yêu cầu trả hàng', 'color' => 'warning'],
            'approved'  => ['label' => 'Đã chấp nhận trả hàng',   'color' => 'primary'],
            'rejected'  => ['label' => 'Yêu cầu bị từ chối',      'color' => 'danger'],
            'refunded'  => ['label' => 'Đã hoàn tiền',            'color' => 'success'],
        ];

        return $statusLabels[$status] ?? ['label' => 'Không xác định', 'color' => 'dark'];
    }
}
