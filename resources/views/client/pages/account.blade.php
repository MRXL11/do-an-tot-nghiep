@extends('client.pages.page-layout')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Cột trái: Thông tin người dùng -->
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
                    {{-- nôi dung trên là thông báo khi có lỗi --}}

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
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}"
                                    placeholder="Nhập họ tên">
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



            <!-- Cột phải: Lịch sử đơn hàng -->
            <div class="col-md-9">
                <div class="card shadow-sm">

                    @if (session('order-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('order-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('cancel-request-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('cancel-request-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('cancel-request-error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('cancel-request-error') }}
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
                                                <div class="col-12 mb-1">
                                                    <h6 class="mb-1">
                                                        <strong>Thông tin người nhận: </strong>
                                                        <span style="text-decoration: none; color:rgb(241, 123, 123)">
                                                            {{ $order->shippingAddress->name }} -
                                                            {{ $order->shippingAddress->phone_number }}
                                                        </span>
                                                    </h6>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-3 col-12 mb-2">
                                                    <h6 class="mb-1"><strong>Phương thức thanh toán:</strong></h6>
                                                    <p class="mb-0"
                                                        style='color: {{ $order->getPaymentMethod($order->payment_method)['color'] }};'>
                                                        {{ $order->getPaymentMethod($order->payment_method)['label'] }}</p>
                                                </div>
                                                <div class="col-md-3 col-12 mb-2">
                                                    <h6 class="mb-1"><strong>Trạng thái thanh toán:</strong></h6>
                                                    <p class="mb-0"
                                                        style='color: {{ $order->getPaymentStatus($order->payment_status)['color'] }};'>
                                                        {{ $order->getPaymentStatus($order->payment_status)['label'] }}</p>
                                                </div>
                                                <div class="col-md-3 col-12 mb-2">
                                                    <h6 class="mb-1"><strong>Trạng thái đơn hàng:</strong></h6>
                                                    @if ($order->returnRequest && in_array($order->returnRequest->status, ['refunded']))
                                                        {{-- Nếu có yêu cầu trả hàng, hiển thị trạng thái trả hàng --}}
                                                        <span
                                                            class="badge bg-{{ $order->returnRequest->return_status['color'] }} p-2">
                                                            <i
                                                                class="{{ $order->returnRequest->return_status['icon'] }}"></i>
                                                            {{ $order->returnRequest->return_status['title'] }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge {{ $order->getStatusMeta($order->status)['color'] }} p-2">
                                                            {{ $order->getStatusMeta($order->status)['label'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 col-12 mb-2">
                                                    <h6 class="mb-1"><strong>Địa chỉ nhận hàng:</strong></h6>
                                                    <p class="mb-0">{{ $order->shippingAddress->full_address }}</p>
                                                </div>
                                            </div>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sản phẩm</th>
                                                        <th>Màu</th>
                                                        <th>Size</th>
                                                        <th>Số lượng</th>
                                                        <th>Đơn giá</th>
                                                        <th>Tổng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $detail)
                                                        <tr>
                                                            <td>{{ $detail->productVariant->product->name }}</td>
                                                            <td>{{ $detail->productVariant->color }}</td>
                                                            <td>{{ $detail->productVariant->size }}</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                                                            <td>{{ number_format($detail->subtotal, 0, ',', '.') }}
                                                                ₫</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="row mb-3">
                                                <div class="col-md-12 col-12 mb-2 text-end">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                                                        Tổng tiền hàng:
                                                        <span>{{ number_format($order->total, 0, ',', '.') }}₫</span>
                                                    </li>
                                                    {{-- xử lý mã mã giảm giá --}}
                                                    @if ($order->calculated_discount > 0)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                                                            Giảm:
                                                            <span>-{{ number_format($order->calculated_discount, 0, ',', '.') }}₫</span>
                                                        </li>
                                                    @else
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                                                            Giảm:
                                                            <span>-0 đ</span>
                                                        </li>
                                                    @endif

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                                                        Phí vận chuyển:
                                                        <span>20.000₫</span>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                                                        Thành tiền:
                                                        <span>{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                                                    </li>
                                                </div>

                                            </div>

                                            {{-- Nếu đơn hàng đang chờ xử lý hoặc đang xử lý: cho phép huỷ --}}
                                            @if (in_array($order->status, ['pending', 'processing']))
                                                <div class="text-end">
                                                    <form
                                                        action="{{ route('order.cancel.request', [$order->id, ($message = 'Tôi muốn huỷ đơn hàng')]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                                            <i class="bi bi-x-circle"></i> Hủy đơn hàng
                                                        </button>
                                                    </form>
                                                </div>

                                                {{-- Nếu đơn hàng đã giao: cho phép xác nhận "Đã nhận hàng" và/hoặc yêu cầu trả hàng --}}
                                            @elseif($order->status === 'delivered')
                                                <div class="d-flex justify-content-end gap-2 mt-3 flex-wrap">
                                                    {{-- Nếu chưa gửi yêu cầu trả hàng: hiện nút yêu cầu --}}
                                                    @if (!$order->returnRequest)
                                                        {{-- Nút xác nhận đã nhận hàng --}}
                                                        <form action="{{ route('order.received', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-success"
                                                                onclick="return confirm('Chỉ chọn nút này khi bạn đã nhận được hàng! Xác nhận?')">
                                                                <i class="bi bi-box-seam"></i> Đã nhận được hàng
                                                            </button>
                                                        </form>

                                                        {{-- Nút yêu cầu trả hàng --}}
                                                        <form action="{{ route('orders.requestReturn', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-primary"
                                                                onclick="return confirm('Bạn có chắc muốn yêu cầu trả hàng không?')">
                                                                <i class="bi bi-caret-left"></i> Trả hàng / Hoàn tiền
                                                            </button>
                                                        </form>

                                                        {{-- Nếu đã gửi yêu cầu trả hàng: hiển thị trạng thái yêu cầu --}}
                                                    @else
                                                        <span
                                                            class="bg-{{ $order->returnRequest->return_status['color'] }} align-self-center"
                                                            style="cursor: default; padding: 0.5rem 1rem; border-radius: 0.5rem;color: white;">
                                                            <i
                                                                class="{{ $order->returnRequest->return_status['icon'] }}"></i>
                                                            {{ $order->returnRequest->return_status['label'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Không có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal thông báo thành công -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="orderModalLabel">
                        <i class="bi bi-heart-fill me-2"></i> Thông báo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="bi bi-check-circle-fill text-success display-4 mb-3"></i>
                    <p class="mb-0 fs-5">{{ session('received-success') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- modal báo lỗi -->
    <div class="modal fade" id="orderErrorModal" tabindex="-1" aria-labelledby="orderErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="orderErrorModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Lỗi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="bi bi-x-circle-fill text-danger display-4 mb-3"></i>
                    <p class="mb-0 fs-5">{{ session('received-error') }}</p>
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
@endsection
