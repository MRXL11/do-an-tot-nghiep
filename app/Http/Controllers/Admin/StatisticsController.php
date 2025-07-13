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
            // ✅ Lấy khoảng thời gian cần thống kê từ request, mặc định là 30 ngày gần nhất
            $start = Carbon::parse($request->query('start', now()->subDays(29)->format('Y-m-d')))->startOfDay();
            $end = Carbon::parse($request->query('end', now()->format('Y-m-d')))->endOfDay();

            /*
        |--------------------------------------------------------------------------
        | PHẦN 1: LẤY DỮ LIỆU THEO NGÀY
        |--------------------------------------------------------------------------
        */

            // ✅ Lấy doanh thu theo ngày từ bảng orders (tránh lặp bằng cách không JOIN)
            $revenueData = DB::table('orders')
                ->selectRaw('DATE(created_at) as day, SUM(total_price) as revenue')
                ->where('status', 'completed')
                ->where('payment_status', 'completed')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day'); // Trả về collection với key là ngày (YYYY-MM-DD)

            // ✅ Lấy lợi nhuận theo ngày bằng cách JOIN với order_details
            $profitData = DB::table('orders')
                ->selectRaw('
                    DATE(orders.created_at) as day,
                    SUM(orders.total_price) as total_price
                ')
                ->where('status', 'completed')
                ->where('payment_status', 'completed')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');

            // Tổng giá vốn theo ngày
            $costData = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->selectRaw('
                    DATE(orders.created_at) as day,
                    SUM(order_details.import_price * order_details.quantity) as total_cost
                ')
                ->where('orders.status', 'completed')
                ->where('orders.payment_status', 'completed')
                ->whereBetween('orders.created_at', [$start, $end])
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');


            /*
        |--------------------------------------------------------------------------
        | PHẦN 2: CHUẨN HÓA DỮ LIỆU THEO TỪNG NGÀY
        |--------------------------------------------------------------------------
        */

            $days = []; // Mảng chứa dữ liệu theo ngày để trả về
            $period = CarbonPeriod::create($start, $end); // Tạo danh sách ngày từ start -> end

            $totalRevenue = 0;
            $totalProfit = 0;

            foreach ($period as $date) {
                $key = $date->format('Y-m-d');

                $revenue = $revenueData[$key]->revenue ?? 0;
                $total_price = $profitData[$key]->total_price ?? 0;
                $total_cost = $costData[$key]->total_cost ?? 0;

                $profit = $total_price - $total_cost;

                $days[] = [
                    'day' => $key,
                    'revenue' => round((float)$revenue),
                    'profit' => round((float)$profit),
                ];

                $totalRevenue += $revenue;
                $totalProfit += $profit;
            }

            /*
        |--------------------------------------------------------------------------
        | PHẦN 3: TÍNH DOANH THU KỲ TRƯỚC VÀ TỈ LỆ TĂNG TRƯỞNG
        |--------------------------------------------------------------------------
        */

            // ✅ Xác định kỳ trước: dài bằng số ngày hiện tại, nằm trước khoảng hiện tại
            $diff = $start->diffInDays($end);
            $prevStart = $start->copy()->subDays($diff + 1);
            $prevEnd = $start->copy()->subDay();

            // ✅ Tổng doanh thu kỳ trước
            $prevTotal = DB::table('orders')
                ->where('status', 'completed')
                ->where('payment_status', 'completed')
                ->whereBetween('created_at', [$prevStart, $prevEnd])
                ->sum('total_price');

            // ✅ Tính tỷ lệ tăng trưởng: ((hiện tại - kỳ trước) / kỳ trước) * 100
            $growthRate = $prevTotal > 0
                ? round((($totalRevenue - $prevTotal) / $prevTotal) * 100, 2)
                : null;

            /*
        |--------------------------------------------------------------------------
        | PHẦN 4: TRẢ VỀ DỮ LIỆU DẠNG JSON
        |--------------------------------------------------------------------------
        */

            return response()->json([
                'days' => $days, // Dữ liệu từng ngày
                'total' => round((float)$totalRevenue), // Tổng doanh thu
                'total_profit' => round((float)$totalProfit), // Tổng lợi nhuận
                'prev_total' => round((float)$prevTotal), // Tổng doanh thu kỳ trước
                'growth_rate' => $growthRate, // Tỷ lệ tăng trưởng (%)
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi, trả về thông tin lỗi rõ ràng để dễ debug
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
