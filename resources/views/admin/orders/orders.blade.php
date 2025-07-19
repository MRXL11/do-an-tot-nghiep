@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Danh sách đơn hàng</h3>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row g-4 mb-4">
                <div class="col-md-12">
                    {{-- tìm kiếm đơn hàng --}}
                    <form class="d-flex mb-1" role="search" action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light" id="search-icon">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text" class="form-control" placeholder="Tìm kiếm đơn hàng" aria-label="Tìm kiếm"
                                aria-describedby="search-icon" name="q" value="{{ request('q') }}">

                            <select class="form-select ms-1" name="status" style="max-width: 200px;">
                                <option value="">--Tất cả Trạng thái--</option>
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            <button class="btn btn-primary ms-2" type="submit">Tìm</button>
                            <a class="btn btn-secondary ms-2" href="{{ route('admin.orders.index') }}">Đặt lại</a>
                        </div>
                    </form>
                    {{-- kết thúc tìm kiếm --}}

                    {{-- hiển thị thông báo --}}
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

                    {{-- hiển thị danh sách đơn hàng --}}
                    @if ($noResults)
                        <div class="alert alert-warning" role="alert">
                            Không tìm thấy đơn hàng nào.
                        </div>
                    @endif
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Ngày đặt hàng</th>
                                <th scope="col">Tên người nhận</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Phương thức thanh toán</th>
                                <th scope="col">Trạng thái thanh toán</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Trả hàng / Hoàn tiền</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $order->shippingAddress->name }}</td>
                                    <td style="overflow-wrap: break-word; max-width: 250px;">
                                        {{ $order->shippingAddress->full_address }}
                                    </td>
                                    <td>{{ $order->shippingAddress->phone_number }}</td>
                                    <td style="color: {{ $order->getPaymentMethod($order->payment_method)['color'] }} ">
                                        {{ $order->getPaymentMethod($order->payment_method)['label'] }}</td>
                                    <td style="color: {{ $order->getPaymentStatus($order->payment_status)['color'] }} ">
                                        {{ $order->getPaymentStatus($order->payment_status)['label'] }}</td>
                                    <td>
                                        @php
                                            $status = $order->getStatusLabel();
                                        @endphp
                                        {{-- hiển thị trạng thái đơn hàng --}}
                                        <span class="badge {{ $status['color'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($order->returnRequest)
                                            @php
                                                $returnStatus = $order->returnRequest->return_status;
                                                $canUpdateReturn = in_array($order->returnRequest->status, [
                                                    'requested',
                                                    'approved',
                                                ]);
                                            @endphp

                                            <div class="d-flex flex-column gap-1">
                                                {{-- Badge trạng thái --}}
                                                <span class="badge bg-{{ $returnStatus['color'] }}">
                                                    <i class="bi {{ $returnStatus['icon'] }}"></i>
                                                    {{ $returnStatus['title'] }}
                                                </span>

                                                {{-- Form xử lý trạng thái tiếp theo --}}
                                                @if ($canUpdateReturn)
                                                    <form method="POST"
                                                        action="{{ route('admin.return-requests.update', $order->returnRequest->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="input-group input-group-sm mt-1">
                                                            <select class="form-select form-select-sm" name="status"
                                                                required>
                                                                <option value="">-- Cập nhật trạng thái --</option>

                                                                @if ($order->returnRequest->status === 'requested')
                                                                    <option value="approved">✅ Chấp nhận trả hàng</option>
                                                                    <option value="rejected">❌ Từ chối yêu cầu</option>
                                                                @elseif($order->returnRequest->status === 'approved')
                                                                    <option value="refunded">💸 Đánh dấu hoàn tiền</option>
                                                                @endif
                                                            </select>
                                                            <button class="btn btn-outline-primary" type="submit">
                                                                <i class="bi bi-send"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Nút Chi tiết đơn hàng --}}
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('admin.orders.show', $order->id) }}">
                                                <i class="bi bi-info-circle"></i> Chi tiết
                                            </a>

                                            @if (!in_array($order->status, ['delivered', 'completed', 'cancelled']))
                                                {{-- Nút xác nhận trạng thái tiếp theo --}}
                                                @php
                                                    $cancelMessages = [
                                                        'pending' =>
                                                            'Đơn hàng đang chờ xác nhận. Bạn có chắc muốn huỷ không?',
                                                        'processing' =>
                                                            'Đơn hàng đang xử lý. Bạn có chắc muốn huỷ không?',
                                                        'shipped' =>
                                                            'Đơn đã giao cho đơn vị vận chuyển. Bạn có chắc muốn huỷ không?',
                                                    ];

                                                    $cancelMessage =
                                                        $cancelMessages[$order->status] ??
                                                        'Bạn có chắc muốn huỷ đơn hàng này không?';

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
                                                            'label' => 'Đã giao hàng',
                                                            'next_status' => 'delivered',
                                                        ],
                                                    ];

                                                    $action = $statusActions[$order->status] ?? null;
                                                @endphp

                                                @if ($action)
                                                    <button class="btn btn-sm btn-success"
                                                        onclick="
                                                        submitStatusUpdate('{{ route('admin.orders.update', $order->id) }}',
                                                            '{{ $action['next_status'] }}', '{{ $action['label'] }}')">
                                                        <i class="bi bi-pencil-square"></i> {{ $action['label'] }}
                                                    </button>
                                                @endif

                                                {{-- Nút Hủy đơn --}}
                                                <button type="button" class="btn btn-danger btn-sm open-cancel-modal"
                                                    data-order-id="{{ $order->id }}">
                                                    <i class="bi bi-x-circle"></i> Huỷ đơn
                                                </button>

                                                {{-- Nút từ chối yêu cầu huỷ đơn --}}
                                                @if ($order->cancellation_requested && !$order->cancel_confirmed)
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectCancelRequestModal{{ $order->id }}">
                                                        <i class="bi bi-x-circle"></i> Từ chối yêu cầu huỷ
                                                    </button>
                                                @endif
                                            @endif

                                            {{-- Nút Đánh dấu đã hoàn tiền --}}
                                            @if ($order->status === 'cancelled' && $order->payment_status === 'refund_in_processing')
                                                <form method="POST"
                                                    action="{{ route('admin.orders.refunded', $order->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        onclick="return confirm('Bạn có chắc chắn đánh dấu đơn hàng này là đã hoàn tiền?');">
                                                        <i class="bi bi-cash-coin"></i> Đã hoàn tiền
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <!-- Modal xác nhận huỷ đơn hàng -->
                                        <div class="modal fade" id="cancelOrderModal{{ $order->id }}" tabindex="-1"
                                            aria-labelledby="cancelOrderModalLabel{{ $order->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" class="cancel-order-form"
                                                    action="{{ route('admin.orders.cancel', $order->id) }}">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="cancelOrderModalLabel{{ $order->id }}">
                                                                Xác nhận huỷ đơn hàng #{{ $order->order_code }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            {{-- ✅ Hiển thị lý do khách hàng yêu cầu huỷ --}}
                                                            @if ($order->cancel_reason)
                                                                <div class="mb-3">
                                                                    <p class="mb-1"><strong>Lý do khách hàng yêu cầu huỷ
                                                                            đơn:</strong></p>
                                                                    <div class="border rounded p-2 bg-light text-dark">
                                                                        {{ $order->cancel_reason }}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- ✅ Ghi chú từ admin --}}
                                                            <div class="mb-3">
                                                                <label for="admin_cancel_note_{{ $order->id }}"
                                                                    class="form-label">Lý do huỷ đơn (Admin):</label>
                                                                <textarea name="admin_cancel_note" id="admin_cancel_note_{{ $order->id }}" class="form-control" rows="3"></textarea>
                                                                <div class="invalid-feedback">
                                                                    Vui lòng nhập lý do huỷ đơn (tối thiểu 10 ký tự).
                                                                </div>
                                                            </div>

                                                            <div class="alert alert-warning">
                                                                Bạn chắc chắn muốn huỷ đơn hàng này? Hành động này không thể
                                                                hoàn tác.
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-danger">Xác nhận huỷ
                                                                đơn</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Modal từ chối yêu cầu huỷ đơn hàng -->
                                        <div class="modal fade" id="rejectCancelRequestModal{{ $order->id }}"
                                            tabindex="-1"
                                            aria-labelledby="rejectCancelRequestModalLabel{{ $order->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" class="reject-cancel-request-form"
                                                    action="{{ route('admin.orders.cancel.reject', $order->id) }}">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-warning text-dark">
                                                            <h5 class="modal-title"
                                                                id="rejectCancelRequestModalLabel{{ $order->id }}">
                                                                Từ chối yêu cầu huỷ đơn hàng #{{ $order->order_code }}
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            {{-- ✅ Hiển thị lý do khách hàng yêu cầu huỷ --}}
                                                            @if ($order->cancel_reason)
                                                                <div class="mb-3">
                                                                    <p class="mb-1"><strong>Lý do khách yêu cầu huỷ
                                                                            đơn:</strong></p>
                                                                    <div class="border rounded p-2 bg-light text-dark">
                                                                        {{ $order->cancel_reason }}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- ✅ Ghi chú lý do từ chối của admin --}}
                                                            <div class="mb-3">
                                                                <label for="admin_cancel_note_reject_{{ $order->id }}"
                                                                    class="form-label">
                                                                    Lý do từ chối (Admin):
                                                                </label>
                                                                <textarea name="admin_cancel_note" id="admin_cancel_note_reject_{{ $order->id }}" class="form-control"
                                                                    rows="3" required></textarea>
                                                                <div class="invalid-feedback">
                                                                    Vui lòng nhập lý do từ chối (tối thiểu 10 ký tự).
                                                                </div>
                                                            </div>

                                                            <div class="alert alert-warning">
                                                                Bạn chắc chắn muốn <strong>từ chối yêu cầu huỷ</strong> này?
                                                                Khách hàng sẽ nhận được thông báo phản hồi từ hệ thống.
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-warning">Xác nhận từ
                                                                chối</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Phân trang -->
                    {{ $orders->links() }}
                    {{-- kết thúc phân trang --}}
                </div>

            </div>
        </div>
    </div>

    {{-- form lấy status mới --}}
    <form id="statusUpdateForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH') {{-- hoặc PATCH nếu bạn muốn --}}
        <input type="hidden" name="status" id="statusInput">
    </form>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // submit status update form
        function submitStatusUpdate(url, nextStatus, actionLabel) {
            if (confirm(`Bạn có chắc muốn thực hiện hành động: "${actionLabel}" không?`)) {
                const form = document.getElementById('statusUpdateForm');
                form.action = url;
                document.getElementById('statusInput').value = nextStatus;
                form.submit();
            }
        }

        // show cancel confirmation modal
        function showCancelModal(url, message) {
            document.getElementById('cancelForm').action = url;
            document.getElementById('cancelConfirmMessage').innerText = message;
            new bootstrap.Modal(document.getElementById('cancelConfirmModal')).show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gán click mở modal
            document.querySelectorAll('.open-cancel-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.dataset.orderId;
                    const modalId = `cancelOrderModal${orderId}`;
                    const modalElement = document.getElementById(modalId);

                    if (modalElement) {
                        const bsModal = bootstrap.Modal.getOrCreateInstance(modalElement);
                        bsModal.show();
                    } else {
                        console.error('Không tìm thấy modal với ID:', modalId);
                    }
                });
            });

            document.querySelectorAll('.reject-cancel-request-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const textarea = form.querySelector('textarea[name="admin_cancel_note"]');
                    if (!textarea.value.trim() || textarea.value.trim().length < 10) {
                        textarea.classList.add('is-invalid');
                        e.preventDefault();
                    } else {
                        textarea.classList.remove('is-invalid');
                    }
                });
            });

            // ✅ Chỉ gán validate cho mỗi form một lần duy nhất sau khi DOM tải xong
            document.querySelectorAll('.cancel-order-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const textarea = this.querySelector('textarea[name="admin_cancel_note"]');
                    const reason = textarea.value.trim();

                    if (reason.length < 10) {
                        e.preventDefault(); // chặn gửi form
                        textarea.classList.add('is-invalid');
                        textarea.focus();
                    } else {
                        textarea.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
@endsection
