<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Order::with(['user', 'shippingAddress', 'orderDetails.productVariant', 'coupon']);
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

        // Lấy danh sách sản phẩm với phân trang
        $orders = $query->orderByDesc('id')->paginate(10);

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

        // Lấy trạng thái mới từ request
        $newStatus = $request->input('status');

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

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }

    public function cancel(Order $order)
    {
        if (in_array($order->status, ['delivered', 'cancelled'])) {
            return redirect()->back()->with('error', 'Không thể huỷ đơn hàng đã hoàn tất hoặc đã huỷ.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Đã huỷ đơn hàng thành công.');
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
