<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ReturnRequest;
use App\Models\Review;
use Carbon\CarbonPeriod;
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
        try {
            // ✅ Lấy khoảng thời gian cần thống kê, mặc định 30 ngày gần nhất
            $start = Carbon::parse($request->query('start', now()->subDays(29)->format('Y-m-d')))->startOfDay();
            $end = Carbon::parse($request->query('end', now()->format('Y-m-d')))->endOfDay();

            /*
        |--------------------------------------------------------------------------
        | PHẦN 1: LẤY DOANH THU & GIÁ VỐN THEO NGÀY
        |--------------------------------------------------------------------------
        */

            // ✅ Lấy doanh thu theo ngày (đơn đã giao hoặc hoàn thành và đã thanh toán)
            $revenueData = DB::table('orders')
                ->selectRaw('DATE(created_at) as day, SUM(total_price) as revenue')
                ->whereIn('status', ['delivered', 'completed'])
                ->whereIn('payment_status', ['pending', 'completed'])
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day'); // Trả về collection dạng ['2025-07-01' => object]

            // ✅ Lấy giá vốn theo ngày từ order_details
            $costData = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->selectRaw('DATE(orders.created_at) as day, SUM(order_details.import_price * order_details.quantity) as total_cost')
                ->whereIn('orders.status', ['delivered', 'completed'])
                ->whereIn('orders.payment_status', ['pending', 'completed'])
                ->whereBetween('orders.created_at', [$start, $end])
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');

            /*
        |--------------------------------------------------------------------------
        | PHẦN 2: CHUẨN HÓA DỮ LIỆU THEO NGÀY
        |--------------------------------------------------------------------------
        */

            $days = []; // Danh sách kết quả từng ngày
            $period = CarbonPeriod::create($start, $end); // Mỗi ngày trong khoảng thời gian

            $totalRevenue = 0; // Tổng doanh thu toàn kỳ
            $totalProfit = 0;  // Tổng lợi nhuận toàn kỳ

            foreach ($period as $date) {
                $key = $date->format('Y-m-d');

                // Doanh thu ngày đó (nếu không có thì 0)
                $revenue = (float) ($revenueData[$key]->revenue ?? 0);

                // Giá vốn ngày đó
                $cost = (float) ($costData[$key]->total_cost ?? 0);

                // Lợi nhuận = doanh thu - giá vốn
                $profit = $revenue - $cost;

                // Lưu vào mảng trả về
                $days[] = [
                    'day' => $key,
                    'revenue' => round($revenue),
                    'profit' => round($profit),
                ];

                // Cộng dồn
                $totalRevenue += $revenue;
                $totalProfit += $profit;
            }

            /*
        |--------------------------------------------------------------------------
        | PHẦN 3: DOANH THU KỲ TRƯỚC & TỶ LỆ TĂNG TRƯỞNG
        |--------------------------------------------------------------------------
        */

            // ✅ Xác định kỳ trước: cùng độ dài, liền trước giai đoạn hiện tại
            $diff = $start->diffInDays($end);
            $prevStart = $start->copy()->subDays($diff + 1);
            $prevEnd = $start->copy()->subDay();

            // ✅ Tổng doanh thu kỳ trước
            $prevTotal = DB::table('orders')
                ->whereIn('status', ['delivered', 'completed'])
                ->where('payment_status', 'completed')
                ->whereBetween('created_at', [$prevStart, $prevEnd])
                ->sum('total_price');

            // ✅ Tính tỷ lệ tăng trưởng (%)
            $growthRate = $prevTotal > 0
                ? round((($totalRevenue - $prevTotal) / $prevTotal) * 100, 2)
                : null;

            /*
        |--------------------------------------------------------------------------
        | PHẦN 4: TRẢ DỮ LIỆU VỀ DẠNG JSON
        |--------------------------------------------------------------------------
        */

            return response()->json([
                'days' => $days,                            // Dữ liệu từng ngày
                'total' => round($totalRevenue),           // Tổng doanh thu
                'total_profit' => round($totalProfit),     // Tổng lợi nhuận
                'prev_total' => round($prevTotal),         // Doanh thu kỳ trước
                'growth_rate' => $growthRate,              // Tỷ lệ tăng trưởng
            ]);
        } catch (\Exception $e) {
            // Trả lỗi nếu có exception
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
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

    public function getPendingReviews()
    {
        $reviews = Review::with(['user', 'product'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($reviews);
    }

    public function getLatestReturnRequests()
    {
        $today = now()->startOfDay(); // Ngày hôm nay

        $returns = ReturnRequest::with(['user', 'order.shippingAddress'])
            ->where(function ($query) use ($today) {
                $query->whereDate('created_at', now()->toDateString()) // Yêu cầu trong ngày hôm nay
                    ->orWhere(function ($sub) use ($today) {
                        $sub->where('status', 'requested') // Hoặc các yêu cầu chưa xử lý
                            ->where('created_at', '<', $today); // Từ những ngày trước
                    });
            })
            ->latest()
            ->take(20) // tuỳ ý
            ->get()
            ->map(function ($item) {
                // Ép kiểu để tránh lỗi JS khi parse JSON
                if ($item->order && $item->order->shipping_address) {
                    $item->order->shipping_address->phone_number = (string) $item->order->shipping_address->phone_number;
                }
                return $item;
            });

        return response()->json($returns);
    }
}
