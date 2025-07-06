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
        // Khởi tạo thời gian bắt đầu và kết thúc của ngày hôm nay
        $todayStart = Carbon::today();    // 00:00:00 hôm nay
        $todayEnd = Carbon::tomorrow();   // 00:00:00 ngày mai (tức là kết thúc hôm nay)

        // Đếm số lượng đơn hàng được tạo trong ngày hôm nay
        $orderTodayCount = Order::where('created_at', '>=', $todayStart) // các đơn hàng từ sau 00:00 hôm nay
            ->where('created_at', '<', $todayEnd)                         // và trước 00:00 ngày mai
            ->count();                                                    // đếm tổng số đơn hàng

        // (Tuỳ chọn) Tính số đơn hàng của ngày hôm qua để dùng cho việc so sánh % tăng/giảm
        $yesterdayStart = Carbon::yesterday();  // 00:00:00 hôm qua
        $yesterdayEnd = Carbon::today();        // 00:00:00 hôm nay
        $orderYesterdayCount = Order::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->count(); // đếm đơn hàng trong ngày hôm qua

        // Khởi tạo biến phần trăm thay đổi (mặc định = 0 nếu không có đơn hôm qua)
        $percentChange = 0;
        if ($orderYesterdayCount > 0) {
            // Tính phần trăm thay đổi: ((hôm nay - hôm qua) / hôm qua) * 100
            $percentChange = (($orderTodayCount - $orderYesterdayCount) / $orderYesterdayCount) * 100;
        }

        // Truy vấn số lượng đơn hàng (không bị huỷ) trong 7 ngày gần nhất
        $orderLast7Days = Order::select(
            DB::raw('DATE(created_at) as date'),      // lấy phần ngày từ created_at
            DB::raw('COUNT(*) as total')              // đếm tổng số đơn theo từng ngày
        )
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay()) // từ 6 ngày trước tới nay
            ->where('created_at', '<=', Carbon::now()->endOfDay())              // đến hết hôm nay
            ->where('status', '!=', 'cancelled')                                // loại trừ đơn bị huỷ
            ->groupBy(DB::raw('DATE(created_at)'))                              // nhóm theo ngày
            ->orderBy('date')                                                   // sắp xếp theo ngày tăng dần
            ->get();

        // Tạo collection `$days` để chứa dữ liệu 7 ngày liên tục (kể cả ngày không có đơn)
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            // Tính ngày tương ứng từ 6 ngày trước đến hôm nay
            $day = Carbon::now()->subDays($i)->format('Y-m-d');

            // Tìm tổng đơn theo ngày, nếu không có thì gán là 0
            $days->push([
                'date' => $day,                                                          // ngày
                'total' => $orderLast7Days->firstWhere('date', $day)->total ?? 0,        // số đơn hàng hôm đó hoặc 0 nếu không có
            ]);
        }

        // Trả về view `admin.others_menu.statistical` với các biến thống kê truyền sang
        return view(
            'admin.others_menu.statistical',
            [
                'orderTodayCount' => $orderTodayCount,  // số đơn hôm nay
                'percentChange' => $percentChange,      // phần trăm thay đổi so với hôm qua
                'orderLast7Days' => $days               // danh sách đơn hàng 7 ngày gần nhất
            ]
        );
    }

    public function filterRevenue(Request $request)
    {
        // Lấy tham số 'month' từ URL (dạng YYYY-MM), nếu không có thì mặc định là tháng hiện tại
        $month = $request->query('month', now()->format('Y-m'));

        // Tạo thời gian bắt đầu và kết thúc của tháng được chọn
        $start = Carbon::parse($month . '-01')->startOfMonth(); // Bắt đầu từ ngày 01 của tháng đó
        $end = $start->isSameMonth(now())
            ? now()->endOfDay()               // Nếu là tháng hiện tại, lấy tới thời điểm hiện tại trong ngày
            : $start->copy()->endOfMonth();   // Nếu là tháng trước, lấy tới cuối tháng

        // Truy vấn tổng doanh thu theo từng ngày trong tháng
        $rawData = Order::selectRaw('DATE(created_at) as day, SUM(total_price) as total') // Lấy ngày và tổng doanh thu theo ngày
            ->where('status', 'completed')               // Chỉ lấy đơn đã hoàn thành
            ->where('payment_status', 'completed')       // Và đã thanh toán thành công
            ->whereBetween('created_at', [$start, $end]) // Trong khoảng thời gian đã chọn
            ->groupBy('day')                             // Nhóm theo từng ngày
            ->orderBy('day')                             // Sắp xếp theo ngày tăng dần
            ->pluck('total', 'day');                     // Trả về dạng mảng: key là ngày, value là tổng tiền

        // Tạo mảng dữ liệu thống kê từng ngày trong tháng
        $days = [];
        $period = \Carbon\CarbonPeriod::create($start, $end); // Tạo khoảng thời gian từ đầu đến cuối tháng

        foreach ($period as $date) {
            $key = $date->format('Y-m-d'); // Format ngày về dạng chuỗi
            $days[] = [
                'day' => $key,                         // Ngày thống kê
                'total' => $rawData[$key] ?? 0,        // Nếu không có dữ liệu thì gán 0
            ];
        }

        // Tính tổng doanh thu của tháng hiện tại
        $monthlyTotal = $rawData->sum(); // Do `$rawData` là Collection nên dùng được `sum()`

        // ✅ Tính khoảng thời gian của tháng trước
        $prevStart = $start->copy()->subMonth()->startOfMonth(); // Đầu tháng trước
        $prevEnd = $start->copy()->subMonth()->endOfMonth();     // Cuối tháng trước

        // ✅ Truy vấn tổng doanh thu của tháng trước
        $prevMonthlyTotal = Order::where('status', 'completed')                // Đơn đã hoàn thành
            ->whereBetween('created_at', [$prevStart, $prevEnd])              // Trong tháng trước
            ->where('payment_status', 'completed')                            // Đã thanh toán
            ->sum('total_price');                                             // Tính tổng doanh thu

        // ✅ Tính phần trăm tăng trưởng doanh thu so với tháng trước
        $growthRate = $prevMonthlyTotal > 0
            ? round((($monthlyTotal - $prevMonthlyTotal) / $prevMonthlyTotal) * 100, 2) // Nếu tháng trước có doanh thu
            : null; // Nếu không có, tránh chia cho 0

        // Trả về JSON cho frontend (dùng cho biểu đồ hoặc dashboard)
        return response()->json([
            'month' => $month,                                      // Tháng đang thống kê
            'days' => $days,                                        // Danh sách doanh thu từng ngày
            'monthly_total' => round((float) $monthlyTotal),        // Tổng doanh thu tháng hiện tại (làm tròn số)
            'prev_month_total' => round((float) $prevMonthlyTotal), // Tổng doanh thu tháng trước (làm tròn số)
            'growth_rate' => $growthRate,                           // Tỉ lệ tăng trưởng (%)
        ]);
    }

    public function getTopSellingProducts(Request $request)
    {
        // ✅ Lấy giá trị 'month' từ request đầu vào, nếu không có thì mặc định là tháng hiện tại (định dạng YYYY-MM)
        $month = $request->input('month', now()->format('Y-m'));

        // ✅ Tách chuỗi tháng thành $year và $monthNum để sử dụng trong truy vấn
        [$year, $monthNum] = explode('-', $month);

        // ✅ Truy vấn dữ liệu top sản phẩm bán chạy theo biến thể trong tháng được chọn
        $topProducts = DB::table('order_details')
            // Join với bảng orders để lấy thời gian đặt hàng và trạng thái
            ->join('orders', 'order_details.order_id', '=', 'orders.id')

            // Join với bảng product_variants để lấy thông tin biến thể (hình ảnh, giá, màu, size)
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')

            // Join với bảng products để lấy thông tin sản phẩm chính (tên sản phẩm)
            ->join('products', 'product_variants.product_id', '=', 'products.id')

            // Lọc các đơn hàng theo năm và tháng đã chọn
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $monthNum)

            // Bỏ qua các đơn hàng bị huỷ
            ->where('orders.status', '!=', 'cancelled')

            // Chỉ lấy đơn hàng đã hoàn thành (đã giao, đã xác nhận, v.v.)
            ->where('orders.status', '=', 'completed')

            // ✅ Chọn các cột cần thống kê, bao gồm cả thông tin sản phẩm và biến thể
            ->select(
                'products.id as product_id',              // ID sản phẩm chính
                'products.name as product_name',          // Tên sản phẩm
                'product_variants.image',                 // Ảnh biến thể
                'product_variants.price',                 // Giá biến thể
                'product_variants.color',                 // Màu
                'product_variants.size',                  // Size
                DB::raw('SUM(order_details.quantity) as total_sold') // Tổng số lượng đã bán cho mỗi biến thể
            )

            // ✅ Nhóm theo từng biến thể sản phẩm (nếu không nhóm thì SUM sẽ sai)
            ->groupBy(
                'products.id',
                'products.name',
                'product_variants.image',
                'product_variants.price',
                'product_variants.color',
                'product_variants.size'
            )

            // ✅ Sắp xếp theo tổng số lượng đã bán (giảm dần)
            ->orderByDesc('total_sold')
            // ✅ Giới hạn top 10 kết quả
            ->limit(10)
            // ✅ Thực thi truy vấn và lấy kết quả
            ->get();

        // ✅ Trả kết quả dưới dạng JSON để frontend dùng hiển thị bảng hoặc biểu đồ
        return response()->json($topProducts);
    }

    public function orderStatusByMonth(Request $request)
    {
        // ✅ Lấy tháng từ request (dạng 'YYYY-MM'), nếu không có thì mặc định là tháng hiện tại
        $month = $request->input('month', now()->format('Y-m'));

        // ✅ Tách chuỗi 'YYYY-MM' thành số năm và số tháng
        $year = (int)substr($month, 0, 4);       // Lấy 4 ký tự đầu làm năm
        $monthNum = (int)substr($month, 5, 2);   // Lấy 2 ký tự sau dấu '-' làm tháng

        // ✅ Danh sách các trạng thái đơn hàng cần thống kê
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'];

        // ✅ Truy vấn số lượng đơn hàng theo từng trạng thái trong tháng được chọn
        $orderCounts = DB::table('orders')
            ->select('status', DB::raw('COUNT(*) as count'))     // Đếm số đơn theo trạng thái
            ->whereYear('created_at', $year)                     // Lọc theo năm
            ->whereMonth('created_at', $monthNum)                // Lọc theo tháng
            ->groupBy('status')                                  // Gom nhóm theo trạng thái
            ->pluck('count', 'status');                          // Trả về dạng mảng [status => count]

        // ✅ Tính tổng số đơn hàng trong tháng
        $totalOrders = DB::table('orders')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->count();

        // ✅ Lấy số lượng đơn bị huỷ (nếu không có thì mặc định là 0)
        $canceledOrders = $orderCounts['cancelled'] ?? 0;

        // ✅ Tính tỷ lệ huỷ đơn hàng (%) = số đơn huỷ / tổng đơn * 100
        $cancelRate = $totalOrders > 0
            ? round(($canceledOrders / $totalOrders) * 100, 2)   // Làm tròn 2 chữ số sau dấu phẩy
            : 0;

        // ✅ Trả về JSON gồm:
        // - Danh sách trạng thái (đảm bảo đủ thứ tự)
        // - Mảng số lượng tương ứng từng trạng thái
        // - Tỷ lệ huỷ đơn
        return response()->json([
            'statusCounts' => $statuses, // Trả về thứ tự trạng thái (giúp frontend vẽ biểu đồ theo đúng thứ tự)
            'counts' => array_map(fn($status) => $orderCounts[$status] ?? 0, $statuses), // Mảng số lượng tương ứng từng trạng thái
            'cancelRate' => $cancelRate, // Tỷ lệ huỷ đơn hàng (%)
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
