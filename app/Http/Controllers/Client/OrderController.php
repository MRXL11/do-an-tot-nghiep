<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function createOrderCancelNotificationToAdmin($id, string $title = 'Cập nhật đơn hàng')
    {

        $order = Order::find($id); // Đảm bảo đơn hàng tồn tại
        if (!$order) {
            return redirect()->back()->with('cancel-request-error', 'Đơn hàng không tồn tại.');
        }

        // Kiểm tra trạng thái đơn hàng
        // Chỉ gửi thông báo nếu đơn hàng đang trong trạng thái 'pending' hoặc 'processing'
        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('cancel-request-error', 'Đơn hàng này không thể huỷ nữa.');
        }

        // Kiểm tra nếu đã gửi thông báo huỷ đơn hàng trước đó
        $existingNotification = Notification::where('order_id', $order->id)
            ->where('user_id', $order->user_id) // Chỉ kiểm tra thông báo của người dùng đã đặt đơn hàng
            ->where('type', 'order')
            ->where('is_read', false)
            ->first();

        // dd($existingNotification);

        if ($existingNotification) {
            return redirect()->back()->with('cancel-request-error', 'Bạn đã gửi yêu cầu huỷ đơn hàng này trước đó. Vui lòng chờ admin xử lý.');
        }

        try {
            $admins = User::where('role_id', 1)->get(); // role_id = 1 là admin
            if ($admins->isEmpty()) {
                return redirect()->back()->with('cancel-request-error', 'Không có admin nào để gửi thông báo.');
            }

            $message = "Người dùng #{$order->user_id} - {$order->user->name} yêu cầu huỷ đơn hàng #{$order->order_code}. Vui lòng kiểm tra và xử lý.";

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'   => $admin->id,                // Admin là người nhận
                    'title'     => $title,                    // Tiêu đề có thể tùy chỉnh
                    'message'   => $message,                  // Nội dung động theo tình huống
                    'type'      => 'order',                   // Phân loại là thông báo đơn hàng
                    'is_read'   => false,                     // Mặc định chưa đọc
                    'order_id'  => $order->id,                // Gắn với ID đơn hàng cụ thể
                    'created_at' => now(),                    // Đảm bảo thời gian chính xác
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi tạo thông báo đơn hàng: ' . $e->getMessage());
        }

        // Trả về thông báo thành công
        return redirect()->back()->with('cancel-request-success', 'Đã gửi yêu cầu huỷ đơn hàng thành công. Chờ admin xử lý.');
    }

public function pay(Request $request)
    {
        // Lấy pending_order_id từ session
        $orderId = session('pending_order_id');
        if (!$orderId) {
            \Log::warning('No pending_order_id found in session');
            return redirect()->route('cart.index')->with('error', 'Không tìm thấy đơn hàng để thanh toán.');
        }

        // Lấy thông tin đơn hàng
        $order = Order::with(['orderDetails.productVariant.product', 'shippingAddress'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('payment_method', 'online') // Chỉ lấy đơn hàng Momo
            ->first();

        if (!$order) {
            \Log::warning('Order not found or invalid', [
                'order_id' => $orderId,
                'user_id' => Auth::id()
            ]);
            return redirect()->route('cart.index')->with('error', 'Đơn hàng không hợp lệ hoặc không tồn tại.');
        }

        // Giả lập URL mã QR (thay bằng API Momo nếu có)
        $qrData = "momo://pay?amount={$order->total_price}&orderId={$order->id}&message=Thanh+toan+don+hang+{$order->order_code}";
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($qrData);

        return view('client.pages.pay', [
            'order' => $order,
            'qrUrl' => $qrUrl,
        ]);
    }
}
