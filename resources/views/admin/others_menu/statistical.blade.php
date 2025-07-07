@extends('admin.layouts.AdminLayouts')
@section('title-page')
@endsection
@section('content')
    <div class="container-fluid">
        {{-- doanh thu --}}
        <!-- Bộ lọc từ ngày đến ngày -->
        <!-- Tiêu đề doanh thu và tổng doanh thu -->
        <div class="row mb-4">
            <div class="col text-center">
                <!-- Tiêu đề chính (sẽ được cập nhật bằng JS) -->
                <h2 class="fw-bold" id="revenue-title">
                    Doanh thu
                </h2>
            </div>
        </div>

        <!-- Bộ lọc ngày và biểu đồ -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Bộ lọc từ ngày đến ngày -->
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <!-- Tổng doanh thu (sẽ được cập nhật bằng JS) -->
                            <h5 class="fw-semibold text-primary mt-2" id="revenue-total"></h5>

                            <div class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                                <label for="startDate" class="form-label mb-0">Từ:</label>
                                <input type="date" id="startDate" class="form-control" style="max-width: 160px;">

                                <label for="endDate" class="form-label mb-0">Đến:</label>
                                <input type="date" id="endDate" class="form-control" style="max-width: 160px;">

                                <button class="btn btn-primary" onclick="applyDateFilter()">Lọc</button>
                            </div>
                        </div>

                        <!-- Biểu đồ doanh thu -->
                        <div style="overflow-x: auto;" class="mb-3">
                            <canvas id="monthlyRevenueChart" height="500"></canvas>
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
                                <input type="date" id="orderStartDate" class="form-control" style="max-width: 160px;">
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
        let monthlyRevenueChart;

        // Gửi request và render biểu đồ theo khoảng ngày
        function renderRevenueChart(startDate, endDate) {
            fetch(`/admin/statistics/filter-revenue?start=${startDate}&end=${endDate}`)
                .then(res => res.json())
                .then(res => {
                    const labels = res.days.map(item => item.day);
                    const values = res.days.map(item => item.total);

                    const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');

                    if (monthlyRevenueChart) {
                        monthlyRevenueChart.destroy();
                    }

                    monthlyRevenueChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Doanh thu (VNĐ)',
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': ' +
                                                new Intl.NumberFormat('vi-VN').format(context.parsed.y) +
                                                '₫';
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Cập nhật tiêu đề và tổng doanh thu
                    const from = new Date(startDate).toLocaleDateString('vi-VN');
                    const to = new Date(endDate).toLocaleDateString('vi-VN');
                    document.getElementById('revenue-title').textContent = `Doanh thu từ ${from} đến ${to}`;
                    document.getElementById('revenue-total').textContent =
                        `Tổng doanh thu: ${formatCurrency(res.total)}`;

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
@endsection
