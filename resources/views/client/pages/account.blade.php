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
                                            <span class="badge bg-warning text-dark ms-auto">{{ $order->status }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $order->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#orderAccordion">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sản phẩm</th>
                                                        <th>Màu</th>
                                                        <th>Size</th>
                                                        <th>Số lượng</th>
                                                        <th>Đơn giá</th>
                                                        <th>Giảm giá</th>
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
                                                            <td>{{ number_format($detail->discount, 0, ',', '.') }}₫</td>
                                                            <td>{{ number_format($detail->subtotal, 0, ',', '.') }}
                                                                ₫</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="text-end">
                                                <form
                                                    action="{{ route('order.cancel.request', [$order->id, ($message = 'Tôi muốn huỷ đơn hàng')]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')"><i
                                                            class="bi bi-x-circle"></i> Hủy đơn hàng</button>
                                                </form>
                                            </div>
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
@endsection
