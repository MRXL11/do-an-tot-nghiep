@extends('admin.layouts.AdminLayouts')
@section('title-page')
    <h3>Thống kê</h3>
@endsection
@section('content')
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Đơn hàng mới</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path
                            d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                        </path>
                    </svg>
                    <a href="#"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Chi tiết <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 1-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>1.255.2222</sup></h3>
                        <p>TỔNG DOANH THU</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path
                            d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                        </path>
                    </svg>
                    <a href="#"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Chi tiết <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 2-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Người dùng đăng ký</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                        </path>
                    </svg>
                    <a href="#"
                        class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        Chi tiết <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 3-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 4-->
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Khách vãng lai</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                        </path>
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                        </path>
                    </svg>
                    <a href="#"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Chi tiết <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 4-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box text-bg-primary">
                    <span class="info-box-icon"> <i class="bi bi-heart-fill text-w"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Yêu thích</span>
                        <span class="info-box-number">41,410</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description"> Có 135 sản phẩm được yêu thích </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box text-bg-success">
                    <span class="info-box-icon"> <i class="bi bi-star-fill text-warning"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Đánh giá</span>
                        <span class="info-box-number">41,410</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description"> 13k đánh giá </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box text-bg-warning">
                    <span class="info-box-icon"> <i class="bi bi-calendar3"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sự kiện</span>
                        <span class="info-box-number">41,410</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description"> 15 voucher trong 30 ngày </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box text-bg-danger">
                    <span class="info-box-icon"> <i class="bi bi-chat-text-fill"></i> </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Bình luận</span>
                        <span class="info-box-number">41,410</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description"> 134k bình luận </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->

        <div class="row">
            <main class="container my-5">
                <!-- Tiêu đề -->
                <div class="row mb-4">
                    <div class="col text-center">
                        <h2 class="fw-bold" id="revenue-title">
                            Chi tiết doanh thu tháng
                        </h2>
                        <p class="text-muted">Tổng hợp doanh thu theo từng ngày của tháng trong năm</p>
                    </div>
                </div>

                <div class="row">
                    <!-- Biểu đồ doanh thu theo ngày trong tháng -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Bộ lọc tháng -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0 fw-bold" id="revenue-total">
                                        Tổng doanh thu tháng
                                    </h5>
                                    <input type="month" id="filterMonth" class="form-control"
                                        style="max-width: 200px;">
                                </div>

                                <!-- Biểu đồ doanh thu -->
                                <div style="overflow-x: auto;">
                                    <canvas id="monthlyRevenueChart" height="500"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        {{--  --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title fw-bold">Đơn hàng hôm nay</h3>
                            <a href="{{ route('admin.orders.index') }}"
                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                Xem tất cả
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="fw-bold fs-5">
                                    {{ $orderTodayCount }}
                                </span>
                                <span class="text-muted">Tổng đơn hôm nay</span>
                            </p>
                            <p class="ms-auto d-flex flex-column text-end">
                                @if ($percentChange > 0)
                                    <span class="text-success">
                                        <i class="bi bi-arrow-up"></i>
                                        {{ number_format($percentChange, 1) }}%
                                    </span>
                                @elseif ($percentChange < 0)
                                    <span class="text-danger">
                                        <i class="bi bi-arrow-down"></i>
                                        {{ number_format(abs($percentChange), 1) }}%
                                    </span>
                                @else
                                    <span class="text-secondary">0%</span>
                                @endif
                                <span class="text-secondary">So với hôm qua</span>
                            </p>
                        </div>

                        {{-- Nếu có biểu đồ mini cho đơn hàng hôm nay/tuần --}}
                        <div class="position-relative mb-4">
                            <canvas id="ordersTodayChart" height="200"></canvas>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <!-- Tiêu đề -->
                <div class="row mb-4">
                    <div class="col">
                        <h4 class="fw-bold " id="top-products-title">Top sản phẩm bán chạy nhất tháng 07/2025
                        </h4>
                    </div>
                </div>
                <!-- begin::san pham ban chay-->
                <table class="table table-striped align-middle" id="topProductsTable">
                    {{-- <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Size</th>
                            <th>Giá</th>
                            <th>Đã bán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        <!-- Dữ liệu sản phẩm sẽ được JS thêm vào đây -->
                    </tbody>
                </table>
            </div>
            <!-- end::san pham ban chay-->
        </div>

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
                <div class="card mb-4">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h5 class=" fw-bold">Đơn hàng</h5>
                        <input type="month" id="orderStatusMonth" class="form-control" style="max-width: 200px;">
                    </div>
                    <div class="card-body">
                        <canvas id="orderStatusChart" height="333"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- xử lý biểu đồ doanh thu --}}
    <script>
        let monthlyRevenueChart;

        // Vẽ biểu đồ doanh thu theo tháng
        function renderRevenueChart(month) {
            fetch(`/admin/statistics/filter-revenue?month=${month}`)
                .then(res => res.json())
                .then(res => {
                    // Lấy dữ liệu từ response
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
                                            return context.dataset.label + ': ' + new Intl.NumberFormat(
                                                'vi-VN').format(context.parsed.y) + '₫';
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // ✅ Cập nhật tiêu đề và tổng doanh thu
                    const formattedMonth = new Date(res.month + '-01').toLocaleDateString('vi-VN', {
                        month: '2-digit',
                        year: 'numeric'
                    });

                    document.getElementById('revenue-title').textContent = `Chi tiết doanh thu tháng ${formattedMonth}`;
                    document.getElementById('revenue-total').textContent =
                        `Tổng doanh thu tháng ${formattedMonth}: ${formatCurrency(res.monthly_total)}`;
                    // hiển thị tăng/giảm doanh thu so với tháng trước đó
                    if (res.growth_rate !== null) {
                        const trend = res.growth_rate >= 0 ? '↑' : '↓';
                        const color = res.growth_rate >= 0 ? 'green' : 'red';
                        const rateText = `${trend} ${Math.abs(res.growth_rate)}%`;

                        // Thêm 1 span để style riêng phần tăng/giảm
                        document.getElementById('revenue-total').innerHTML +=
                            ` <span style="color: ${color}; font-weight: 500;">(${rateText})</span>`;
                    };
                })
        }

        function formatCurrency(value) {
            return Number(value).toLocaleString('vi-VN') + '₫';
        }

        // Khi chọn tháng thay đổi
        document.getElementById('filterMonth').addEventListener('change', function() {
            const selectedMonth = this.value;
            if (selectedMonth) {
                renderRevenueChart(selectedMonth);
            }
        });

        // Load mặc định tháng hiện tại khi trang được load
        window.addEventListener('load', () => {
            const today = new Date();
            const defaultMonth = today.toISOString().slice(0, 7); // yyyy-mm
            document.getElementById('filterMonth').value = defaultMonth;
            renderRevenueChart(defaultMonth);
        });
    </script>

    {{-- xử lý top sản phẩm bán chạy --}}
    <script>
        // Hàm lấy và render top sản phẩm bán chạy
        function loadTopSellingProducts(month) {
            fetch(`/admin/statistics/top-products?month=${month}`)
                .then(res => res.json())
                .then(products => {
                    const tbody = document.querySelector('#topProductsTable tbody');
                    tbody.innerHTML = ''; // Xóa dữ liệu cũ

                    // Duyệt từng sản phẩm và thêm hàng vào bảng
                    products.forEach(product => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                        <td>
                            <img src="${product.image}" alt="${product.name}"
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
                });

            // ✅ Cập nhật tiêu đề và tổng doanh thu
            const formattedMonth = new Date(res.month + '-01').toLocaleDateString('vi-VN', {
                month: '2-digit',
                year: 'numeric'
            });

            document.getElementById('top-products-title').textContent = `Chi tiết doanh thu tháng ${formattedMonth}`;
        }

        // Tự động load khi trang load
        window.addEventListener('load', () => {
            const today = new Date();
            const month = today.toISOString().slice(0, 7); // yyyy-mm
            loadTopSellingProducts(month);
        });
    </script>

    {{-- xử lý biểu đồ đơn hàng trong 7 ngày gần nhất --}}
    <script>
        // Lấy dữ liệu ngày & số đơn từ Blade
        const labels = {!! json_encode(
            $orderLast7Days->pluck('date')->map(function ($d) {
                return \Carbon\Carbon::parse($d)->format('d/m');
            }),
        ) !!};
        const data = {!! json_encode($orderLast7Days->pluck('total')) !!};

        const ctx = document.getElementById('ordersTodayChart').getContext('2d');

        // Tạo gradient màu từ xanh sang tím
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(255, 162, 235, 0.9)'); // Màu xanh dương
        gradient.addColorStop(1, 'rgba(153, 255, 255, 0.4)'); // Màu tím nhạt

        const ordersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // Mỗi ngày (7 ngày gần nhất)
                datasets: [{
                    label: 'Số đơn hàng',
                    data: data,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: 'rgba(255, 99, 132, 0.6)',
                    tension: 0.3, // Bo tròn góc
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(54, 99, 132, 1)',
                    pointRadius: 5,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Luôn hiển thị từng bước 1 đơn
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Ẩn chú thích
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` ${context.parsed.y} đơn hàng`;
                            }
                        }
                    }
                }
            }
        });
    </script>

    {{-- xử lý biểu đồ tỷ lệ huỷ đơn và số đơn --}}
    <script>
        let orderStatusChart;
        let cancelRateChart;

        // Hàm tải và vẽ biểu đồ đơn hàng theo trạng thái và tỷ lệ huỷ
        function loadOrderStatusChart(month) {
            fetch(`/admin/statistics/order-status?month=${month}`)
                .then(res => res.json())
                .then(data => {
                    // Danh sách trạng thái đơn hàng
                    const labels = ['Trạng thái']; // chỉ cần 1 nhãn để gom các cột vào cùng 1 nhóm
                    const statusData = data.counts; // [pending, processing, shipped, delivered, canceled]

                    const ctx = document.getElementById('orderStatusChart').getContext('2d');
                    if (orderStatusChart) orderStatusChart.destroy();

                    // Tạo biểu đồ cột với nhiều dataset để hiển thị được nhiều legend
                    orderStatusChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Chờ xử lý',
                                    data: [statusData[0]],
                                    backgroundColor: '#ffc107' // vàng
                                },
                                {
                                    label: 'Đang xử lý',
                                    data: [statusData[1]],
                                    backgroundColor: '#0d6efd' // xanh dương
                                },
                                {
                                    label: 'Đang giao',
                                    data: [statusData[2]],
                                    backgroundColor: '#17a2b8' // xanh ngọc
                                },
                                {
                                    label: 'Đã giao',
                                    data: [statusData[3]],
                                    backgroundColor: '#28a745' // xanh lá
                                },
                                {
                                    label: 'Đã huỷ',
                                    data: [statusData[4]],
                                    backgroundColor: '#dc3545' // đỏ
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        },
                                        color: '#333'
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.dataset.label}: ${context.parsed.y} đơn`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                },
                                x: {
                                    stacked: false // Đảm bảo các cột không bị xếp chồng, giữ nguyên 1 nhóm
                                }
                            }
                        }
                    });

                    // Vẽ biểu đồ tròn tỷ lệ huỷ đơn
                    const pieCtx = document.getElementById('cancelRateChart').getContext('2d');
                    if (cancelRateChart) cancelRateChart.destroy();

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
                                    display: true,
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    // Hiển thị phần trăm huỷ đơn bên ngoài biểu đồ
                    document.getElementById('cancelRateText').textContent = `${data.cancelRate}% đơn hàng bị huỷ`;
                });
        }

        // Sự kiện thay đổi tháng
        document.getElementById('orderStatusMonth').addEventListener('change', function() {
            loadOrderStatusChart(this.value);
        });

        // Tải biểu đồ mặc định với tháng hiện tại
        window.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const currentMonth = today.toISOString().slice(0, 7); // yyyy-mm
            document.getElementById('orderStatusMonth').value = currentMonth;
            loadOrderStatusChart(currentMonth);
        });
    </script>
@endsection
