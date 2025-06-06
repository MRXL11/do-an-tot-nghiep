<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Order::with(['user', 'shippingAddress', 'orderDetails.productVariant', 'coupon']);
        $statuses = [
            'pending' => 'Đang chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã giao',
            'delivered' => 'Đã hoàn thành',
            'cancelled' => 'Đã hủy',
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
}
