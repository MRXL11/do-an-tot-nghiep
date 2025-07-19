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
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ Auth::user()->phone_number ?? '' }}" placeholder="Nhập số điện thoại">
                            </div>
                            @if (!Auth::user()->google_id)
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu cũ</label>
                                    <input type="password" name="old_password" class="form-control"
                                        placeholder="Nhập mật khẩu cũ">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input type="password" name="new_password" class="form-control"
                                        placeholder="Nhập mật khẩu mới">
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ Auth::user()->address ?? '' }}" placeholder="Nhập địa chỉ">
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $order->id }}">
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
                                            <div class="row mb-3">
                                                <div class="col-12 mb-1"><h6 class="mb-1"><strong>Thông tin người nhận:</strong> {{ $order->shippingAddress->name }} - {{ $order->shippingAddress->phone_number }}</h6></div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3 col-6 mb-2"><h6 class="mb-1"><strong>Phương thức thanh toán:</strong></h6><p class="mb-0">{{ $order->getPaymentMethod($order->payment_method)['label'] }}</p></div>
                                                <div class="col-md-3 col-6 mb-2"><h6 class="mb-1"><strong>Trạng thái thanh toán:</strong></h6><p class="mb-0">{{ $order->getPaymentStatus($order->payment_status)['label'] }}</p></div>
                                                <div class="col-md-3 col-6 mb-2">
                                                    <h6 class="mb-1"><strong>Trạng thái đơn hàng:</strong></h6>
                                                    @if ($order->returnRequest && method_exists($order->returnRequest, 'getStatusText'))
                                                        <span class="badge bg-info p-2">{{ $order->returnRequest->getStatusText() }}</span>
                                                    @else
                                                        <span class="badge {{ $order->getStatusMeta($order->status)['color'] }} p-2">{{ $order->getStatusMeta($order->status)['label'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 col-6 mb-2"><h6 class="mb-1"><strong>Địa chỉ nhận hàng:</strong></h6><p class="mb-0">{{ $order->shippingAddress->full_address }}</p></div>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr><th>Sản phẩm</th><th>Màu</th><th>Size</th><th>Số lượng</th><th>Đơn giá</th><th>Tổng</th></tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $detail)
                                                        <tr>
                                                            <td>{{ $detail->productVariant->product->name }}</td>
                                                            <td>{{ $detail->productVariant->color }}</td>
                                                            <td>{{ $detail->productVariant->size }}</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                                                            <td>{{ number_format($detail->subtotal, 0, ',', '.') }}₫</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-start gap-2 mt-3 flex-wrap align-items-center">
                                                        @if (in_array($order->status, ['pending', 'processing']))
                                                            <form action="{{ route('order.cancel.request', [$order->id, 'Tôi muốn huỷ đơn hàng']) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?')"><i class="bi bi-x-circle"></i> Hủy đơn hàng</button>
                                                            </form>
                                                        @elseif($order->status === 'delivered')
                                                            @if (!$order->returnRequest)
                                                                <form action="{{ route('order.received', $order->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận bạn đã nhận được hàng?')"><i class="bi bi-check-circle"></i> Đã nhận hàng</button>
                                                                </form>
                                                                <form action="{{ route('orders.requestReturn', $order->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-primary" onclick="return confirm('Bạn có chắc muốn yêu cầu trả hàng không?')"><i class="bi bi-caret-left"></i> Trả hàng / Hoàn tiền</button>
                                                                </form>
                                                            @elseif ($order->returnRequest->status === 'rejected')
                                                                <span class="text-danger me-3"><i class="bi bi-x-circle"></i> Yêu cầu trả hàng bị từ chối.</span>
                                                                <form action="{{ route('order.received', $order->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận bạn đã nhận được hàng?')"><i class="bi bi-check-circle"></i> Đã nhận hàng</button>
                                                                </form>
                                                            @elseif ($order->returnRequest->status === 'refunded')
                                                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Đơn hàng đã được hoàn tiền.</span>
                                                            @else
                                                                <span class="text-info"><i class="bi bi-hourglass-split"></i> Yêu cầu trả hàng đang được xử lý...</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between"><strong>Tổng tiền hàng:</strong> <span>{{ number_format($order->total, 0, ',', '.') }}₫</span></li>
                                                        <li class="list-group-item d-flex justify-content-between"><strong>Giảm:</strong> <span>-{{ number_format($order->calculated_discount ?? 0, 0, ',', '.') }}₫</span></li>
                                                        <li class="list-group-item d-flex justify-content-between"><strong>Phí vận chuyển:</strong> <span>20.000₫</span></li>
                                                        <li class="list-group-item d-flex justify-content-between"><strong>Thành tiền:</strong> <span class="fw-bold fs-5 text-danger">{{ number_format($order->total_price, 0, ',', '.') }}₫</span></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            @if ($order->status === 'completed')
                                                <div class="border-top pt-3 mt-3">
                                                    <h6 class="fw-semibold">Đánh giá sản phẩm:</h6>
                                                    <ul class="list-group">
                                                        @foreach ($order->orderDetails as $detail)
                                                            @php
                                                                $review = \App\Models\Review::where('order_detail_id', $detail->id)->first();
                                                            @endphp
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>{{ $detail->productVariant->product->name }}</span>
                                                                @if ($review)
                                                                    <div class="text-warning">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
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
                                <div class="text-center p-3"><p class="mb-0">Không có đơn hàng nào.</p></div>
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
                        <button type="submit" class="btn btn-dark w-100"><i class="bi bi-send me-1"></i>Gửi đánh giá</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
@endsection