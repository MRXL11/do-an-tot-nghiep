@extends('admin.layouts.AdminLayouts')
@section('title-page')
@endsection
@section('content')
    <div class="container-fluid">
        {{-- doanh thu --}}
        <div class="row">
            <main class="container mb-5">
                <!-- Tiêu đề -->
                <div class="row mb-4">
                    <div class="col text-center">
                        <h2 class="fw-bold" id="revenue-title">
                            Doanh thu
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
                                    <input type="month" id="filterMonth" class="form-control" style="max-width: 200px;">
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

        {{-- đơn hàng theo ngày và top sản phẩm bán chạy của tháng --}}
        <div class="row">
            {{-- đơn hàng --}}
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
                <div class="card mb-4">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h5 class=" fw-bold">Đơn hàng</h5>
                        <input type="month" id="orderStatusMonth" class="form-control" style="max-width: 200px;">
                    </div>
                    <div class="card-body">
                        <canvas id="orderStatusChart" height="328"></canvas>
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

                    document.getElementById('revenue-title').textContent = `Doanh thu ${formattedMonth}`;
                    document.getElementById('revenue-total').textContent =
                        `Tổng doanh thu ${formattedMonth}: ${formatCurrency(res.monthly_total)}`;
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

            // Update the title with the selected month
            const formattedMonth = new Date(month + '-01').toLocaleDateString('vi-VN', {
                month: '2-digit',
                year: 'numeric'
            });

            document.getElementById('top-products-title').textContent =
                `Top sản phẩm bán chạy nhất ${formattedMonth}`;
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

                            <!-- Nút xoá đánh giá -->
                            <button class="btn btn-danger btn-sm"
                            onclick="deleteReview(${review.id})" title="Xoá đánh giá">
                            <i class="bi bi-trash"></i>
                            </button>
                            </td>
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
