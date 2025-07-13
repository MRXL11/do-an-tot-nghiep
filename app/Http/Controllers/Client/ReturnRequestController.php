<?php

namespace App\Http\Controllers\Client;

use App\Models\Notification;
use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReturnRequestController extends Controller
{
    public function requestReturn($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Chỉ có thể yêu cầu trả hàng với đơn đã được giao.');
        }

        if ($order->returnRequest) {
            return back()->with('error', 'Bạn đã gửi yêu cầu trả hàng.');
        }

        // Ghi nhận yêu cầu
        ReturnRequest::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'status' => 'requested',
        ]);

        // Gửi thông báo đến admin
        $this->notifyAdminsAboutReturnRequest($order);

        return back()->with('success', 'Yêu cầu trả hàng đã được ghi nhận. Vui lòng chờ admin liên hệ.');
    }

    /**
     * Gửi thông báo đến tất cả admin về yêu cầu trả hàng.
     *
     * @param Order $order
     * @return void
     */
    private function notifyAdminsAboutReturnRequest(Order $order)
    {
        try {
            $admins = User::where('role_id', 1)->get();

            if ($admins->isEmpty()) {
                return; // Không có admin nào thì bỏ qua
            }

            $message = "Người dùng #{$order->user_id} - {$order->user->name} đã yêu cầu trả hàng cho đơn #{$order->order_code}. Vui lòng kiểm tra và xử lý.";

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'   => $admin->id,
                    'title'     => 'Yêu cầu trả hàng',
                    'message'   => $message,
                    'type'      => 'order',
                    'is_read'   => false,
                    'order_id'  => $order->id,
                    'created_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Lỗi tạo thông báo yêu cầu trả hàng: ' . $e->getMessage());
        }
    }
}
