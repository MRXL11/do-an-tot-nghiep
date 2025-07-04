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
        // Thời gian bắt đầu và kết thúc ngày hôm nay
        $todayStart = Carbon::today();
        $todayEnd = Carbon::tomorrow();

        // Đếm số đơn hàng hôm nay
        $orderTodayCount = Order::where('created_at', '>=', $todayStart)
            ->where('created_at', '<', $todayEnd)
            ->count();

        // (Tuỳ chọn) Đơn hàng hôm qua để so sánh tăng/giảm %
        $yesterdayStart = Carbon::yesterday();
        $yesterdayEnd = Carbon::today();
        $orderYesterdayCount = Order::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->count();

        // Tính phần trăm tăng giảm
        $percentChange = 0;
        if ($orderYesterdayCount > 0) {
            $percentChange = (($orderTodayCount - $orderYesterdayCount) / $orderYesterdayCount) * 100;
        }

        // Truy vấn số đơn hàng mỗi ngày trong 7 ngày gần nhất
        $orderLast7Days = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->where('created_at', '<=', Carbon::now()->endOfDay())
            ->where('status', '!=', 'cancelled')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Format lại dữ liệu cho đủ 7 ngày (nếu có ngày không có đơn thì fill 0)
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $days->push([
                'date' => $day,
                'total' => $orderLast7Days->firstWhere('date', $day)->total ?? 0,
            ]);
        }

        return view(
            'admin.others_menu.statistical',
            [
                'orderTodayCount' => $orderTodayCount,
                'percentChange' => $percentChange,
                'orderLast7Days' => $days
            ]
        );
    }

    public function filterRevenue(Request $request)
    {
        // lấy tháng theo bộ lọc hoặc mặc định là tháng hioeenj tại
        $month = $request->query('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->isSameMonth(now()) ? now()->endOfDay() : $start->copy()->endOfMonth();

        $rawData = Order::selectRaw('DATE(created_at) as day, SUM(total_price) as total')
            ->where('status', 'delivered')
            ->where('payment_status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        $days = [];
        $period = \Carbon\CarbonPeriod::create($start, $end);
        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $days[] = [
                'day' => $key,
                'total' => $rawData[$key] ?? 0,
            ];
        }

        // tính tổng doanh thu của tháng được chọn
        $monthlyTotal = $rawData->sum();

        // ✅ Tính doanh thu tháng trước
        $prevStart = $start->copy()->subMonth()->startOfMonth();
        $prevEnd = $start->copy()->subMonth()->endOfMonth();

        $prevMonthlyTotal = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->where('payment_status', 'completed')
            ->sum('total_price');

        // ✅ Tính phần trăm thay đổi (tránh chia 0)
        $growthRate = $prevMonthlyTotal > 0
            ? round((($monthlyTotal - $prevMonthlyTotal) / $prevMonthlyTotal) * 100, 2)
            : null;

        return response()->json([
            'month' => $month,
            'days' => $days,
            'monthly_total' => round((float) $monthlyTotal), // 👈 CHẮC CHẮN LÀ SỐ NGUYÊN
            'prev_month_total' => round((float) $prevMonthlyTotal),
            'growth_rate' => $growthRate,
        ]);
    }


    public function getTopSellingProducts(Request $request)
    {
        // Lấy tháng cần thống kê, mặc định là tháng hiện tại nếu không có input
        $month = $request->input('month', now()->format('Y-m'));
        [$year, $monthNum] = explode('-', $month);

        // Truy vấn thống kê top sản phẩm bán chạy theo biến thể
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $monthNum)
            ->where('orders.status', '!=', 'cancelled') // Bỏ các đơn đã huỷ
            ->where('orders.status', '=', 'delivered')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'product_variants.image',
                'product_variants.price',
                'product_variants.color',
                'product_variants.size',
                DB::raw('SUM(order_details.quantity) as total_sold')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'product_variants.image',
                'product_variants.price',
                'product_variants.color',
                'product_variants.size'
            )
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return response()->json($topProducts);
    }

    public function orderStatusByMonth(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        $year = (int)substr($month, 0, 4);
        $monthNum = (int)substr($month, 5, 2);

        // Đếm số đơn theo từng trạng thái
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $orderCounts = DB::table('orders')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->groupBy('status')
            ->pluck('count', 'status');

        // Tính tỷ lệ huỷ đơn
        $totalOrders = DB::table('orders')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->count();

        $canceledOrders = $orderCounts['cancelled'] ?? 0;
        // tính tỷ lệ huỷ đơn
        $cancelRate = $totalOrders > 0 ? round(($canceledOrders / $totalOrders) * 100, 2) : 0;

        return response()->json([
            'statusCounts' => $statuses,
            'counts' => array_map(fn($status) => $orderCounts[$status] ?? 0, $statuses),
            'cancelRate' => $cancelRate,
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
            ->where('status', 'pending') // Giả sử cột này là trạng thái duyệt
            ->latest()
            ->take(10)
            ->get();

        return response()->json($reviews);
    }
}
