@extends('client.pages.page-layout')

@section('content')
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
            <!-- Left Column: User Profile -->
            <div class="col-xl-4 col-lg-5">
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

            <!-- Right Column: Order History -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    <!-- Success/Error Alerts -->
                    @if (session('order-success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 rounded-3 border-0 shadow-sm"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('order-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('cancel-request-success'))
                        <div class="alert alert-success mt-3">{{ session('cancel-request-success') }}</div>
                    @elseif (session('cancel-request-error'))
                        <div class="alert alert-danger mt-3">{{ session('cancel-request-error') }}</div>
                    @endif

                    @if (session('return-success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 rounded-3 border-0 shadow-sm"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('return-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('return-error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3 rounded-3 border-0 shadow-sm"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ session('return-error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-header bg-gradient-primary text-white p-4 border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-receipt-cutoff fs-4 me-3"></i>
                                <h5 class="mb-0 fw-bold">Lịch sử đơn hàng</h5>
                            </div>
                            <span class="badge bg-white text-primary rounded-pill px-3 py-2">
                                {{ count($orders) }} đơn hàng
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="accordion accordion-flush" id="orderAccordion">
                            @forelse ($orders as $order)
                                <div class="accordion-item border-0 mb-4 rounded-4 shadow-sm overflow-hidden">
                                    <h2 class="accordion-header" id="heading{{ $order->id }}">
                                        <div class="d-flex align-items-center bg-light rounded-4 p-4 border-0">
                                            <button
                                                class="accordion-button collapsed bg-transparent border-0 p-0 flex-grow-1 shadow-none"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $order->id }}">
                                                <div class="d-flex align-items-center justify-content-between w-100">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary rounded-circle p-2 me-3">
                                                            <i class="bi bi-box-seam text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold text-dark">
                                                                #{{ $order->order_code }}
                                                            </h6>
                                                            <small class="text-muted">
                                                                <i class="bi bi-calendar3 me-1"></i>
                                                                {{ $order->created_at->format('d/m/Y - H:i') }}
                                                            </small>
                                                            @php
                                                                $isRequested = $order->cancellation_requested;
                                                                $isConfirmed = $order->cancel_confirmed;
                                                                $isCancelled = $order->status === 'cancelled';
                                                                $customerReason = $order->cancel_reason;
                                                                $adminReason = $order->admin_cancel_note;
                                                            @endphp

                                                            @if ($isRequested || $isCancelled || $adminReason)
                                                                <div class="mt-2">
                                                                    <div class="bg-light border rounded px-2 py-1 mt-1 small text-muted"
                                                                        style="font-size: 0.85rem;">
                                                                        {{-- ✅ Trường hợp 1: Khách yêu cầu và admin xác nhận -> đơn bị huỷ --}}
                                                                        @if ($isCancelled && $isRequested && $isConfirmed)
                                                                            <i
                                                                                class="bi bi-person-fill text-primary me-1"></i>
                                                                            <span class="text-dark">Bạn đã yêu cầu
                                                                                huỷ:</span>
                                                                            <em>{{ $customerReason }}</em><br>

                                                                            <i
                                                                                class="bi bi-shield-check text-success me-1"></i>
                                                                            <span class="text-success">Admin đã xác nhận và
                                                                                đơn đã được huỷ theo yêu cầu của bạn.</span>

                                                                            {{-- 🛑 Trường hợp 2: Admin chủ động huỷ (không có yêu cầu từ khách) --}}
                                                                        @elseif ($isCancelled && !$isRequested && $adminReason)
                                                                            <i
                                                                                class="bi bi-person-badge-fill text-danger me-1"></i>
                                                                            <span class="text-dark">Admin huỷ đơn
                                                                                hàng:</span>
                                                                            <em>{{ $adminReason }}</em>

                                                                            {{-- ⏳ Trường hợp 3: Khách gửi yêu cầu, chưa xác nhận --}}
                                                                        @elseif ($isRequested && !$isConfirmed && !$isCancelled)
                                                                            <i
                                                                                class="bi bi-person-fill text-primary me-1"></i>
                                                                            <span class="text-dark">Bạn đã gửi yêu
                                                                                cầu huỷ:</span>
                                                                            <em>{{ $customerReason ?? 'Không có lý do' }}</em><br>

                                                                            <i class="bi bi-clock-history me-1"></i>
                                                                            <span class="text-muted fst-italic">Đang chờ
                                                                                phản hồi từ admin.</span>

                                                                            {{-- ❌ Trường hợp 4: Khách yêu cầu nhưng bị từ chối --}}
                                                                        @elseif ($isRequested && $isConfirmed && !$isCancelled && $adminReason)
                                                                            <i
                                                                                class="bi bi-person-fill text-primary me-1"></i>
                                                                            <span class="text-dark">Bạn đã gửi yêu
                                                                                cầu huỷ:</span>
                                                                            <em>{{ $customerReason }}</em><br>

                                                                            <i class="bi bi-shield-x text-danger me-1"></i>
                                                                            <span class="text-danger">Admin đã từ chối yêu
                                                                                cầu huỷ:</span>
                                                                            <em>{{ $adminReason }}</em>

                                                                            {{-- ❓ Không rõ lý do --}}
                                                                        @else
                                                                            <span class="text-muted fst-italic">Không có lý
                                                                                do được cung cấp.</span>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="text-end">
                                                        @if ($order->returnRequest && in_array($order->returnRequest->status, ['refunded']))
                                                            <span
                                                                class="badge bg-{{ $order->returnRequest->return_status['color'] }} px-3 py-2 rounded-pill">
                                                                <i
                                                                    class="{{ $order->returnRequest->return_status['icon'] }} me-1"></i>
                                                                {{ $order->returnRequest->return_status['title'] }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge {{ $order->getStatusMeta($order->status)['color'] }} px-3 py-2 rounded-pill">
                                                                {{ $order->getStatusMeta($order->status)['label'] }}
                                                            </span>
                                                        @endif
                                                        <div class="mt-1">
                                                            <span class="fw-bold text-primary">
                                                                {{ number_format($order->total_price, 0, ',', '.') }}₫
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>


                                            </button>


                                        </div>
                                    </h2>

                                    <div id="collapse{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#orderAccordion">
                                        <div class="accordion-body p-4 bg-white">

                                            <!-- Order Info Cards -->
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <div class="card bg-light border-0 h-100">
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title mb-2 text-primary">
                                                                <i class="bi bi-person-badge me-2"></i>Thông tin người nhận
                                                            </h6>
                                                            <p class="mb-1 fw-semibold">
                                                                {{ $order->shippingAddress->name }}</p>
                                                            <p class="mb-0 text-muted">
                                                                <i class="bi bi-telephone me-1"></i>
                                                                {{ $order->shippingAddress->phone_number }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card bg-light border-0 h-100">
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title mb-2 text-primary">
                                                                <i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng
                                                            </h6>
                                                            <p class="mb-0 text-muted">
                                                                {{ $order->shippingAddress->full_address }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Payment & Status Info -->
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                                        <i class="bi bi-credit-card text-primary fs-4 me-3"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Thanh toán</small>
                                                            <span class="fw-semibold"
                                                                style='color: {{ $order->getPaymentMethod($order->payment_method)['color'] }};'>
                                                                {{ $order->getPaymentMethod($order->payment_method)['label'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                                        <i class="bi bi-cash-coin text-success fs-4 me-3"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Trạng thái</small>
                                                            <span class="fw-semibold"
                                                                style='color: {{ $order->getPaymentStatus($order->payment_status)['color'] }};'>
                                                                {{ $order->getPaymentStatus($order->payment_status)['label'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Product Table -->
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="border-0 fw-bold">Sản phẩm</th>
                                                            <th class="border-0 fw-bold">Màu</th>
                                                            <th class="border-0 fw-bold">Size</th>
                                                            <th class="border-0 fw-bold">SL</th>
                                                            <th class="border-0 fw-bold">Đơn giá</th>
                                                            <th class="border-0 fw-bold text-end">Tổng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->orderDetails as $detail)
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="p-2 me-3">
                                                                            <img src="{{ $detail->productVariant->image }}"
                                                                                alt=""
                                                                                style="width: 50px; height: 50px; object-fit:fill;">
                                                                        </div>
                                                                        <span
                                                                            class="fw-medium">{{ $detail->productVariant->product->name }}</span>
                                                                    </div>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <span
                                                                        class="badge bg-secondary p-2">{{ $detail->productVariant->color }}</span>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <span
                                                                        class="badge bg-info p-2">{{ $detail->productVariant->size }}</span>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <span
                                                                        class="badge bg-primary p-2">{{ $detail->quantity }}</span>
                                                                </td>
                                                                <td class="align-middle">
                                                                    {{ number_format($detail->price, 0, ',', '.') }}₫</td>
                                                                <td class="align-middle text-end fw-bold">
                                                                    {{ number_format($detail->subtotal, 0, ',', '.') }}₫
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Order Summary -->
                                            <div class="row justify-content-end">
                                                <div class="col-md-12">
                                                    <div class="card border-0 bg-light">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span>Tổng tiền hàng:</span>
                                                                <span
                                                                    class="fw-semibold">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                                                            </div>
                                                            @if ($order->calculated_discount > 0)
                                                                <div
                                                                    class="d-flex justify-content-between mb-2 text-success">
                                                                    <span>Giảm giá:</span>
                                                                    <span
                                                                        class="fw-semibold">-{{ number_format($order->calculated_discount, 0, ',', '.') }}₫</span>
                                                                </div>
                                                            @endif
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span>Phí vận chuyển:</span>
                                                                <span class="fw-semibold">20.000₫</span>
                                                            </div>
                                                            <hr>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="fw-bold fs-5">Thành tiền:</span>
                                                                <span
                                                                    class="fw-bold fs-5 text-primary">{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            @if (in_array($order->status, ['pending', 'processing']))
                                                @if (!$isRequested && !$isCancelled)
                                                    <div class="d-flex justify-content-end mt-4">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-lg rounded-pill px-4 open-client-cancel-modal"
                                                            data-order-id="{{ $order->id }}">
                                                            <i class="bi bi-x-circle me-2"></i>Huỷ đơn hàng
                                                        </button>
                                                    </div>
                                                @else
                                                @endif
                                            @elseif($order->status === 'delivered')
                                                <div class="d-flex justify-content-end gap-3 mt-4 flex-wrap">
                                                    @if (!$order->returnRequest)
                                                        <form action="{{ route('order.received', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success btn-lg rounded-pill px-4"
                                                                onclick="return confirm('Chỉ chọn nút này khi bạn đã nhận được hàng! Xác nhận?')">
                                                                <i class="bi bi-check-circle me-2"></i>Đã nhận hàng
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('orders.requestReturn', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-outline-primary btn-lg rounded-pill px-4"
                                                                onclick="return confirm('Bạn có chắc muốn yêu cầu trả hàng không?')">
                                                                <i class="bi bi-arrow-return-left me-2"></i>Trả hàng/Hoàn
                                                                tiền
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span
                                                            class="badge bg-{{ $order->returnRequest->return_status['color'] }} px-4 py-3 rounded-pill fs-6">
                                                            <i
                                                                class="{{ $order->returnRequest->return_status['icon'] }} me-2"></i>
                                                            {{ $order->returnRequest->return_status['label'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                    <h4 class="text-muted mb-2">Chưa có đơn hàng nào</h4>
                                    <p class="text-muted">Hãy bắt đầu mua sắm để tạo đơn hàng đầu tiên của bạn!</p>
                                    <a href="#" class="btn btn-primary btn-lg rounded-pill px-4">
                                        <i class="bi bi-shop me-2"></i>Bắt đầu mua sắm
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Huỷ đơn từ khách -->
    <div class="modal fade" id="clientCancelModal" tabindex="-1" aria-labelledby="clientCancelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="client-cancel-form">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Yêu cầu huỷ
                            đơn hàng</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cancel_reason" class="form-label">Lý do huỷ đơn
                                hàng:</label>
                            <textarea name="cancel_reason" id="cancel_reason" rows="3" class="form-control"
                                placeholder="Nhập lý do huỷ..."></textarea>
                            <div class="invalid-feedback">
                                Vui lòng nhập lý do huỷ đơn hàng (ít nhất 10 ký tự).
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Gửi yêu cầu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-gradient-success text-white rounded-top-4 border-0">
                    <h5 class="modal-title fw-bold" id="orderModalLabel">
                        <i class="bi bi-check-circle-fill me-2"></i>Thành công
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="mb-3">{{ session('received-success') }}</h4>
                    <p class="text-muted">Cảm ơn bạn đã tin tưởng sử dụng dịch vụ của chúng tôi!</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-success btn-lg rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="bi bi-hand-thumbs-up me-2"></i>Tuyệt vời
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="orderErrorModal" tabindex="-1" aria-labelledby="orderErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-gradient-danger text-white rounded-top-4 border-0">
                    <h5 class="modal-title fw-bold" id="orderErrorModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Có lỗi xảy ra
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="mb-3 text-danger">{{ session('received-error') }}</h4>
                    <p class="text-muted">Vui lòng thử lại sau hoặc liên hệ với chúng tôi để được hỗ trợ.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-danger btn-lg rounded-pill px-4"
                        data-bs-dismiss="modal">
                        <i class="bi bi-arrow-clockwise me-2"></i>Thử lại
                    </button>
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
    @if (session('received-success'))
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

                // Tự đóng sau 4 giây
                setTimeout(() => {
                    modal.hide();
                }, 4000);
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.open-client-cancel-modal');
            const form = document.getElementById('client-cancel-form');
            const modal = new bootstrap.Modal(document.getElementById('clientCancelModal'));
            const reasonField = document.getElementById('cancel_reason');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.dataset.orderId;
                    form.action =
                        `/order/${orderId}/cancel-request`; // hoặc dùng route('orders.cancel-request', orderId)
                    form.reset(); // reset textarea
                    modal.show();
                });
            });

            // Validate lý do trước khi gửi
            form.addEventListener('submit', function(e) {
                const reason = reasonField.value.trim();

                if (reason.length < 10) {
                    e.preventDefault(); // chặn gửi form
                    reasonField.classList.add('is-invalid'); // thêm class lỗi
                    reasonField.focus();
                } else {
                    reasonField.classList.remove('is-invalid'); // xoá class lỗi
                }
            });
        });
    </script>
@endsection
