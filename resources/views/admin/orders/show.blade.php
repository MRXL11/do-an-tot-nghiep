@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Chi tiết đơn hàng <strong class="text-primary">#{{ $order->order_code }}</strong></h3>
@endsection
@section('content')
    <div class="container py-4">
        <div class="card shadow-lg border-0 rounded-4 p-4">
            {{-- quay lại trang danh sách đơn hàng --}}
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách đơn hàng
                    </a>
                </div>
            </div>
            
            {{-- Thông báo lỗi hoặc thành công --}}
            <div class="row">
                @if (session('error'))
                    <div class="alert alert-danger rounded-3">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success rounded-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- Thông tin người gửi, người nhận --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Người gửi</h6>
                    <address class="small text-dark">
                        <strong>HN447</strong><br>
                        Số 1, Trịnh Văn Bô, Hà Nội<br>
                        <strong>Email:</strong> HN_447@company.com<br>
                        <strong>SĐT:</strong> 010-020-0340
                    </address>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Người nhận</h6>
                    <address class="small text-dark">
                        <strong class="text-primary">{{ $order->shippingAddress->name }}</strong><br>
                        {{ $order->shippingAddress->full_address }}<br>
                        <strong>Email:</strong> {{ $order->user->email }}<br>
                        <strong>SĐT:</strong> {{ $order->shippingAddress->phone_number }}
                    </address>
                </div>
            </div>

            {{-- Thông tin đơn hàng --}}
            <div class="row mb-2">
                <div class="col-md-2">
                    <h6 class="text-muted">Đơn hàng</h6>
                    <p class="fw-semibold">#{{ $order->order_code }}</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted">Trạng thái</h6>
                    <span class="badge {{ $order->getStatusLabel()['color'] }}">
                        {{ $order->getStatusLabel()['label'] }}
                    </span>
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted">Phương thức thanh toán</h6>
                    <p class="fw-semibold">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted">Trạng thái thanh toán</h6>
                    @if ($order->payment_status === 'completed')
                        <span class="badge bg-success">Đã thanh toán</span>
                    @elseif ($order->payment_status === 'pending')
                        <span class="badge bg-warning text-dark">Đang chờ</span>
                    @elseif ($order->payment_status === 'failed')
                        <span class="badge bg-danger">Thanh toán thất bại</span>
                    @else
                        <span class="badge bg-secondary">Không xác định</span>
                    @endif
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted">Phiếu giảm giá</h6>
                    @if ($order->coupon)
                        @php
                            $coupon = $order->coupon;
                            $label =
                                $coupon->discount_type === 'percent'
                                    ? 'Giảm ' . $coupon->discount_value . '%'
                                    : 'Giảm ' . number_format($coupon->discount_value, 0, ',', '.') . '.000 VNĐ';
                        @endphp
                        <p class="fw-semibold">{{ $coupon->code }} - {{ $label }}</p>
                    @else
                        <p class="fw-semibold">Không sử dụng</p>
                    @endif
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted">Ngày đặt hàng</h6>
                    <p class="fw-semibold">{{ $order->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="col-md-12 mt-2 mb-2">
                @if (!in_array($order->status, ['delivered', 'cancelled']))
                    {{-- Nút Xác nhận tương ứng với trạng thái --}}
                    @php
                        // Xác định thông điệp huỷ đơn dựa trên trạng thái
                        $cancelMessages = [
                            'pending' => 'Đơn hàng đang chờ xác nhận. Bạn có chắc muốn huỷ không?',
                            'processing' => 'Đơn hàng đang xử lý. Bạn có chắc muốn huỷ không?',
                            'shipped' => 'Đơn đã giao cho đơn vị vận chuyển. Bạn có chắc muốn huỷ không?',
                        ];

                        $cancelMessage = $cancelMessages[$order->status] ?? 'Bạn có chắc muốn huỷ đơn hàng này không?';

                        $statusActions = [
                            'pending' => [
                                'label' => 'Xác nhận đơn',
                                'next_status' => 'processing',
                            ],
                            'processing' => [
                                'label' => 'Bắt đầu giao hàng',
                                'next_status' => 'shipped',
                            ],
                            'shipped' => [
                                'label' => 'Giao hàng thành công',
                                'next_status' => 'delivered',
                            ],
                        ];

                        $action = $statusActions[$order->status] ?? null;
                    @endphp

                    @if ($action)
                        <button class="btn btn-sm btn-success me-1"
                            onclick="submitStatusUpdate('{{ route('admin.orders.update', $order->id) }}',
                                                    '{{ $action['next_status'] }}', '{{ $action['label'] }}')">
                            <i class="bi bi-pencil-square"></i> {{ $action['label'] }}
                        </button>
                    @endif

                    {{-- Nút Hủy đơn --}}
                    <button class="btn btn-sm btn-danger me-1"
                        onclick="showCancelModal('{{ route('admin.orders.cancel', $order->id) }}', '{{ $cancelMessage }}')">
                        <i class="bi bi-x-circle"></i> Huỷ đơn
                    </button>
                @endif
            </div>

            {{-- Bảng chi tiết đơn hàng --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>SKU</th>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Mô tả ngắn</th>
                            <th>Số lượng</th>
                            <th>Đơn giá (VNĐ)</th>
                            <th>Giảm giá (VNĐ)</th>
                            <th>Tổng (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $item)
                            <tr>
                                <td>{{ $item->productVariant->sku }}</td>
                                <td>
                                    @if ($item->productVariant->image)
                                        <img src="{{ asset($item->productVariant->image) }}"
                                            alt="{{ $item->productVariant->name }}" class="rounded shadow-sm"
                                            width="50" height="50" style="object-fit:cover;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->productVariant->product->name }}
                                    <br><small class="text-muted">{{ $item->productVariant->color }} -
                                        {{ $item->productVariant->size }}</small>
                                </td>
                                <td>{{ $item->productVariant->product->short_description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}.000</td>
                                <td>{{ number_format($item->discount, 0, ',', '.') }}.000</td>
                                <td>{{ number_format($item->subtotal, 0, ',', '.') }}.000</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tổng tiền và ghi chú --}}
            <div class="row mt-4">
                <div class="col-md-8">
                    @if ($order->note)
                        <div class="alert alert-secondary small" role="alert">
                            <strong>Ghi chú:</strong><br>
                            {{ $order->note }}<br>
                        </div>
                    @else
                        <div class="alert alert-secondary small" role="alert">
                            <strong>Ghi chú:</strong><br>
                            Không có ghi chú nào cho đơn hàng này.<br>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <ul class="list-group list-group-flush">
                        {{-- xử lý mã mã giảm giá --}}
                        @if ($order->coupon)
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                                Giảm:
                                <span>{{ number_format($discount, 0, ',', '.') }}.000 VNĐ</span>
                            </li>
                        @else
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                                Giảm:
                                <span>0 VNĐ</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-semibold">
                            Thành tiền:
                            <span>{{ number_format($order->total_price, 0, ',', '.') }}.000 VNĐ</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form id="statusUpdateForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH') {{-- hoặc PATCH nếu bạn muốn --}}
        <input type="hidden" name="status" id="statusInput">
    </form>

    <!-- Modal xác nhận huỷ đơn hàng -->
    <div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="cancelForm" method="POST">
                    @csrf
                    @method('POST') {{-- hoặc DELETE tùy route bạn dùng --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận huỷ đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <p id="cancelConfirmMessage">Bạn có chắc muốn huỷ đơn hàng này không?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Xác nhận huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
