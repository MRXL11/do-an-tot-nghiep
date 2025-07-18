@extends('client.pages.page-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="mb-0">Thông tin người dùng</h5>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('account.update') }}">
                            @csrf
                            <div class="mb-3 text-center">
                                <img src="{{ Auth::user()->avatar ?? 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp' }}"
                                    class="rounded-circle mb-2" width="100" height="100" alt="Avatar">
                                <h6 class="card-title">{{ Auth::user()->name }}</h6>
                                <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ Auth::user()->name }}" placeholder="Nhập họ tên">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                <small class="text-success d-block mt-1">Đã xác minh ✅</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ Auth::user()->phone_number ?? '' }}" placeholder="Nhập số điện thoại">
                                @error('phone_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if (!Auth::user()->google_id)
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu cũ</label>
                                    <input type="password" name="old_password" class="form-control"
                                        placeholder="Nhập mật khẩu cũ">
                                    @error('old_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input type="password" name="new_password" class="form-control"
                                        placeholder="Nhập mật khẩu mới">
                                    @error('new_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ Auth::user()->address ?? '' }}" placeholder="Nhập địa chỉ">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">

                    @if (session('order-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('order-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('cancel-request-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('cancel-request-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('cancel-request-error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('cancel-request-error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Lịch sử đơn hàng</h5>
                    </div>

                    <div class="card-body">
                        <div class="accordion" id="orderAccordion">
                            @forelse ($orders as $order)
                                <div class="accordion-item mb-2 border rounded shadow-sm">
                                    <h2 class="accordion-header" id="heading{{ $order->id }}">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}">
                                            <div>
                                                <i class="bi bi-box-seam me-2 text-primary"></i>
                                                <strong>#{{ $order->order_code }}</strong> • <span
                                                    class="text-muted small ms-2">{{ $order->created_at->format('d/m/Y - H:i') }}</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#orderAccordion">
                                        <div class="accordion-body">
                                            {{-- Hiển thị thông tin đơn hàng --}}
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sản phẩm</th>
                                                        <th>Chi tiết</th>
                                                        <th>Số lượng</th>
                                                        <th>Thành tiền</th>
                                                        <th style="width: 25%;">Hành động/Đánh giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $detail)
                                                        <tr>
                                                            <td>{{ $detail->productVariant->product->name }}</td>
                                                            <td>Màu: {{ $detail->productVariant->color }}, Size:
                                                                {{ $detail->productVariant->size }}</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ number_format($detail->subtotal, 0, ',', '.') }}₫</td>
                                                            <td>
                                                                {{-- KIỂM TRA TRẠNG THÁI ĐƠN HÀNG ĐÃ HOÀN THÀNH --}}
                                                                @if ($order->status === 'completed')
                                                                    @php
                                                                        // Kiểm tra xem user đã review sản phẩm này chưa
                                                                        $existingReview = $detail->productVariant->product->reviews
                                                                            ->where('user_id', Auth::id())
                                                                            ->first();
                                                                    @endphp

                                                                    @if ($existingReview)
                                                                        {{-- NẾU ĐÃ REVIEW THÌ HIỂN THỊ LỊCH SỬ --}}
                                                                        <div class="text-start">
                                                                            <div>
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <i class="bi bi-star{{ $i <= $existingReview->rating ? '-fill' : '' }} text-warning"></i>
                                                                                @endfor
                                                                            </div>
                                                                            <p class="mb-0 fst-italic small text-muted">
                                                                                "{{ Str::limit($existingReview->comment, 50) }}"
                                                                            </p>
                                                                            <small class="text-muted">
                                                                                ({{ $existingReview->created_at->format('d/m/Y') }})
                                                                            </small>
                                                                        </div>
                                                                    @else
                                                                        {{-- NẾU CHƯA REVIEW THÌ HIỂN THỊ NÚT ĐÁNH GIÁ --}}
                                                                        <button type="button"
                                                                            class="btn btn-outline-warning btn-sm btn-review"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#reviewModal"
                                                                            data-product-id="{{ $detail->productVariant->product->id }}"
                                                                            data-product-name="{{ $detail->productVariant->product->name }}">
                                                                            <i class="bi bi-star"></i> Đánh giá
                                                                        </button>
                                                                    @endif
                                                                @else
                                                                    <small class="text-muted">Hoàn thành đơn để đánh giá</small>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{-- Các nút chức năng và tổng tiền --}}
                                            <div class="d-flex justify-content-end gap-2 mt-3 flex-wrap">
                                                @if (in_array($order->status, ['pending', 'processing']))
                                                    <form
                                                        action="{{ route('order.cancel.request', [$order->id, ($message = 'Tôi muốn huỷ đơn hàng')]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                                            <i class="bi bi-x-circle"></i> Hủy đơn hàng
                                                        </button>
                                                    </form>
                                                @elseif($order->status === 'delivered')
                                                    @if (!$order->returnRequest)
                                                        <form action="{{ route('order.received', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-success"
                                                                onclick="return confirm('Xác nhận bạn đã nhận được hàng?')">
                                                                <i class="bi bi-check-circle"></i> Đã nhận hàng
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('orders.requestReturn', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-primary"
                                                                onclick="return confirm('Bạn có chắc muốn yêu cầu trả hàng không?')">
                                                                <i class="bi bi-arrow-return-left"></i> Trả hàng / Hoàn tiền
                                                            </button>
                                                        </form>
                                                    @else
                                                         <span
                                                            class="bg-{{ $order->returnRequest->return_status['color'] }} align-self-center"
                                                            style="cursor: default; padding: 0.5rem 1rem; border-radius: 0.5rem;color: white;">
                                                            <i class="{{ $order->returnRequest->return_status['icon'] }}"></i>
                                                            {{ $order->returnRequest->return_status['label'] }}
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center p-3">
                                    <p class="mb-0">Bạn chưa có đơn hàng nào.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm: <span id="productNameToReview"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" id="productIdToReview">
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
                        <button type="submit" class="btn btn-dark w-100"><i class="bi bi-send me-1"></i>Gửi đánh giá</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Giữ nguyên các modal thông báo khác --}}

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var reviewModal = document.getElementById('reviewModal');
            if (reviewModal) {
                reviewModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var productId = button.getAttribute('data-product-id');
                    var productName = button.getAttribute('data-product-name');

                    var modalTitle = reviewModal.querySelector('#productNameToReview');
                    var productIdInput = reviewModal.querySelector('#productIdToReview');

                    modalTitle.textContent = productName;
                    productIdInput.value = productId;
                });
            }

            @if (session('received-success'))
                const successModal = new bootstrap.Modal(document.getElementById('orderModal'));
                successModal.show();
            @endif

            @if (session('received-error'))
                const errorModal = new bootstrap.Modal(document.getElementById('orderErrorModal'));
                errorModal.show();
                setTimeout(() => {
                    errorModal.hide();
                }, 4000);
            @endif
        });
    </script>
@endsection