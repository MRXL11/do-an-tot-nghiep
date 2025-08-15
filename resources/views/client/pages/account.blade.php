@extends('client.pages.page-layout')

@section('content')
    <div class="container-fluid px-4">
        <div class="row g-4">
            <!-- Left Column: User Profile -->
            <div class="col-lg-12 py-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white p-4 border-0">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-4 me-3"></i>
                            <h5 class="mb-0 fw-bold">Thông tin cá nhân</h5>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 rounded-3 border-0 shadow-sm"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('account.update') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Avatar Section -->
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ Auth::user()->avatar ?? 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp' }}"
                                        class="rounded-circle border border-4 border-white shadow-lg" width="120"
                                        height="120" alt="Avatar">
                                    <div class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2">
                                        <i class="bi bi-camera-fill text-white"></i>
                                    </div>
                                </div>
                                <h4 class="mt-3 mb-1 fw-bold text-dark">{{ Auth::user()->name }}</h4>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-envelope me-2"></i>{{ Auth::user()->email }}
                                </p>
                            </div>

                            <!-- Form Fields -->
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" name="name"
                                            class="form-control rounded-3 @error('name') is-invalid @enderror"
                                            id="floatingName" value="{{ Auth::user()->name }}" placeholder="Họ tên">
                                        <label for="floatingName">
                                            <i class="bi bi-person me-2"></i>Họ tên
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control rounded-3 bg-light" id="floatingEmail"
                                            value="{{ Auth::user()->email }}" placeholder="Email" disabled>
                                        <label for="floatingEmail">
                                            <i class="bi bi-envelope me-2"></i>Email
                                        </label>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                            <i class="bi bi-shield-check me-1"></i>Đã xác minh
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" name="phone_number"
                                            class="form-control rounded-3 @error('phone_number') is-invalid @enderror"
                                            id="floatingPhone" value="{{ Auth::user()->phone_number ?? '' }}"
                                            placeholder="Số điện thoại">
                                        <label for="floatingPhone">
                                            <i class="bi bi-telephone me-2"></i>Số điện thoại
                                        </label>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if (!Auth::user()->google_id)
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="password" name="old_password"
                                                class="form-control rounded-3 @error('old_password') is-invalid @enderror"
                                                id="floatingOldPassword" placeholder="Mật khẩu cũ">
                                            <label for="floatingOldPassword">
                                                <i class="bi bi-lock me-2"></i>Mật khẩu cũ
                                            </label>
                                            @error('old_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="password" name="new_password"
                                                class="form-control rounded-3 @error('new_password') is-invalid @enderror"
                                                id="floatingNewPassword" placeholder="Mật khẩu mới">
                                            <label for="floatingNewPassword">
                                                <i class="bi bi-key me-2"></i>Mật khẩu mới
                                            </label>
                                            @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="address" class="form-control rounded-3 @error('address') is-invalid @enderror" id="floatingAddress"
                                            placeholder="Địa chỉ" style="height: 100px;">{{ Auth::user()->address ?? '' }}</textarea>
                                        <label for="floatingAddress">
                                            <i class="bi bi-geo-alt me-2"></i>Địa chỉ
                                        </label>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Cập nhật thông tin
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        }

        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .form-floating>.form-control:focus~label {
            color: #667eea;
        }

        .form-floating>.form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success') || session('received-success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('orderModal'));
                modal.show();
            });
        </script>
    @endif

    @if (session('received-error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('orderErrorModal'));
                modal.show();
                setTimeout(() => modal.hide(), 4000);
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reviewModal = document.getElementById('reviewModal');
            if (reviewModal) {
                reviewModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const productId = button.getAttribute('data-product-id');
                    const productName = button.getAttribute('data-product-name');
                    const orderDetailId = button.getAttribute('data-order-detail-id');

                    const modalTitle = reviewModal.querySelector('#productNameToReview');
                    const productIdInput = reviewModal.querySelector('#productIdToReview');
                    const orderDetailIdInput = reviewModal.querySelector('#orderDetailIdToReview');

                    modalTitle.textContent = productName;
                    productIdInput.value = productId;
                    orderDetailIdInput.value = orderDetailId;
                });
            }
        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.open-client-cancel-modal');
    const form = document.getElementById('client-cancel-form');
    const modal = new bootstrap.Modal(document.getElementById('clientCancelModal'));
    const reasonField = document.getElementById('cancel_reason');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            form.action = `/order/${orderId}/cancel-request`;
            form.reset();
            modal.show();
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const reason = reasonField.value.trim();

        if (reason.length < 10) {
            reasonField.classList.add('is-invalid');
            reasonField.focus();
            return;
        }

        reasonField.classList.remove('is-invalid');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ cancel_reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            modal.hide();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: data.message,
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: data.message,
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            modal.hide();
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Đã có lỗi xảy ra. Vui lòng thử lại!',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        });
    });
});
</script>

    <script>
        function showReturnRequestPrompt(orderId) {
            Swal.fire({
                title: 'Yêu cầu trả hàng',
                input: 'textarea',
                inputLabel: 'Lý do yêu cầu trả hàng (bắt buộc)',
                inputPlaceholder: 'Vui lòng mô tả vấn đề của bạn...',
                inputAttributes: {
                    'aria-label': 'Lý do trả hàng',
                    'rows': 4
                },
                inputValidator: (value) => {
                    if (!value.trim()) {
                        return 'Bạn phải nhập lý do trả hàng!';
                    }
                },
                showCancelButton: true,
                confirmButtonText: 'Gửi yêu cầu',
                cancelButtonText: 'Huỷ'
            }).then((result) => {
                if (result.isConfirmed) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/orders/${orderId}/return-request`;

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = csrfToken;
                    form.appendChild(token);

                    const reason = document.createElement('input');
                    reason.type = 'hidden';
                    reason.name = 'reason';
                    reason.value = result.value;
                    form.appendChild(reason);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gắn sự kiện click bằng event delegation
            document.addEventListener('click', function(event) {
                if (event.target.closest('.btn-received')) {
                    const button = event.target.closest('.btn-received');
                    const orderId = button.dataset.orderId;
                    const orderCode = button.dataset.orderCode;
                    console.log('Clicked Đã nhận hàng:', {
                        orderId,
                        orderCode
                    });

                    Swal.fire({
                        title: 'Xác nhận nhận hàng',
                        text: `Bạn có chắc chắn đã nhận được đơn hàng #${orderCode}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            button.disabled = true;
                            button.innerHTML =
                                '<i class="bi bi-hourglass-split me-2"></i>Đang xử lý...';
                            return fetch("{{ route('order.received', ':id') }}".replace(':id',
                                    orderId), {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => {
                                    console.log('Response status:', response.status);
                                    if (!response.ok) {
                                        throw new Error(
                                            `HTTP error! Status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .catch(error => {
                                    console.error('Fetch error:', error);
                                    Swal.showValidationMessage(`Lỗi: ${error.message}`);
                                });
                        }
                    }).then((result) => {
                        button.disabled = false;
                        button.innerHTML = '<i class="bi bi-check-circle me-2"></i>Đã nhận hàng';
                        if (result.isConfirmed) {
                            console.log('Fetch result:', result.value);
                            const modal = new bootstrap.Modal(document.getElementById(result.value
                                .success ? 'orderModal' : 'orderErrorModal'));
                            const modalMessage = modal._element.querySelector('.modal-body h4');
                            modalMessage.textContent = result.value.message;
                            modal.show();
                            if (result.value.success) {
                                setTimeout(() => {
                                    modal.hide();
                                    location.reload();
                                }, 4000);
                            }
                        }
                    });
                }
            });
        });
    </script>

    <script>
        sessionStorage.removeItem('paymentInProgress');
    </script>

    @vite('resources/js/app.js')
    <script defer>
        window.addEventListener('load', () => {
            console.log('User ID:', {{ auth()->id() ?? 'null' }});
            console.log('Echo:', window.Echo);
            if (window.Echo) {
                window.Echo.channel(`orders.{{ auth()->id() }}`)
                    .subscribed(() => {
                        console.log('Đã đăng ký kênh orders.{{ auth()->id() }}');
                    })
                    .listen('.order.status.updated', (e) => {
                        console.log('Đơn hàng đã cập nhật:', e);
                        console.log('Tìm order_code:', e.order_code);
                        const orderElement = document.querySelector(`[data-order-code="${e.order_code}"]`);
                        console.log('Order element:', orderElement);
                        if (orderElement) {
                            const statusBadge = orderElement.querySelector('[data-status-badge]');
                            console.log('Status badge:', statusBadge);
                            if (statusBadge) {
                                console.log('Cập nhật status:', e.status, 'Label:', getStatusLabel(e.status));
                                statusBadge.textContent = getStatusLabel(e.status);
                                statusBadge.className =
                                    `badge ${getStatusColor(e.status)} px-3 py-2 rounded-pill`;
                            } else {
                                console.error('Không tìm thấy status badge');
                            }
                            updateOrderActions(orderElement, e.status, e.id);
                        } else {
                            console.error('Không tìm thấy order element với order_code:', e.order_code);
                        }
                    })
                    .error((error) => {
                        console.error('Lỗi khi đăng ký kênh:', error);
                    });
            } else {
                console.error('Echo không được khởi tạo');
            }
        });

        function getStatusLabel(status) {
            const statusMap = {
                'pending': 'Chờ xác nhận',
                'processing': 'Đang xử lý',
                'shipped': 'Đang giao hàng',
                'delivered': 'Đã giao hàng',
                'completed': 'Đã hoàn thành',
                'cancelled': 'Đơn đã hủy',
                'refund_in_processing': 'Đang xử lý trả hàng',
                'refunded': 'Đã hoàn tiền'
            };
            console.log('Status:', status, 'Label:', statusMap[status] || status);
            return statusMap[status] || status;
        }

        function getStatusColor(status) {
            const colorMap = {
                'pending': 'bg-warning text-dark',
                'processing': 'bg-primary',
                'shipped': 'bg-info',
                'delivered': 'bg-success',
                'completed': 'bg-dark',
                'cancelled': 'bg-danger',
                'refund_in_processing': 'bg-info',
                'refunded': 'bg-success'
            };
            return colorMap[status] || 'bg-secondary';
        }

        function updateOrderActions(orderElement, status, orderId) {
            const cancelButton = orderElement.querySelector('.open-client-cancel-modal');
            const oldActionContainers = orderElement.querySelectorAll('.d-flex.justify-content-end.gap-3.mt-1');
            oldActionContainers.forEach(container => container.remove());

            const actionContainer = createActionContainer(orderElement);

            if (cancelButton) {
                cancelButton.style.display = ['pending', 'processing'].includes(status) ? 'block' : 'none';
            }

            if (status === 'delivered') {
                const receiveButton = document.createElement('button');
                receiveButton.type = 'button';
                receiveButton.className = 'btn btn-success btn-received';
                receiveButton.dataset.orderId = orderId;
                receiveButton.dataset.orderCode = orderElement.dataset.orderCode;
                receiveButton.innerHTML = '<i class="bi bi-check-circle me-2"></i>Đã nhận hàng';

                const returnButton = document.createElement('button');
                returnButton.type = 'button';
                returnButton.className = 'btn btn-outline-primary';
                returnButton.innerHTML = '<i class="bi bi-arrow-return-left me-2"></i>Trả hàng/Hoàn tiền';
                returnButton.onclick = () => showReturnRequestPrompt(orderId);

                actionContainer.appendChild(receiveButton);
                actionContainer.appendChild(returnButton);
            } else if (status === 'refund_in_processing') {
                const span = document.createElement('span');
                span.className = 'text-info';
                span.textContent = 'Đang xử lý yêu cầu trả hàng';
                actionContainer.appendChild(span);
            } else if (status === 'refunded') {
                const span = document.createElement('span');
                span.className = 'text-success';
                span.textContent = 'Đã hoàn tiền';
                actionContainer.appendChild(span);
            }
        }

        function createActionContainer(orderElement) {
            const container = document.createElement('div');
            container.className = 'd-flex justify-content-end gap-3 mt-1 flex-wrap';
            const accordionHeader = orderElement.querySelector('.accordion-header');
            const flexColumn = accordionHeader.querySelector(
                '.d-flex.align-items-end.bg-light.rounded-4.p-4.border-0.flex-column');
            if (flexColumn) {
                flexColumn.appendChild(container);
            } else {
                accordionHeader.appendChild(container);
            }
            return container;
        }
    </script>
@endsection
