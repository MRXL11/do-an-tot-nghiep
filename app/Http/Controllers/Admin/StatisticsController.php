<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    //

    public function index()
    {
        // Trả về view `admin.others_menu.statistical` với các biến thống kê truyền sang
        return view(
            'admin.others_menu.statistical'
        );
    }

    public function filterRevenue(Request $request)
    {
        // 👉 Nhận start và end từ URL query, nếu không có thì mặc định là 30 ngày gần nhất
        $start = Carbon::parse(
            $request->query('start', now()->subDays(29)->format('Y-m-d'))
        )->startOfDay(); // Bắt đầu từ đầu ngày
        $end = Carbon::parse(
            $request->query('end', now()->format('Y-m-d'))
        )->endOfDay(); // Kết thúc cuối ngày

        // 👉 Truy vấn tổng doanh thu mỗi ngày (chỉ lấy đơn đã hoàn thành và thanh toán)
        $rawData = Order::selectRaw('DATE(created_at) as day, SUM(total_price) as total')
            ->where('status', 'completed') // Chỉ lấy đơn đã hoàn thành
            ->where('payment_status', 'completed') // Và đã thanh toán
            ->whereBetween('created_at', [$start, $end]) // Trong khoảng ngày được chọn
            ->groupBy('day') // Gom theo ngày (tự động group theo DATE, bỏ phần giờ)
            ->orderBy('day') // Sắp xếp tăng dần theo ngày
            ->pluck('total', 'day'); // Kết quả dạng: [ '2025-07-01' => 1500000, ... ]

        // 👉 Tạo mảng đầy đủ các ngày (kể cả ngày không có đơn)
        $days = [];
        $period = \Carbon\CarbonPeriod::create($start, $end); // Tạo khoảng lặp từ start đến end

        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $days[] = [
                'day' => $key,
                'total' => $rawData[$key] ?? 0, // Nếu ngày không có doanh thu thì gán 0
            ];
        }

        // 👉 Tổng doanh thu toàn bộ khoảng ngày đang xét
        $total = $rawData->sum();

        // 👉 Tính khoảng thời gian trước đó có độ dài tương tự (để so sánh)
        $diff = $start->diffInDays($end); // Ví dụ: nếu khoảng là 30 ngày thì diff = 29
        $prevStart = $start->copy()->subDays($diff + 1); // Trừ ra khoảng trước đó
        $prevEnd = $start->copy()->subDay(); // Ngày liền trước ngày bắt đầu

        // 👉 Tổng doanh thu của khoảng thời gian trước đó
        $prevTotal = Order::where('status', 'completed')
            ->where('payment_status', 'completed')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_price');

        // 👉 Tính % tăng trưởng doanh thu (nếu có dữ liệu)
        $growthRate = $prevTotal > 0
            ? round((($total - $prevTotal) / $prevTotal) * 100, 2) // Làm tròn 2 chữ số
            : null; // Nếu tháng trước không có đơn thì trả về null

        // 👉 Trả về JSON phục vụ frontend hiển thị biểu đồ & tổng quan
        return response()->json([
            'days' => $days, // Dữ liệu từng ngày để vẽ biểu đồ
            'total' => round((float) $total), // Tổng doanh thu hiện tại
            'prev_total' => round((float) $prevTotal), // Tổng doanh thu kỳ trước
            'growth_rate' => $growthRate, // Tỷ lệ tăng trưởng (%)
        ]);
    }

    public function getOrdersPerDay(Request $request)
    {
        $start = Carbon::parse($request->query('start', now()->subDays(6)->format('Y-m-d')))->startOfDay();
        $end = Carbon::parse($request->query('end', now()->format('Y-m-d')))->endOfDay();

        // Truy vấn đơn hàng không huỷ, nhóm theo ngày
        $rawData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'cancelled')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Tạo mảng dữ liệu đủ ngày (kể cả không có đơn)
        $days = collect();
        $period = Carbon::parse($start)->toPeriod($end);
        foreach ($period as $date) {
            $d = $date->format('Y-m-d');
            $days->push([
                'date' => $d,
                'total' => $rawData->firstWhere('date', $d)->total ?? 0,
            ]);
        }

        // ✅ Tính tổng số đơn trong toàn khoảng thời gian
        $totalOrders = $days->sum('total');

        // ✅ Trả JSON cho frontend
        return response()->json([
            'days' => $days,               // dữ liệu theo ngày
            'total_orders' => $totalOrders // tổng đơn hàng
        ]);
    }

    public function getTopSellingProducts(Request $request)
    {
        // ✅ Lấy ngày bắt đầu và kết thúc từ query string (nếu không có thì lấy 30 ngày gần nhất)
        $start = Carbon::parse(
            $request->query('start', now()->subDays(29)->format('Y-m-d'))
        )->startOfDay(); // Bắt đầu từ đầu ngày

        $end = Carbon::parse(
            $request->query('end', now()->format('Y-m-d'))
        )->endOfDay(); // Đến cuối ngày hôm nay

        // ✅ Truy vấn top sản phẩm bán chạy theo biến thể trong khoảng thời gian
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')

            // ✅ Chỉ tính đơn hàng đã hoàn thành trong khoảng thời gian
            ->whereBetween('orders.created_at', [$start, $end])
            ->where('orders.status', 'completed') // Trạng thái đã hoàn thành
            ->where('orders.payment_status', 'completed') // Đã thanh toán

            // ✅ Chọn các thông tin cần thiết
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'product_variants.image',
                'product_variants.price',
                'product_variants.color',
                'product_variants.size',
                DB::raw('SUM(order_details.quantity) as total_sold')
            )

            // ✅ Nhóm theo từng biến thể sản phẩm
            ->groupBy(
                'products.id',
                'products.name',
                'product_variants.image',
                'product_variants.price',
                'product_variants.color',
                'product_variants.size'
            )

            // ✅ Lấy top 10 theo số lượng bán
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return response()->json($topProducts);
    }

    public function orderStatusByDate(Request $request)
    {
        $start = Carbon::parse($request->query('start', now()->subDays(29)->format('Y-m-d')))->startOfDay();
        $end = Carbon::parse($request->query('end', now()->format('Y-m-d')))->endOfDay();

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'];

        $orderCounts = DB::table('orders')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('status')
            ->pluck('count', 'status');

        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $canceledOrders = $orderCounts['cancelled'] ?? 0;
        $cancelRate = $totalOrders > 0 ? round(($canceledOrders / $totalOrders) * 100, 2) : 0;

        return response()->json([
            'statusCounts' => $statuses,
            'counts' => array_map(fn($status) => $orderCounts[$status] ?? 0, $statuses),
            'cancelRate' => $cancelRate
        ]);
    }


    public function lowStockVariants()
    {
        $variants = ProductVariant::with('product') // Load quan hệ để lấy tên sản phẩm
            ->where('stock_quantity', '<', 20)
            ->where('status', 'active')
            ->orderBy('stock_quantity', 'asc') // Sắp xếp tồn kho tăng dần
            ->get();

        return response()->json($variants);
    }

    public function getPendingReviews(Request $request)
    {
        $reviews = Review::with(['user', 'product'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($reviews);
    }
}
