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
        @if(session('success'))
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
                      <img src="{{ Auth::user()->avatar ?? 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp' }}" class="rounded-circle mb-2" width="100" height="100" alt="Avatar">
                      <h6 class="card-title">{{ Auth::user()->name }}</h6>
                      <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                  </div>

                  <div class="mb-3">
                      <label class="form-label">Họ tên</label>
                      <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="Nhập họ tên">
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
                      <input type="text" name="phone_number" class="form-control" value="{{ Auth::user()->phone_number ?? '' }}" placeholder="Nhập số điện thoại">
                      @error('phone_number')
                          <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  @if(!Auth::user()->google_id)
                      <div class="mb-3">
                          <label class="form-label">Mật khẩu cũ</label>
                          <input type="password" name="old_password" class="form-control" placeholder="Nhập mật khẩu cũ" >
                          @error('old_password')
                              <small class="text-danger">{{ $message }}</small>
                          @enderror
                      </div>

                      <div class="mb-3">
                          <label class="form-label">Mật khẩu mới</label>
                          <input type="password" name="new_password" class="form-control" placeholder="Nhập mật khẩu mới">
                          @error('new_password')
                              <small class="text-danger">{{ $message }}</small>
                          @enderror
                      </div>
                  @endif

                  <div class="mb-3">
                      <label class="form-label">Địa chỉ</label>
                      <input type="text" name="address" class="form-control" value="{{ Auth::user()->address ?? '' }}" placeholder="Nhập địa chỉ">
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
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Lịch sử đơn hàng</h5>
        </div>
        <div class="card-body">
          <div class="accordion" id="orderAccordion">
            @for ($i = 1; $i <= 3; $i++)
              <div class="accordion-item mb-2 border rounded shadow-sm">
                <h2 class="accordion-header" id="heading{{ $i }}">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}">
                    <div>
                      <i class="bi bi-box-seam me-2 text-primary"></i>
                      <strong>#DH202105{{ $i }}XYZ</strong> • <span class="text-muted small ms-2">19/05/202{{ $i }} - 14:32</span>
                    </div>
                    <span class="badge bg-warning text-dark ms-auto">Chờ xác nhận</span>
                  </button>
                </h2>
                <div id="collapse{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                  <div class="accordion-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr><th>Sản phẩm</th><th>Số lượng</th><th>Size</th><th>Màu</th><th>Giá</th></tr>
                      </thead>
                      <tbody>
                        <tr><td>Áo thun nam</td><td>2</td><td>L</td><td>Đen</td><td>200.000đ</td></tr>
                        <tr><td>Quần jean nữ</td><td>1</td><td>M</td><td>Xanh</td><td>350.000đ</td></tr>
                      </tbody>
                    </table>
                    <div class="text-end">
                      <button class="btn btn-danger"><i class="bi bi-x-circle"></i> Hủy đơn hàng</button>
                    </div>
                  </div>
                </div>
              </div>
            @endfor
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
