@extends('admin.layouts.AdminLayouts')
@section('title-page')
@endsection
@section('content')
    <div class="container-fluid">

        {{-- đơn được yêu cầu trả hàng/hoàn tiền --}}
        <div class="row mb-3">
            <div class="col-lg-9">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <!-- Tiêu đề -->
                        <div class="row mb-4">
                            <div class="col d-flex justify-content-between">
                                <h4 class="fw-bold">Yêu cầu trả hàng / hoàn tiền mới nhất đang chờ xử lý</h4>
                                <a href='{{ route('admin.orders.index') }}'
                                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                    Xem tất cả</a>
                            </div>
                        </div>

                        <div style="max-height: 100px; overflow-y: auto;">
                            <table class="table table-striped align-middle mb-0">
                                <thead id="returnRequestsHead">
                                    <!-- Sẽ được render bằng JS -->
                                </thead>
                                <tbody id="returnRequestsBody">
                                    <!-- Dữ liệu sẽ được render bằng JS -->
                                </tbody>
                            </table>
                            <div class="text-center py-2 text-muted" id="noReturnRequests" style="display: none;">
                                Không có yêu cầu .
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">🔔 Thông báo hôm nay</h5>

                        <div id="notificationsCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carouselNotificationInner">
                                <!-- Các thông báo sẽ được thêm bằng JS -->
                            </div>

                            <!-- Nút điều hướng -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#notificationsCarousel"
                                data-bs-slide="prev">
                                <span class="visually-hidden">Trước</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#notificationsCarousel"
                                data-bs-slide="next">
                                <span class="visually-hidden">Sau</span>
                            </button>
                        </div>

                        <div class="text-center text-muted mt-3" id="noNotifications" style="display: none;">
                            Không có thông báo.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- Tiêu đề --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold mb-0">
                                <i class="bi bi-x-circle text-danger me-2"></i>
                                Yêu cầu huỷ đơn mới từ khách
                            </h4>
                        </div>

                        {{-- Bảng yêu cầu huỷ đơn --}}
                        <div style="max-height: 200px; overflow-y: auto;">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="table-light" id="cancelRequestTableHead">
                                    {{-- Render bằng JavaScript --}}
                                </thead>
                                <tbody id="cancelRequestTableBody">
                                    {{-- Render bằng JavaScript --}}
                                </tbody>
                            </table>

                            {{-- Thông báo khi không có dữ liệu --}}
                            <div class="text-center py-3 text-muted fst-italic" id="cancelRequestNoData"
                                style="display: none;">
                                Hiện chưa ghi nhận yêu cầu huỷ đơn mới.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bộ lọc & biểu đồ --}}
        <div class="row mb-3">
            {{-- Biểu đồ doanh thu --}}
            <div class="col-12">
                {{-- begin::doanh thu va loi nhuan --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- doanh thu và lợi nhuận --}}
                        <div class="row mb-2 mt-2">
                            <div class="col text-center">
                                <h2 class="fw-bold text-primary" id="revenue-title">
                                    <i class="bi bi-graph-up-arrow me-2"></i> Doanh thu & Lợi nhuận
                                </h2>
                            </div>
                        </div>

                        {{-- Thanh thông tin và bộ lọc --}}
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                            {{-- Tổng doanh thu và lợi nhuận --}}
                            <div>
                                <h5 class="fw-semibold mb-0" id="revenue-total">
                                    <!-- Nội dung được JS cập nhật -->
                                </h5>
                                <h5 class="fw-semibold mb-0" id="profit-total">
                                    <!-- Nội dung được JS cập nhật -->
                                </h5>
                            </div>

                            {{-- Bộ lọc ngày --}}
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group">
                                    <label class="input-group-text bg-white" for="startDate">
                                        <i class="bi bi-calendar-event"></i>
                                    </label>
                                    <input type="date" id="startDate" class="form-control" style="max-width: 160px;">
                                </div>

                                <span class="fw-semibold">–</span>

                                <div class="input-group">
                                    <label class="input-group-text bg-white" for="endDate">
                                        <i class="bi bi-calendar-check"></i>
                                    </label>
                                    <input type="date" id="endDate" class="form-control" style="max-width: 160px;">
                                </div>

                                <button class="btn btn-primary d-flex align-items-center gap-1" onclick="applyDateFilter()">
                                    <i class="bi bi-funnel-fill"></i> Lọc
                                </button>
                            </div>
                        </div>

                        {{-- Biểu đồ --}}
                        <div class="border rounded bg-light p-3" style="overflow-x: auto;">
                            <canvas id="revenueChart" height="500"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- đơn hàng theo ngày và top sản phẩm bán chạy của tháng --}}
        <div class="row">
            {{-- đơn hàng --}}
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header border-0">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                            <!-- Tổng số đơn -->
                            <h3 id="order-total-text" class="fw-bold mb-0 card-title">
                                Tổng số đơn:</h3>

                            <!-- Bộ lọc ngày -->
                            <div class="d-flex align-items-center gap-2">
                                <input type="date" id="orderStartDate" class="form-control"
                                    style="max-width: 160px;">
                                <input type="date" id="orderEndDate" class="form-control" style="max-width: 160px;">
                                <button class="btn btn-primary" onclick="filterOrderChart()">Lọc</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Nếu có biểu đồ mini cho đơn hàng hôm nay/tuần --}}
                        <div class="position-relative mb-4">
                            <canvas id="ordersTodayChart" height="200"></canvas>
                        </div>

                    </div>
                </div>
            </div>

            {{-- sản phẩm --}}
            <div class="col-lg-6">
                <!-- Tiêu đề -->
                <div class="row mb-4">
                    <div class="col">
                        <h4 class="fw-bold " id="top-products-title">Top sản phẩm bán chạy nhất
                        </h4>
                    </div>
                </div>
                <!-- begin::san pham ban chay-->
                <div style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-striped align-middle" id="topProductsTable">
                        <tbody>
                            <!-- Dữ liệu sản phẩm sẽ được JS thêm vào đây -->
                        </tbody>
                    </table>
                </div>
                <!-- end::san pham ban chay-->
            </div>
        </div>

        {{-- tổng đơn hàng theo từng trạng thái của tháng --}}
        <div class="row">
            {{-- Biểu đồ tỷ lệ huỷ đơn --}}
            <div class="col-lg-3">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Tỷ lệ huỷ đơn</h5>
                    <div class="card-body text-center">
                        <canvas id="cancelRateChart" height="250"></canvas>
                        <div id="cancelRateText" class="mt-3 fw-bold text-danger fs-5"></div>
                    </div>
                </div>
            </div>

            {{-- Biểu đồ số đơn theo trạng thái --}}
            <div class="col-lg-9">
                <div class="card mb-4 shadow-sm">
                    {{-- Tiêu đề + Bộ lọc ngày --}}
                    <div class="card-header border-0 bg-light">
                        <div class="row align-items-center">
                            {{-- Bên trái: Tiêu đề --}}
                            <div class="col-md-6 mb-2 mb-md-0">
                                <h5 class="fw-bold text-primary m-0 d-flex align-items-center">
                                    <i class="bi bi-bar-chart-fill me-2"></i>
                                    Trạng thái đơn hàng
                                </h5>
                            </div>

                            {{-- Bên phải: Bộ lọc ngày --}}
                            <div class="col-md-6 text-md-end">
                                <div class="d-flex justify-content-md-end gap-2 align-items-center">
                                    <div class="input-group">
                                        <label class="input-group-text bg-white" for="orderStatusStartDate">
                                            <i class="bi bi-calendar-event"></i>
                                        </label>
                                        <input type="date" id="orderStatusStartDate" class="form-control"
                                            style="max-width: 160px;">
                                    </div>

                                    <span class="fw-semibold">–</span>

                                    <div class="input-group">
                                        <label class="input-group-text bg-white" for="orderStatusEndDate">
                                            <i class="bi bi-calendar-check"></i>
                                        </label>
                                        <input type="date" id="orderStatusEndDate" class="form-control"
                                            style="max-width: 160px;">
                                    </div>

                                    <button class="btn btn-primary d-flex align-items-center gap-1"
                                        onclick="filterOrderStatusChart()">
                                        <i class="bi bi-funnel-fill"></i> Lọc
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Vùng chứa biểu đồ --}}
                    <div class="card-body">
                        <canvas id="orderStatusChart" height="98"></canvas>
                    </div>

                </div>
            </div>
        </div>

        {{-- sản phẩm sắp hết hàng và review từ khách --}}
        <div class="row">
            <div class="col-lg-6">
                <!-- Tiêu đề -->
                <div class="row mb-4">
                    <div class="col">
                        <h4 class="fw-bold">Sản phẩm sắp hết hàng</h4>
                    </div>
                </div>
                <!-- begin::san pham sap het-->
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-striped align-middle mb-0">
                        <tbody id="lowStockTableBody">
                            <!-- Dữ liệu sản phẩm sẽ được JS thêm vào đây -->
                        </tbody>
                    </table>
                </div>
                <!-- end::san pham sap het-->
            </div>

            {{-- Đánh giá mới chờ duyệt --}}
            <div class="col-lg-6">
                <!-- Tiêu đề -->
                <div class="row mb-4">
                    <div class="col d-flex justify-content-between">
                        <h4 class="fw-bold">Đánh giá mới chờ duyệt</h4>
                        <a href ='{{ route('reviews') }}'
                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                            Xem tất cả</a>
                    </div>
                </div>

                <!-- begin::đánh giá mới-->
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-striped align-middle mb-0">
                        <thead id='pendingReviewsHead'>

                        </thead>
                        <tbody id="pendingReviewsBody">
                            <!-- Dữ liệu đánh giá sẽ được thêm bằng JavaScript -->
                        </tbody>
                    </table>
                    <div class="text-center py-2 text-muted" id="noReviews" style="display: none;">
                        Không có đánh giá nào chờ duyệt.
                    </div>
                </div>
                <!-- end::đánh giá mới-->
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ham dung chung --}}
    <script>
        let refreshInterval = null;

        function autoRefreshChart(startDate, endDate) {
            // Clear interval cũ nếu có
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }

            // Tạo mới interval để cập nhật mỗi 30 giây
            refreshInterval = setInterval(() => {
                renderRevenueChart(startDate, endDate);
                loadTopSellingProducts(startDate, endDate);
                loadLowStockProducts()
            }, 10000);
        }

        // Hàm format ngày thành yyyy-mm-dd (hợp với input type="date")
        function formatDate(date) {
            return date.toLocaleDateString('en-CA'); // đúng định dạng yyyy-mm-dd
        }

        // Định dạng tiền tệ VNĐ
        function formatCurrency(value) {
            return Number(value).toLocaleString('vi-VN') + '₫';
        }
    </script>

    {{-- xử lý biểu đồ doanh thu --}}
    <script>
        let monthlyRevenueChart; // Biến lưu biểu đồ để huỷ và vẽ lại

        // Hàm vẽ biểu đồ doanh thu & lợi nhuận theo khoảng ngày
        function renderRevenueChart(startDate, endDate) {
            fetch(`/admin/statistics/filter-revenue?start=${startDate}&end=${endDate}`)
                .then(res => res.json())
                .then(res => {
                    // Lấy nhãn trục X và dữ liệu cho biểu đồ
                    const labels = res.days.map(item => item.day); // ngày
                    const revenues = res.days.map(item => item.revenue); // doanh thu từng ngày
                    const profits = res.days.map(item => item.profit); // lợi nhuận từng ngày

                    // Tạo context vẽ biểu đồ
                    const ctx = document.getElementById('revenueChart').getContext('2d');

                    // Xoá biểu đồ cũ nếu có
                    if (monthlyRevenueChart) {
                        monthlyRevenueChart.destroy();
                    }

                    // Vẽ biểu đồ cột (doanh thu) + đường (lợi nhuận)
                    monthlyRevenueChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    type: 'line',
                                    label: 'Lợi nhuận (VNĐ)',
                                    data: profits,
                                    borderColor: 'rgba(255, 99, 132, 0.9)', // Xanh đậm
                                    pointRadius: 5,
                                    pointHoverRadius: 7,
                                    pointBackgroundColor: '#d63384', // Chấm hồng tươi
                                    pointBorderColor: '#fff', // Viền trắng
                                    pointBorderWidth: 2,
                                    tension: 0.4, // Làm mượt đường
                                    yAxisID: 'y2' // 👉 Trục bên phải
                                },
                                {
                                    type: 'bar',
                                    label: 'Doanh thu (VNĐ)',
                                    data: revenues,
                                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                    borderRadius: 5,
                                    yAxisID: 'y1' // 👉 Trục bên trái
                                },

                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y1: {
                                    type: 'linear',
                                    position: 'left',
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Doanh thu'
                                    }
                                },
                                y2: {
                                    type: 'linear',
                                    position: 'right',
                                    beginAtZero: true,
                                    grid: {
                                        drawOnChartArea: false // Không vẽ lưới bên phải để không bị rối
                                    },
                                    title: {
                                        display: true,
                                        text: 'Lợi nhuận'
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(ctx) {
                                            return `${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString('vi-VN')}₫`;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Hiển thị tiêu đề theo ngày
                    const from = new Date(startDate).toLocaleDateString('vi-VN');
                    const to = new Date(endDate).toLocaleDateString('vi-VN');
                    document.getElementById('revenue-title').innerHTML =
                        `<i class="bi bi-graph-up-arrow me-2"></i>Doanh thu từ ${from} đến ${to}`;

                    // Hiển thị tổng doanh thu và tổng lợi nhuận
                    document.getElementById('revenue-total').innerHTML = `
                    <strong>Tổng doanh thu:</strong> ${formatCurrency(res.total)}`;

                    document.getElementById('profit-total').innerHTML = `
                    <strong>Tổng lợi nhuận:</strong> ${formatCurrency(res.total_profit)}`;

                    // Nếu có tăng trưởng thì hiển thị thêm
                    if (res.growth_rate !== null) {
                        const trend = res.growth_rate >= 0 ? '↑' : '↓';
                        const color = res.growth_rate >= 0 ? 'green' : 'red';
                        const rateText = `${trend} ${Math.abs(res.growth_rate)}%`;

                        document.getElementById('revenue-total').innerHTML +=
                            ` <span style="color: ${color}; font-weight: 500;">(${rateText})</span>`;
                    }
                });
        }

        // Khi nhấn nút lọc
        function applyDateFilter() {
            const startDate = document.getElementById("startDate").value;
            const endDate = document.getElementById("endDate").value;

            if (!startDate || !endDate || startDate > endDate) {
                Swal.fire("Lỗi", "Vui lòng chọn khoảng ngày hợp lệ.", "error");
                return;
            }

            // Kiểm tra hợp lệ
            if (!startDate || !endDate || startDate > endDate) {
                Swal.fire("Lỗi", "Vui lòng chọn khoảng ngày hợp lệ.", "error");
                return;
            }

            // Vẽ lại biểu đồ doanh thu
            renderRevenueChart(startDate, endDate);

            // Vẽ lại bảng top sản phẩm
            loadTopSellingProducts(startDate, endDate);

            autoRefreshChart(startDate, endDate); // 👉 Thêm dòng này để kích hoạt realtime
        }

        // Mặc định: Hiển thị biểu đồ 30 ngày gần nhất khi trang load
        window.addEventListener('load', () => {
            const today = new Date();
            const pastDate = new Date();
            pastDate.setDate(today.getDate() - 29); // Lùi lại 29 ngày → tổng cộng 30 ngày

            // Dùng định dạng yyyy-mm-dd và đúng múi giờ (không bị UTC)
            const format = (date) => date.toLocaleDateString('en-CA');

            const start = format(pastDate); // Ngày bắt đầu
            const end = format(today); // Ngày hôm nay

            // Giới hạn không cho chọn ngày trong tương lai
            document.getElementById('startDate').setAttribute('max', end);
            document.getElementById('endDate').setAttribute('max', end);

            // Gán giá trị mặc định cho input date
            document.getElementById('startDate').value = start;
            document.getElementById('endDate').value = end;

            // Load dữ liệu mặc định
            renderRevenueChart(start, end);
            loadTopSellingProducts(start, end);
            autoRefreshChart(start, end);
        });
    </script>

    {{-- xử lý top sản phẩm bán chạy --}}
    <script>
        // Hàm tải dữ liệu và hiển thị top sản phẩm bán chạy
        // Hàm lấy và render top sản phẩm bán chạy theo khoảng ngày
        function loadTopSellingProducts(start, end) {
            fetch(`/admin/statistics/top-products?start=${start}&end=${end}`)
                .then(res => res.json())
                .then(products => {
                    const tbody = document.querySelector('#topProductsTable tbody');
                    tbody.innerHTML = ''; // Xoá dữ liệu cũ

                    // Nếu không có sản phẩm nào được bán trong khoảng thời gian đó
                    if (products.length === 0) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td colspan="6" class="text-center bg-warning bg-opacity-25 text-dark py-4 border rounded">
                        <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                        Không có sản phẩm nào trong khoảng thời gian này.
                    </td>
                `;
                        tbody.appendChild(row);
                    } else {
                        // Nếu có sản phẩm, render từng dòng
                        products.forEach(product => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>
                            <img src="${product.image}" alt="${product.product_name}"
                                 class="rounded-circle img-size-32 me-2" />
                            ${product.product_name}
                        </td>
                        <td>${product.color}</td>
                        <td>${product.size}</td>
                        <td>${parseInt(product.price).toLocaleString()}₫</td>
                        <td>
                            <small class="text-success me-1">
                                <i class="bi bi-arrow-up"></i>
                                ${product.total_sold} Sold
                            </small>
                        </td>
                        <td>
                            <a href="/admin/products/${product.product_id}" class="text-secondary">
                                <i class="bi bi-search"></i>
                            </a>
                        </td>
                    `;
                            tbody.appendChild(row);
                        });
                    }

                    // ✅ Cập nhật tiêu đề theo khoảng ngày
                    const formattedStart = new Date(start).toLocaleDateString('vi-VN');
                    const formattedEnd = new Date(end).toLocaleDateString('vi-VN');

                    document.getElementById('top-products-title').textContent =
                        `Top sản phẩm bán chạy (${formattedStart} - ${formattedEnd})`;
                });
        }
    </script>

    {{-- xử lý biểu đồ đơn hàng trong 7 ngày gần nhất --}}
    <script>
        let ordersChart;
        let orderInterval; // Biến lưu interval để clear khi cần

        // Hàm tự động làm mới biểu đồ mỗi 30 giây
        function autoRefreshOrderChart() {
            if (orderInterval) clearInterval(orderInterval);

            orderInterval = setInterval(() => {
                const startDate = document.getElementById("orderStartDate").value;
                const endDate = document.getElementById("orderEndDate").value;

                if (startDate && endDate && startDate <= endDate) {
                    renderOrdersChart(startDate, endDate);
                }
            }, 9900);
        }

        // Hàm vẽ biểu đồ đơn hàng theo ngày
        function renderOrdersChart(startDate, endDate) {
            fetch(`/admin/statistics/orders-per-day?start=${startDate}&end=${endDate}`)
                .then(res => res.json())
                .then(res => {
                    const labels = res.days.map(item =>
                        new Date(item.date).toLocaleDateString('vi-VN', {
                            day: '2-digit',
                            month: '2-digit'
                        })
                    );
                    const totals = res.days.map(item => item.total);

                    const ctx = document.getElementById('ordersTodayChart').getContext('2d');

                    // Xoá biểu đồ cũ nếu đã tồn tại
                    if (ordersChart) {
                        ordersChart.destroy();
                    }

                    // Vẽ biểu đồ mới
                    ordersChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels, // Nhãn trục X (dạng dd/mm)
                            datasets: [{
                                label: 'Số đơn hàng',
                                data: totals,
                                fill: true,
                                backgroundColor: 'rgba(72, 209, 204, 0.4)', // Xanh ngọc nhạt
                                borderColor: 'rgba(219, 112, 147, 0.8)', // Hồng đậm
                                tension: 0.3,
                                pointRadius: 6, // tăng kích thước
                                pointHoverRadius: 8, // khi hover
                                pointBackgroundColor: 'rgba(0,128,128, 1)', // màu nền chấm
                                pointBorderColor: '#fff', // viền trắng
                                pointBorderWidth: 2,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1 // Hiển thị từng bước 1 đơn
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        title: ctx => 'Ngày: ' + ctx[0].label,
                                        label: ctx => `Tổng đơn: ${ctx.parsed.y}`
                                    }
                                },
                                legend: {
                                    display: false // Ẩn chú thích biểu đồ
                                }
                            }
                        },
                    });

                    // ✅ Cập nhật tổng đơn theo khoảng ngày
                    const from = new Date(startDate).toLocaleDateString('vi-VN');
                    const to = new Date(endDate).toLocaleDateString('vi-VN');
                    document.getElementById('order-total-text').innerHTML =
                        `<i class="bi bi-box-seam me-1"></i>Tổng số đơn hàng: ${res.total_orders}`;
                })
                .catch(error => {
                    console.error('Lỗi khi tải dữ liệu biểu đồ đơn hàng:', error);
                    Swal.fire('Lỗi', 'Không thể tải biểu đồ đơn hàng.', 'error');
                });
        }

        // Hàm lọc khi nhấn nút
        function filterOrderChart() {
            const start = document.getElementById("orderStartDate").value;
            const end = document.getElementById("orderEndDate").value;

            if (!start || !end || start > end) {
                Swal.fire("Lỗi", "Vui lòng chọn khoảng ngày hợp lệ", "error");
                return;
            }

            renderOrdersChart(start, end);
        }

        // Khi load trang: mặc định 7 ngày gần nhất
        window.addEventListener('load', () => {
            const today = new Date();
            const past = new Date();
            past.setDate(today.getDate() - 6);

            const start = formatDate(past);
            const end = formatDate(today);

            // Gán giá trị mặc định cho input
            document.getElementById('orderStartDate').value = start;
            document.getElementById('orderEndDate').value = end;

            // 👉 Giới hạn tối đa là hôm nay (không cho chọn ngày tương lai)
            document.getElementById('orderStartDate').setAttribute('max', end);
            document.getElementById('orderEndDate').setAttribute('max', end);

            renderOrdersChart(start, end);
            autoRefreshOrderChart(start, end)
        });
    </script>

    {{-- xử lý biểu đồ tỷ lệ huỷ đơn và số đơn --}}
    <script>
        let orderStatusChart;
        let cancelRateChart;
        let orderStatusInterval; // Biến lưu interval để clear khi cần

        // Hàm tự động làm mới biểu đồ mỗi 30 giây
        function autoRefreshOrderStatusChart() {
            // Clear interval cũ nếu có
            if (orderStatusInterval) clearInterval(orderStatusInterval);

            orderStatusInterval = setInterval(() => {
                const start = document.getElementById("orderStatusStartDate").value;
                const end = document.getElementById("orderStatusEndDate").value;

                // Chỉ gọi lại nếu ngày hợp lệ
                if (start && end && start <= end) {
                    loadOrderStatusChart(start, end);
                }
            }, 10000);
        }


        // Hàm gọi API và vẽ biểu đồ
        function loadOrderStatusChart(start, end) {
            fetch(`/admin/statistics/order-status?start=${start}&end=${end}`)
                .then(res => res.json())
                .then(data => {
                    const labels = ['Trạng thái'];
                    const statusData = data.counts;

                    // Huỷ biểu đồ cũ
                    if (orderStatusChart) orderStatusChart.destroy();
                    if (cancelRateChart) cancelRateChart.destroy();

                    // Biểu đồ trạng thái
                    const ctx = document.getElementById('orderStatusChart').getContext('2d');
                    orderStatusChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Chờ xử lý',
                                    data: [statusData[0]],
                                    backgroundColor: '#ffc107'
                                },
                                {
                                    label: 'Đang xử lý',
                                    data: [statusData[1]],
                                    backgroundColor: '#0d6efd'
                                },
                                {
                                    label: 'Đang giao',
                                    data: [statusData[2]],
                                    backgroundColor: '#17a2b8'
                                },
                                {
                                    label: 'Đã giao',
                                    data: [statusData[3]],
                                    backgroundColor: '#339966'
                                },
                                {
                                    label: 'Đã hoàn thành',
                                    data: [statusData[4]],
                                    backgroundColor: '#004400'
                                },
                                {
                                    label: 'Đã huỷ',
                                    data: [statusData[5]],
                                    backgroundColor: '#dc3545'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true
                                },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} đơn`
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });

                    // Biểu đồ tỷ lệ huỷ
                    const pieCtx = document.getElementById('cancelRateChart').getContext('2d');
                    cancelRateChart = new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Huỷ đơn', 'Khác'],
                            datasets: [{
                                data: [data.cancelRate, 100 - data.cancelRate],
                                backgroundColor: ['#dc3545', '#6c757d']
                            }]
                        },
                        options: {
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    document.getElementById('cancelRateText').textContent =
                        `${data.cancelRate}% đơn hàng bị huỷ`;
                });
        }

        // Nút lọc
        function filterOrderStatusChart() {
            const start = document.getElementById("orderStatusStartDate").value;
            const end = document.getElementById("orderStatusEndDate").value;

            if (!start || !end || start > end) {
                Swal.fire("Lỗi", "Vui lòng chọn khoảng ngày hợp lệ", "error");
                return;
            }

            loadOrderStatusChart(start, end);
        }

        // Khi trang load
        window.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const past = new Date();
            past.setDate(today.getDate() - 29);

            const start = formatDate(past);
            const end = formatDate(today);

            document.getElementById('orderStatusStartDate').value = start;
            document.getElementById('orderStatusEndDate').value = end;
            document.getElementById('orderStatusStartDate').setAttribute('max', end);
            document.getElementById('orderStatusEndDate').setAttribute('max', end);

            loadOrderStatusChart(start, end);
            // Bắt đầu realtime
            autoRefreshOrderStatusChart();
        });
    </script>

    {{-- xử lý load sản phẩm sắp hết hàng --}}
    <script>
        // Hàm load sản phẩm gần hết hàng
        function loadLowStockProducts() {
            fetch('/admin/statistics/low-stock')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('lowStockTableBody');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center text-muted">Không có sản phẩm nào gần hết hàng</td>
                        </tr>`;
                        return;
                    }

                    data.forEach(variant => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>
                            <img src="/${variant.image ?? 'default.png'}" alt="Ảnh" class="img-size-32 rounded-circle me-2" width="32" height="32">
                            <a href="/admin/products/${variant.product.id}">${variant.product.name}</a>
                        </td>
                        <td>${variant.color ?? ''}</td>
                        <td>${variant.size ?? ''}</td>
                        <td>${Number(variant.price).toLocaleString()}₫</td>
                        <td class="fw-bold text-danger">${variant.stock_quantity}</td>
                    `;
                        tbody.appendChild(row);
                    });
                });
        }

        // Gọi hàm khi trang tải xong
        window.addEventListener('load', loadLowStockProducts);
    </script>

    {{-- xử lý hiển thị đánh giá mới chưa duyệt --}}
    <script>
        // Gọi AJAX để lấy các đánh giá chưa duyệt
        function loadPendingReviews() {
            fetch('/admin/statistics/pending-reviews')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('pendingReviewsBody');
                    const thead = document.getElementById('pendingReviewsHead');
                    const noData = document.getElementById('noReviews');
                    tbody.innerHTML = '';
                    thead.innerHTML = '';

                    if (data.length === 0) {
                        noData.style.display = 'block';
                        return;
                    } else {
                        noData.style.display = 'none';
                        thead.innerHTML = `
                    <tr>
                                <th>Người dùng</th>
                                <th>Sản phẩm</th>
                                <th>Nội dung</th>
                                <th>Sao</th>
                                <th>Hành động</th>
                            </tr>
                            `;
                    }

                    data.forEach(review => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                            <td>${review.user?.name || 'Ẩn danh'}</td>
                            <td>${review.product?.name || 'Không xác định'}</td>
                            <td>${review.comment || 'Không có nội dung'}</td>
                            <td><span class="badge bg-warning text-dark">${review.rating} ★</span></td>
                            <td>
                            <!-- Nút duyệt đánh giá -->
                            <button class="btn btn-success btn-sm me-1"
                            onclick="approveReview(${review.id})" title="Duyệt đánh giá">
                            <i class="bi bi-check-circle"></i>
                            </button>
                        `;
                        tbody.appendChild(row);
                    });
                });
        }

        // Gọi hàm khi load trang
        window.addEventListener('load', loadPendingReviews);

        function approveReview(id) {
            fetch(`/reviews/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                if (res.ok) {
                    // ✅ Hiển thị thông báo SweetAlert khi duyệt thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã duyệt!',
                        text: 'Đánh giá đã được duyệt thành công.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    loadPendingReviews(); // Reload lại bảng sau khi duyệt
                } else {
                    Swal.fire('Lỗi', 'Duyệt không thành công!', 'error');
                }
            });
        }

        // Xoá đánh giá
        function deleteReview(id) {
            Swal.fire({
                title: 'Bạn có chắc muốn xoá?',
                text: 'Thao tác này sẽ xoá vĩnh viễn đánh giá!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/reviews/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(res => {
                        if (res.ok) {
                            // ✅ Hiển thị thông báo SweetAlert khi xoá thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Đã xoá!',
                                text: 'Đánh giá đã được xoá.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadPendingReviews();
                        } else {
                            Swal.fire('Lỗi', 'Xoá không thành công!', 'error');
                        }
                    });
                }
            });
        }
    </script>

    {{-- // Tải danh sách yêu cầu trả hàng mới nhất --}}
    <script>
        function loadLatestReturnRequests() {
            fetch('/admin/statistics/latest-return-requests')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('returnRequestsBody');
                    const thead = document.getElementById('returnRequestsHead');
                    const noData = document.getElementById('noReturnRequests');

                    tbody.innerHTML = '';
                    thead.innerHTML = '';

                    if (data.length === 0) {
                        noData.style.display = 'block';
                        return;
                    } else {
                        noData.style.display = 'none';
                    }

                    data.forEach(item => {
                        const row = document.createElement('tr');
                        let actionHtml = '';

                        if (item.status === 'requested') {
                            actionHtml = `
                                <button class="btn btn-success btn-sm me-1"
                                    onclick="handleReturnAction(${item.id}, 'approved')">
                                    <i class="bi bi-check-circle"></i> Duyệt
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    onclick="handleReturnAction(${item.id}, 'rejected')">
                                    <i class="bi bi-x-circle"></i> Từ chối
                                </button>
                            `;
                        } else if (item.status === 'approved') {
                            const paymentMethod = item.order?.payment_method;
                            const paymentStatus = item.order?.payment_status;

                            const showRefundButton = paymentMethod === 'online' && paymentStatus ===
                                'completed';
                            const label = showRefundButton ? 'Hoàn tất hoàn tiền' : 'Hoàn tất hoàn hàng';

                            actionHtml = `
                                <button class="btn btn-primary btn-sm"
                                    onclick="handleReturnAction(${item.id}, 'refunded')">
                                    <i class="bi bi-check-lg"></i> ${label}
                                </button>
                            `;
                        }


                        row.innerHTML = `
                        <td>${item.order.shipping_address?.name || 'Ẩn danh'}</td>
                        <td>#${item.order?.order_code || 'Không rõ'}</td>
                        <td>${item.order?.shipping_address?.phone_number || 'Không rõ số điện thoại'}</td>
                        <td>
                            <span class="badge" style="background-color: ${getPaymentMethod(item.order?.payment_method).color};">
                                ${getPaymentMethod(item.order?.payment_method).label}
                            </span>
                        </td>
                        <td>
                            <span class="badge" style="background-color: ${getPaymentStatus(item.order?.payment_status).color};">
                                ${getPaymentStatus(item.order?.payment_status).label}
                            </span>
                        </td>
                        <td>${new Date(item.created_at).toLocaleDateString('vi-VN')}</td>
                        <td>
                            <span class="badge ${getReturnStatusBadge(item.status).class}">
                                ${getReturnStatusBadge(item.status).label}
                            </span>
                        </td>
                        <td>${actionHtml}</td>
                    `;

                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error("Lỗi khi tải danh sách yêu cầu trả hàng:", error);
                });
        }

        // Gọi hàm khi trang load
        window.addEventListener('DOMContentLoaded', loadLatestReturnRequests);

        // Hàm xử lý duyệt hoặc từ chối yêu cầu trả hàng
        function handleReturnAction(id, status) {
            // Xác nhận lại với người dùng
            let actionText = '';

            switch (status) {
                case 'approved':
                    actionText = 'duyệt';
                    break;
                case 'rejected':
                    actionText = 'từ chối';
                    break;
                case 'refunded':
                    actionText = 'đánh dấu đã hoàn tất';
                    break;
                default:
                    actionText = 'cập nhật';
            }

            Swal.fire({
                title: `Bạn chắc chắn muốn ${actionText} yêu cầu này?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/return-requests/${id}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(res => {
                            if (res.redirected) {
                                window.location.href = res.url; // Nếu Laravel redirect, tự chuyển trang
                                return;
                            }

                            if (!res.ok) throw new Error('Lỗi cập nhật trạng thái');

                            return res.json();
                        })
                        .then(data => {
                            Swal.fire({
                                title: '✅ Thành công',
                                text: 'Trạng thái đã được cập nhật.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadLatestReturnRequests(); // Gọi lại để refresh
                        })
                        .catch(err => {
                            Swal.fire('Lỗi', err.message || 'Cập nhật thất bại!', 'error');
                        });
                }
            });
        }

        function getPaymentMethod(method) {
            const methods = {
                'cod': {
                    label: 'Thanh toán khi nhận hàng',
                    color: '#CC6666'
                },
                'online': {
                    label: 'Thanh toán trực tuyến',
                    color: '#6699CC'
                },
                'bank_transfer': {
                    label: 'Thanh toán qua ngân hàng',
                    color: '#CC66CC'
                },
            };

            return methods[method] || {
                label: 'Không xác định',
                color: '#999'
            };
        }

        function getPaymentStatus(status) {
            const paymentStatuses = {
                'pending': {
                    label: 'Chờ thanh toán',
                    color: '#FF9966'
                },
                'completed': {
                    label: 'Đã thanh toán',
                    color: '#009900'
                },
                'failed': {
                    label: 'Thanh toán thất bại',
                    color: '#666666'
                },
            };

            return paymentStatuses[status] || {
                label: 'Không xác định',
                color: '#999'
            };
        }

        function getReturnStatusBadge(status) {
            const statuses = {
                'requested': {
                    label: 'Chờ xử lý',
                    class: 'bg-warning text-dark'
                },
                'approved': {
                    label: 'Đã duyệt',
                    class: 'bg-success'
                },
                'rejected': {
                    label: 'Từ chối',
                    class: 'bg-danger'
                },
                'refunded': {
                    label: 'Yêu cầu hoàn tất',
                    class: 'bg-primary'
                },
            };
            return statuses[status] || {
                label: 'Không xác định',
                class: 'bg-secondary'
            };
        }
    </script>

    {{-- thông báo mới nhất --}}
    <script>
        let currentPage = 1;

        function loadUserNotifications(page = 1) {
            fetch(`/admin/statistics/latest-notifications?page=${page}`)
                .then(res => res.json())
                .then(data => {
                    const noData = document.getElementById('noNotifications');
                    const carouselInner = document.getElementById('carouselNotificationInner');
                    const pagination = document.getElementById('paginationControls');
                    currentPage = data.pagination?.current_page || 1;

                    const notifications = data.notifications || [];

                    // ✅ Hiển thị thông báo theo dạng slide
                    if (notifications.length > 0) {
                        noData.style.display = 'none';
                        carouselInner.innerHTML = notifications.map((item, index) => `
                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                            <div class="p-2 text-dark small">
                                <span class="fw-semibold">${item.title}</span><br>
                                <small class="text-muted">${new Date(item.created_at).toLocaleString('vi-VN')}</small><br>
                                <span>${item.message}</span>
                            </div>
                        </div>
                    `).join('');
                    } else {
                        noData.style.display = 'block';
                        carouselInner.innerHTML = '';
                    }

                    // ✅ Phân trang
                    renderPagination(data.pagination);
                })
                .catch(error => {
                    console.error("Lỗi khi tải thông báo:", error);
                });
        }

        function renderPagination(paginationData) {
            const pagination = document.getElementById('paginationControls');
            pagination.innerHTML = '';

            if (!paginationData || paginationData.last_page <= 1) return;

            const current = paginationData.current_page;
            const last = paginationData.last_page;

            if (current > 1) {
                pagination.innerHTML += `
                <li class="page-item"><a class="page-link" href="#" onclick="loadUserNotifications(${current - 1}); return false;">«</a></li>
            `;
            }

            for (let i = 1; i <= last; i++) {
                pagination.innerHTML += `
                <li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadUserNotifications(${i}); return false;">${i}</a>
                </li>
            `;
            }

            if (current < last) {
                pagination.innerHTML += `
                <li class="page-item"><a class="page-link" href="#" onclick="loadUserNotifications(${current + 1}); return false;">»</a></li>
            `;
            }
        }

        // Gọi khi trang load
        window.addEventListener('DOMContentLoaded', () => loadUserNotifications());
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const head = document.getElementById('cancelRequestTableHead');
            const body = document.getElementById('cancelRequestTableBody');
            const noData = document.getElementById('cancelRequestNoData');

            let lastDataJSON = ''; // Để kiểm tra thay đổi dữ liệu

            function fetchCancelRequests() {
                fetch('/admin/orders/cancel-requests/today')
                    .then(response => response.json())
                    .then(data => {
                        const currentDataJSON = JSON.stringify(data);

                        // Nếu dữ liệu không thay đổi thì không render lại
                        if (currentDataJSON === lastDataJSON) return;
                        lastDataJSON = currentDataJSON;

                        // Reset bảng
                        head.innerHTML = '';
                        body.innerHTML = '';
                        noData.style.display = 'none';

                        // Không có dữ liệu
                        if (!Array.isArray(data) || data.length === 0) {
                            noData.style.display = 'block';
                            return;
                        }

                        // Render phần đầu bảng
                        head.innerHTML = `
                    <tr>
                        <th>Khách hàng</th>
                        <th>SĐT</th>
                        <th>Thời gian</th>
                        <th>Lý do huỷ</th>
                        <th>Hành động</th>
                    </tr>
                `;

                        // Render dữ liệu từng dòng
                        data.forEach((order) => {
                            body.innerHTML += `
                        <tr>
                            <td>${order.user?.name ?? '<i>Ẩn danh</i>'}</td>
                            <td>${order.shipping_address?.phone_number ?? '<i>Ẩn danh</i>'}</td>
                            <td>${new Date(order.created_at).toLocaleString('vi-VN')}</td>
                            <td>
                                ${order.cancel_reason
                                    ? `<em>${order.cancel_reason}</em>`
                                    : '<span class="text-muted fst-italic">Không có</span>'}
                            </td>
                            <td>
                                <!-- Duyệt -->
                                <button class="btn btn-success btn-sm me-1"
                                    onclick="handleCancelAction(${order.id}, 'approve',
                                     '${escapeJs(order.cancel_reason)}', '${escapeJs(order.user?.name)}')">
                                    <i class="bi bi-check-circle"></i> Duyệt
                                </button>

                                <!-- Từ chối -->
                                <button class="btn btn-danger btn-sm"
                                    onclick="handleCancelAction(${order.id}, 'reject',
                                     '${escapeJs(order.cancel_reason)}', '${escapeJs(order.user?.name)}')">
                                    <i class="bi bi-x-circle"></i> Từ chối
                                </button>
                            </td>
                        </tr>
                    `;
                        });
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải yêu cầu huỷ đơn:', error);
                        head.innerHTML = '';
                        body.innerHTML = '';
                        noData.style.display = 'block';
                        noData.textContent = 'Không thể tải dữ liệu yêu cầu huỷ đơn.';
                    });
            }

            // Gọi lần đầu khi trang load
            fetchCancelRequests();

            // Thiết lập cập nhật mỗi 10 giây
            setInterval(fetchCancelRequests, 10000); // 10000ms = 10s
        });

        function escapeJs(str) {
            if (!str) return '';
            return str.replace(/\\/g, '\\\\')
                .replace(/'/g, "\\'")
                .replace(/"/g, '\\"')
                .replace(/\n/g, '\\n')
                .replace(/\r/g, '');
        }


        function handleCancelAction(orderId, action, customerReason = '', customerName = '') {
            const actionLabel = action === 'approve' ? 'Xác nhận yêu cầu huỷ đơn' : 'Từ chối yêu cầu huỷ';
            const actionColor = action === 'approve' ? '#198754' : '#dc3545'; // xanh hoặc đỏ

            const htmlContent = `
                <div class="text-start">
                    <label class="form-label fw-bold text-dark mb-1">
                        <i class="bi bi-person-fill text-primary me-1"></i> Lý do khách yêu cầu huỷ:
                    </label>
                    <div class="bg-light border rounded p-2 mb-3">
                        ${customerReason
                            ? `<em>${customerReason}</em>`
                            : '<span class="text-muted fst-italic">Không có lý do được cung cấp.</span>'}
                    </div>

                    <div class="d-flex flex-column">
                        <label for="adminReason" class="form-label fw-bold text-dark mb-1">
                        <i class="bi bi-shield-lock-fill text-danger me-1"></i> Lý do của bạn:
                    </label>
                    <textarea id="adminReason" class="swal2-textarea" placeholder="Nhập lý do của bạn..." rows="3"></textarea>
                    </div>
                </div>
            `;

            Swal.fire({
                title: `${actionLabel} từ khách hàng ${customerName || 'Ẩn danh'}`,
                html: htmlContent,
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                confirmButtonColor: actionColor,
                cancelButtonText: 'Hủy',
                focusConfirm: false,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                },
                preConfirm: () => {
                    const reason = document.getElementById('adminReason')?.value.trim();
                    if (!reason || reason.length < 10) {
                        Swal.showValidationMessage('Lý do phải có ít nhất 10 ký tự.');
                        return false;
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const adminNote = result.value;

                    fetch(`/admin/orders/cancel-request/${orderId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                action: action,
                                admin_cancel_note: adminNote
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: data.success,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Lỗi', data.error || 'Đã xảy ra lỗi khi xử lý yêu cầu.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Lỗi', 'Không thể gửi yêu cầu. Vui lòng thử lại sau.', 'error');
                        });
                }
            });
        }
    </script>
@endsection
