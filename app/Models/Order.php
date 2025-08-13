<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\OrderStatusUpdated;
/**
 * @property int $id
 * @property string $order_code
 * @property int $user_id
 * @property string $total_price
 * @property string $status
 * @property string $payment_method
 * @property string $payment_status
 * @property string|null $note
 * @property int $shipping_address_id
 * @property int|null $coupon_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \App\Models\ReturnRequest|null $returnRequest
 * @property-read \App\Models\ShippingAddress $shippingAddress
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    //
protected $fillable = [
        'shop_address_id',
        'order_code',
        'user_id',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'note',
        'cancellation_requested',
        'cancel_reason',
        'admin_cancel_note',
        'cancel_confirmed',
        'shipping_address_id',
        'shipping_fee',
        'coupon_id',
        'extra_info',
        'vnp_txn_ref',
        'vnp_transaction_no',
        'vnp_response_code',
        'vnp_bank_code',
        'vnp_bank_tran_no',
        'vnp_card_type',
        'vnp_pay_date',
        'vnp_secure_hash'
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

    protected $dispatchesEvents = [
        'updated' => OrderStatusUpdated::class,
        // 'created' => OrderStatusUpdated::class,
    ];
}
