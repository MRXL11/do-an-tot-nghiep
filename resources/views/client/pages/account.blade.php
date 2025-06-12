@extends('client.pages.page-layout') 

@section('content') 

<div class="container">
  <div class="row">
    <!-- Cột trái: Thông tin người dùng -->
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
          <h5 class="mb-0">Thông tin người dùng</h5>
        </div>
        <div class="card-body">
          {{-- FORM CẬP NHẬT THÔNG TIN NGƯỜI DÙNG --}}
          <form method="POST" action="{{ route('account.update') }}">
            @csrf 

            <div class="mb-3 text-center">
              {{-- Ảnh đại diện cố định + hiển thị tên và email người dùng --}}
              <img src="https://chiemtaimobile.vn/images/companies/1/%E1%BA%A2nh%20Blog/avatar-facebook-dep/Hinh-dai-dien-hai-huoc-cam-dep-duoi-ai-do.jpg?1704789789335" class="rounded-circle mb-2" width="100" height="100" alt="Avatar">
              <h6 class="card-title">{{ Auth::user()->name }}</h6> {{-- Hiển thị tên người dùng --}}
              <p class="card-text text-muted">{{ Auth::user()->email }}</p> {{-- Hiển thị email người dùng --}}
              <input type="file" class="form-control form-control-sm mt-2" accept="image/*"> {{-- Input chọn ảnh đại diện mới --}}
            </div>

            {{-- Input nhập họ tên --}}
            <div class="mb-3">
              <label class="form-label">Họ tên</label>
              <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="Nhập họ tên">
            </div>

            {{-- Email chỉ hiển thị, không cho chỉnh sửa --}}
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
              <small class="text-success d-block mt-1">Đã xác minh ✅</small>
            </div>

            {{-- Nhập mật khẩu cũ --}}
            <div class="mb-3">
              <label class="form-label">Mật khẩu cũ</label>
              <input type="password" name="old_password" class="form-control" placeholder="Nhập mật khẩu cũ">
            </div>

            {{-- Nhập mật khẩu mới --}}
            <div class="mb-3">
              <label class="form-label">Mật khẩu mới</label>
              <input type="password" name="new_password" class="form-control" placeholder="Nhập mật khẩu mới">
            </div>

            {{-- Nhập địa chỉ --}}
            <div class="mb-3">
              <label class="form-label">Địa chỉ</label>
              <input type="text" name="address" class="form-control" value="{{ Auth::user()->address ?? '' }}" placeholder="Nhập địa chỉ">
            </div>

            <button type="submit" class="btn btn-success w-100">Cập nhật</button>

            {{-- Hiển thị thông báo cập nhật thành công --}}
            @if(session('success'))
              <div class="alert alert-success mt-2">
                {{ session('success') }}
              </div>
            @endif
          </form>
        </div>
      </div>
    </div>

    <!-- Cột phải: Lịch sử đơn hàng -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Lịch sử đơn hàng</h5>
        </div>
        <div class="card-body">
          <div class="accordion" id="orderAccordion">
            @foreach($orders as $order)
              <div class="accordion-item mb-2 border rounded shadow-sm">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}">
                    <div>
                      {{-- Mã đơn + ngày tạo --}}
                      <i class="bi bi-box-seam me-2 text-primary"></i>
                      <strong>#{{ $order->id }}</strong> • 
                      <span class="text-muted small ms-2">{{ $order->created_at->format('d/m/Y - H:i') }}</span>
                    </div>
                    
                    {{-- Hiển thị trạng thái đơn hàng --}}
                    <span class="badge ms-auto 
                      @switch($order->status)
                        @case('cancelled') bg-danger @break {{-- Đơn đã hủy --}}
                        @case('shipped') bg-info @break {{-- Đang giao --}}
                        @case('pending') bg-warning text-dark @break {{-- Đang chờ xử lý --}}
                        @case('processing') bg-primary @break {{-- Đang xử lý --}}
                        @case('delivered') bg-success @break {{-- Đã hoàn thành --}}
                        @default bg-secondary {{-- Không xác định --}}
                      @endswitch">
                      @switch($order->status)
                        @case('cancelled') Đơn đã hủy @break
                        @case('shipped') Đang giao hàng @break
                        @case('pending') Đang chờ xử lý @break
                        @case('processing') Đang xử lý @break
                        @case('delivered') Đã hoàn thành @break
                        @default Không xác định @break
                      @endswitch
                    </span>
                  </button>
                </h2>

                {{-- Nội dung chi tiết của đơn hàng --}}
                <div id="collapse{{ $order->id }}" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    {{-- Bảng hiển thị chi tiết sản phẩm trong đơn --}}
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Sản phẩm</th>
                          <th>Số lượng</th>
                          <th>Size</th>
                          <th>Màu</th>
                          <th>Giá</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($order->orderDetails as $detail)
                          <tr>
                            <td>{{ $detail->productVariant->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ $detail->productVariant->size }}</td>
                            <td>{{ $detail->productVariant->color }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>

                    {{-- Nút "Hủy đơn" chỉ hiển thị khi trạng thái là 'pending' }}
                    <div class="text-end mt-2">
                      @if($order->status === 'pending')
                        <form method="POST" action=""> 
                          @csrf
                          @method('PATCH')
                          <button class="btn btn-danger">Hủy đơn hàng</button>
                        </form>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
