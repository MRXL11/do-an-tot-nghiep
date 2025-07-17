<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Order::with(['user', 'shippingAddress', 'orderDetails.productVariant', 'coupon', 'returnRequest'])
            ->orderByDesc('created_at');
        $statuses = [
            'pending' => 'Đang chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao',
            'delivered' => 'Đã hoàn thành',
            'cancelled' => 'Đơn đã hủy',
        ];
        $q = request()->query('q');
        $hasSearch = false;

        // Lọc theo tên sản phẩm
        if ($request->filled('q')) {
            $query->where('order_code', 'like', '%' . $request->q . '%');
            $hasSearch = true;
        }
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
            $hasSearch = true;
        }

        // Lấy danh sách sản phẩm, ưu tiên đơn online đã thnah toán,
        //  nhưng nếu có đơn cod chen ngang thì vẫn hiện đơn cod với phân trang
        $orders = $query
            ->orderByRaw("CASE 
                WHEN payment_method = 'online' THEN 1
                WHEN payment_method = 'cod' THEN 2
                ELSE 3
                END")
            ->orderByDesc('created_at') // đơn mới nhất trước
            ->paginate(10);

        // Kiểm tra nếu có tìm kiếm nhưng không có kết quả
        $noResults = $hasSearch && $orders->isEmpty();

        // dd($orders);
        return view('admin.orders.orders', compact('orders', 'statuses', 'noResults'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'shippingAddress', 'orderDetails.productVariant.product', 'coupon')
            ->findOrFail($id);

        $discount = 0;
        $total = $order->total_price;

        // Tính toán giảm giá nếu có coupon
        if ($order->coupon) {
            if ($order->coupon->discount_type === 'fixed') {
                $discount = $order->coupon->discount_value;
            } elseif ($order->coupon->discount_type === 'percent') {
                $discount = round($total * $order->coupon->discount_value / 100);
            }
        }

        return view('admin.orders.show', compact('order', 'discount', 'total'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatusLabel = Order::getStatusMeta($order->status)['label'];


        // Lấy trạng thái mới từ request
        $newStatus = $request->input('status');
        $newStatusLabel = Order::getStatusMeta($newStatus)['label'];

        // Mảng trạng thái hợp lệ và chuyển đổi
        $validTransitions = [
            'pending' => 'processing',
            'processing' => 'shipped',
            'shipped' => 'delivered',
        ];

        if (!isset($validTransitions[$order->status]) || $validTransitions[$order->status] !== $newStatus) {
            return redirect()->back()->with('error', 'Chuyển trạng thái không hợp lệ.');
        }

        // Lưu trạng thái mới
        $order->status = $newStatus;
        $order->save();

        // Tạo thông báo cho người dùng
        $message = "Trạng thái đơn hàng #{$order->order_code} đã được cập nhật từ '{$oldStatusLabel}' thành '{$newStatusLabel}'.";
        $this->createOrderNotificationToClient($order, $message, 'Đơn hàng đã được cập nhật');

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }

    public function cancel(Order $order)
    {
        if (in_array($order->status, ['delivered', 'completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Không thể huỷ đơn hàng đã hoàn tất hoặc đã huỷ.');
        }

        $order->status = 'cancelled';
        $order->payment_status = 'failed';
        $order->save();

        // Tạo thông báo cho người dùng
        $message = "Đơn hàng #{$order->order_code} đã được huỷ.";
        $this->createOrderNotificationToClient($order, $message, 'Đơn hàng đã được huỷ');

        return redirect()->back()->with('success', 'Đã huỷ đơn hàng thành công.');
    }

    public function updateReturnStatus(Request $request, $id)
    {
        // Lấy return request cần cập nhật
        $returnRequest = ReturnRequest::with('order.user')->findOrFail($id);

        // Lưu trạng thái cũ
        $oldStatus = $returnRequest->status;
        $oldLabel = $returnRequest->return_status['label'];

        // Lấy trạng thái mới từ request
        $newStatus = $request->input('status');
        $newLabel = ReturnRequest::getStatusLabelStatic($newStatus)['label'] ?? 'Không xác định';

        // Xác định các trạng thái chuyển đổi hợp lệ (giả sử flow logic)
        $validTransitions = [
            'requested' => ['approved', 'rejected'],
            'approved' => ['refunded'],
        ];

        // Kiểm tra trạng thái chuyển đổi hợp lệ
        if (!isset($validTransitions[$oldStatus]) || !in_array($newStatus, $validTransitions[$oldStatus])) {
            return redirect()->back()->with('error', 'Chuyển trạng thái không hợp lệ.');
        }

        // Cập nhật trạng thái mới
        $returnRequest->status = $newStatus;
        // Cập nhật trạng thái thanh toán của hoá đơn
        if ($newStatus === 'refunded') {
            $returnRequest->order->payment_status = 'failed';
            $returnRequest->order->save();
        }
        // Cập nhật trạng thái trả hàng
        $returnRequest->save();

        // Gửi thông báo đến người dùng
        try {
            $user = $returnRequest->order->user;

            Notification::create([
                'user_id'   => $user->id,
                'title'     => 'Cập nhật yêu cầu trả hàng',
                'message'   => "Yêu cầu trả hàng của đơn #{$returnRequest->order->order_code} đã được cập nhật từ '{$oldLabel}' thành '{$newLabel}'.",
                'type'      => 'order',
                'is_read'   => false,
                'order_id'  => $returnRequest->order->id,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi gửi thông báo cập nhật trả hàng: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái trả hàng thành công.');
    }

    public function createOrderNotificationToClient(Order $order, $message, $title)
    {
        try {
            $client = $order->user; // Người đã đặt đơn

            // Kiểm tra nếu người dùng không tồn tại
            if (!$client) {
                Log::warning("Đơn hàng #{$order->id} không có người dùng liên kết.");
                return;
            }

            // Tạo thông báo cho người dùng
            Notification::create([
                'user_id'    => $client->id,
                'title'      => $title,
                'message'    => $message,
                'type'       => 'order',
                'is_read'    => false,
                'order_id'   => $order->id,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi tạo thông báo đơn hàng: ' . $e->getMessage());
        }
    }

    private function createOrderNotification(Order $order, string $message, string $title = 'Cập nhật đơn hàng')
    {
        try {
            $admins = User::where('role_id', 1)->get(); // role_id = 1 là admin

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
    }
}
