@extends('client.pages.page-layout')

@section('content')
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
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

            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    @if (session('order-success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 rounded-3 border-0 shadow-sm"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('order-success') }}
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
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('return-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('return-error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3 rounded-3 border-0 shadow-sm"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('return-error') }}
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
                                {{ $totalOrderCount }} đơn hàng
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="accordion accordion-flush" id="orderAccordion">
                            @forelse ($orders as $order)
                                <div class="accordion-item border-0 mb-4 rounded-4 shadow-sm overflow-hidden">
                                    <h2 class="accordion-header" id="heading{{ $order->id }}">
                                        <button class="accordion-button collapsed bg-light border-0 p-4 shadow-none"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $order->id }}">
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <h6 class="fw-bold text-dark mb-0 me-2">
                                                            {{ $order->shippingAddress->name }}</h6>
                                                        @php
                                                            $paymentStatusMeta = $order->getPaymentStatus(
                                                                $order->payment_status,
                                                            );
                                                            $isRequested = $order->cancellation_requested;
                                                            $isConfirmed = $order->cancel_confirmed;
                                                            $isCancelled = $order->status === 'cancelled';
                                                            $customerReason = $order->cancel_reason;
                                                            $adminReason = $order->admin_cancel_note;
                                                            $returnRequest = $order->returnRequest;
                                                            $hasReturnRequest = $returnRequest !== null;
                                                            $vpnRetry =
                                                                in_array($order->payment_method, [
                                                                    'online',
                                                                    'bank_transfer',
                                                                ]) &&
                                                                $order->payment_status === 'pending' &&
                                                                !empty($order->vnp_txn_ref) &&
                                                                !($isRequested || $isCancelled || $adminReason);
                                                        @endphp
                                                        <span class="badge"
                                                            style="background-color: {{ $paymentStatusMeta['color'] }}; font-size: 0.75em;">
                                                            {{ $paymentStatusMeta['label'] }}
                                                        </span>
                                                    </div>
                                                    <small class="text-muted d-block mb-2">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        {{ $order->created_at->format('d/m/Y - H:i') }}
                                                    </small>
                                                    <p class="text-muted mb-0 small" style="font-size: 0.9em;">
                                                        <i class="bi bi-geo-alt me-1"></i>
                                                        {{ $order->shippingAddress->full_address }}
                                                    </p>
                                                </div>
                                                <div class="text-end ms-3">
                                                    <span
                                                        class="badge {{ $order->getStatusMeta($order->status)['color'] }} px-3 py-2 rounded-pill">
                                                        {{ $order->getStatusMeta($order->status)['label'] }}
                                                    </span>
                                                    <div class="mt-2">
                                                        <span class="fw-bold text-primary fs-5">
                                                            {{ number_format($order->total_price, 0, ',', '.') }}₫
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </h2>

                                    <div class="accordion-body border-top">

                                        @if ($order->status !== 'completed' && ($isRequested || $isCancelled || $adminReason || $returnRequest))
                                            <div class="">
                                                <div class="bg-light border rounded px-2 py-2 small text-muted"
                                                    style="font-size: 0.85rem;">
                                                    {{-- 💥 Huỷ đơn hàng --}}
                                                    @if ($isRequested || $isCancelled || $adminReason)
                                                        {{-- ✅ Trường hợp 1: Khách yêu cầu và admin xác nhận -> đơn bị huỷ --}}
                                                        @if ($isCancelled && $isRequested && $isConfirmed)
                                                            <i class="bi bi-person-fill text-primary me-1"></i>
                                                            <span class="text-dark">Bạn đã yêu cầu huỷ:</span> -
                                                            <em>{{ $customerReason }}</em><br>
                                                            <i class="bi bi-shield-check text-success me-1"></i>
                                                            <span class="text-success">Admin đã xác nhận và đơn đã được huỷ
                                                                theo yêu cầu của bạn.</span>

                                                            {{-- 🛑 Trường hợp 2: Admin chủ động huỷ --}}
                                                        @elseif ($isCancelled && !$isRequested && $adminReason)
                                                            <i class="bi bi-person-badge-fill text-danger me-1"></i>
                                                            <span class="text-dark">Admin huỷ đơn hàng:</span>
                                                            <em>{{ $adminReason }}</em>

                                                            {{-- ⏳ Trường hợp 3: Khách gửi yêu cầu, chưa xác nhận --}}
                                                        @elseif ($isRequested && !$isConfirmed && !$isCancelled)
                                                            <i class="bi bi-person-fill text-primary me-1"></i>
                                                            <span class="text-dark">Bạn đã gửi yêu cầu huỷ:</span>
                                                            <em>{{ $customerReason ?? 'Không có lý do' }}</em><br>
                                                            <i class="bi bi-clock-history me-1"></i>
                                                            <span class="text-muted fst-italic">Đang chờ phản hồi từ
                                                                admin.</span>

                                                            {{-- ❌ Trường hợp 4: Bị từ chối --}}
                                                        @elseif ($isRequested && $isConfirmed && !$isCancelled && $adminReason)
                                                            <i class="bi bi-person-fill text-primary me-1"></i>
                                                            <span class="text-dark">Bạn đã gửi yêu cầu huỷ:</span>
                                                            <em>{{ $customerReason }}</em><br>
                                                            <i class="bi bi-shield-x text-danger me-1"></i>
                                                            <span class="text-danger">Admin đã từ chối yêu cầu huỷ:</span>
                                                            <em>{{ $adminReason }}</em>

                                                            {{-- ⚠️ Trường hợp thanh toán thất bại --}}
                                                        @elseif (!empty($order->vnp_txn_ref) && $order->payment_status === 'failed')
                                                            <i class="bi bi-person-fill text-primary me-1"></i>
                                                            <span class="text-dark">Bạn đã huỷ thanh toán nên đơn hàng bị
                                                                huỷ.</span>

                                                            {{-- ❓ Không rõ lý do --}}
                                                        @else
                                                            <span class="text-muted fst-italic">Không có lý do được cung
                                                                cấp.</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                
                                                @if ($returnRequest)
                                                    <div class="bg-light border rounded px-2 py-2 small text-muted mt-1"
                                                        style="font-size: 0.85rem;">
                                                        {{-- 📦 Trạng thái trả hàng --}}

                                                        <i class="bi bi-arrow-return-left text-primary me-1"></i>
                                                        <span class="text-dark">Bạn đã gửi yêu cầu trả hàng:</span>
                                                        <em>{{ $returnRequest->reason ?? 'Không có lý do' }}</em><br>

                                                        @switch($returnRequest->status)
                                                            @case('requested')
                                                                <i class="bi bi-clock-history me-1"></i>
                                                                <span class="text-muted fst-italic">Đang chờ phản hồi từ
                                                                    admin.</span>
                                                            @break

                                                            @case('approved')
                                                                <i class="bi bi-shield-check text-success me-1"></i>
                                                                <span class="text-success">{{ $returnRequest->admin_note }}</span>
                                                            @break

                                                            @case('rejected')
                                                                <i class="bi bi-shield-x text-danger me-1"></i>
                                                                <span class="text-danger">
                                                                    Yêu cầu trả hàng đã bị từ chối. Lý do:
                                                                    {{ $returnRequest->admin_note ?? 'Không có lý do' }}
                                                                </span>
                                                            @break

                                                            @case('refunded')
                                                                <i class="bi bi-check-circle-fill text-primary me-1"></i>
                                                                <span class="text-primary">
                                                                    {{ $returnRequest->admin_note ?? 'Yêu cầu trả hàng / hoàn tiền đã hoàn tất.' }}
                                                                </span>
                                                            @break
                                                        @endswitch
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- end --}}
                                        <div class="d-flex justify-content-end gap-2 mt-1">
                                            @if ($vpnRetry)
                                                <form id="retry-payment-form"
                                                    action="{{ route('checkout.retry', $order->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="javascript:void(0)"
                                                    onclick="document.getElementById('retry-payment-form').submit();"
                                                    class="btn btn-outline-primary">
                                                    🔁 Thanh toán lại
                                                </a>
                                            @else
                                            @endif
                                        </div>

                                        <!-- Các nút hành động -->
                                        <div class="d-flex justify-content-end gap-2 mt-3">
                                            @if (in_array($order->status, ['pending', 'processing']))
                                                @if (!$isRequested && !$isCancelled)
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger open-client-cancel-modal"
                                                        data-order-id="{{ $order->id }}">
                                                        <i class="bi bi-x-circle me-1"></i>Huỷ đơn hàng
                                                    </button>
                                                @endif
                                            @elseif($order->status === 'delivered')
                                                @if (!$returnRequest)
                                                    <form action="{{ route('order.received', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Chỉ chọn nút này khi bạn đã nhận được hàng! Xác nhận?')">
                                                            Đã nhận hàng
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="showReturnRequestPrompt({{ $order->id }})">
                                                        Trả hàng/Hoàn tiền
                                                    </button>
                                                @else
                                                    @if ($returnRequest->status === 'rejected')
                                                        <form action="{{ route('order.received', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                onclick="return confirm('Yêu cầu hoàn hàng của bạn đã bị từ chối. Bạn xác nhận đã nhận hàng?')">
                                                                Xác nhận đã nhận hàng
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <div id="collapse{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#orderAccordion">
                                        <div class="accordion-body p-4 bg-white">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="fw-bold text-dark mb-0">Mã đơn hàng: #{{ $order->order_code }}
                                                </h5>
                                                <h6 class="mb-0">
                                                    {{ $order->getPaymentMethod($order->payment_method)['label'] }}
                                                </h6>
                                            </div>
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
                                                                <td class="align-middle"><span
                                                                        class="badge bg-secondary p-2">{{ $detail->productVariant->color }}</span>
                                                                </td>
                                                                <td class="align-middle"><span
                                                                        class="badge bg-info p-2">{{ $detail->productVariant->size }}</span>
                                                                </td>
                                                                <td class="align-middle"><span
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

                                            <div class="row justify-content-end mt-3">
                                                <div class="col-md-6">
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



                                            @if ($order->status === 'completed')
                                                <div class="border-top pt-3 mt-3">
                                                    <h6 class="fw-semibold">Đánh giá sản phẩm:</h6>
                                                    <ul class="list-group">
                                                        @foreach ($order->orderDetails as $detail)
                                                            @php
                                                                $review = \App\Models\Review::where(
                                                                    'order_detail_id',
                                                                    $detail->id,
                                                                )->first();
                                                            @endphp
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>{{ $detail->productVariant->product->name }}</span>
                                                                @if ($review)
                                                                    <div class="text-warning">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i
                                                                                class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                                                        @endfor
                                                                    </div>
                                                                @else
                                                                    <button class="btn btn-outline-warning btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#reviewModal"
                                                                        data-product-id="{{ $detail->productVariant->product->id }}"
                                                                        data-product-name="{{ $detail->productVariant->product->name }}"
                                                                        data-order-detail-id="{{ $detail->id }}">
                                                                        <i class="bi bi-star"></i> Viết đánh giá
                                                                    </button>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
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
                            <div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="clientCancelModal" tabindex="-1" aria-labelledby="clientCancelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="client-cancel-form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="bi bi-x-circle me-2"></i>Yêu cầu huỷ đơn hàng</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="cancel_reason" class="form-label">Lý do huỷ đơn hàng:</label>
                                <textarea name="cancel_reason" id="cancel_reason" rows="3" class="form-control"
                                    placeholder="Nhập lý do huỷ..."></textarea>
                                <div class="invalid-feedback">Vui lòng nhập lý do huỷ đơn hàng (ít nhất 10 ký tự).</div>
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

        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-gradient-success text-white rounded-top-4 border-0">
                        <h5 class="modal-title fw-bold" id="orderModalLabel"><i
                                class="bi bi-check-circle-fill me-2"></i>Thành công</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body text-center p-5">
                        <div class="mb-4"><i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="mb-3">{{ session('received-success') }}</h4>
                        <p class="text-muted">Cảm ơn bạn đã tin tưởng sử dụng dịch vụ của chúng tôi!</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-success btn-lg rounded-pill px-4" data-bs-dismiss="modal"><i
                                class="bi bi-hand-thumbs-up me-2"></i>Tuyệt vời</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="orderErrorModal" tabindex="-1" aria-labelledby="orderErrorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-gradient-danger text-white rounded-top-4 border-0">
                        <h5 class="modal-title fw-bold" id="orderErrorModalLabel"><i
                                class="bi bi-exclamation-triangle-fill me-2"></i>Có lỗi xảy ra</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body text-center p-5">
                        <div class="mb-4"><i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i></div>
                        <h4 class="mb-3 text-danger">{{ session('received-error') }}</h4>
                        <p class="text-muted">Vui lòng thử lại sau hoặc liên hệ với chúng tôi để được hỗ trợ.</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-outline-danger btn-lg rounded-pill px-4"
                            data-bs-dismiss="modal"><i class="bi bi-arrow-clockwise me-2"></i>Thử lại</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm: <span
                                id="productNameToReview"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="productIdToReview">
                            <input type="hidden" name="order_detail_id" id="orderDetailIdToReview">
                            <div class="mb-3">
                                <label class="form-label">Điểm đánh giá</label>
                                <select class="form-select w-auto" name="rating" required>
                                    <option value="">Chọn số sao</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} sao</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea class="form-control" rows="4" name="comment" placeholder="Nhận xét của bạn về sản phẩm..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100"><i class="bi bi-send me-1"></i>Gửi đánh
                                giá</button>
                        </form>
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
                    setTimeout(() => {
                        modal.hide();
                    }, 4000);
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

                const cancelButtons = document.querySelectorAll('.open-client-cancel-modal');
                const cancelForm = document.getElementById('client-cancel-form');
                const cancelModal = new bootstrap.Modal(document.getElementById('clientCancelModal'));
                const reasonField = document.getElementById('cancel_reason');
                cancelButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.dataset.orderId;
                        cancelForm.action = `/order/${orderId}/cancel-request`;
                        cancelForm.reset();
                        cancelModal.show();
                    });
                });
                cancelForm.addEventListener('submit', function(e) {
                    const reason = reasonField.value.trim();
                    if (reason.length < 10) {
                        e.preventDefault();
                        reasonField.classList.add('is-invalid');
                        reasonField.focus();
                    } else {
                        reasonField.classList.remove('is-invalid');
                    }
                });
            });

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
                        if (!value.trim()) return 'Bạn phải nhập lý do trả hàng!';
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

            sessionStorage.removeItem('paymentInProgress');
        </script>
    @endsection
