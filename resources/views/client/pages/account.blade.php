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
          <form>
            <div class="mb-3 text-center">
              <img src="https://chiemtaimobile.vn/images/companies/1/%E1%BA%A2nh%20Blog/avatar-facebook-dep/Hinh-dai-dien-hai-huoc-cam-dep-duoi-ai-do.jpg?1704789789335" class="rounded-circle mb-2" width="100" height="100" alt="Avatar">
              <h6 class="card-title">Nguyễn Văn A</h6>
              <p class="card-text text-muted">nguyenvana@gmail.com</p>
              <input type="file" class="form-control form-control-sm mt-2" accept="image/*">
            </div>
            <div class="mb-3">
              <label class="form-label">Họ tên</label>
              <input type="text" class="form-control" placeholder="Nhập họ tên">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" placeholder="Nhập email">
            </div>
            <div class="mb-3">
              <label class="form-label">Mật khẩu cũ:</label>
              <input type="password" class="form-control" placeholder="Nhập mật khẩu cũ">
            </div>
            <div class="mb-3">
              <label class="form-label">Mật khẩu mới:</label>
              <input type="password" class="form-control" placeholder="Nhập mật khẩu mới">
            </div>
            <div class="mb-3">
              <label class="form-label">Địa chỉ</label>
              <input type="text" class="form-control" placeholder="Nhập địa chỉ">
            </div>
            <button type="submit" class="btn btn-success w-100">Cập nhật</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Cột phải: Lịch sử đơn hàng dạng accordion -->
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
                <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}" aria-expanded="false" aria-controls="collapse{{ $i }}">
                  <div>
                    <i class="bi bi-box-seam me-2 text-primary"></i>
                    <strong>#DH202105{{ $i }}XYZ</strong> • <span class="text-muted small ms-2">19/05/202{{ $i }} - 14:32</span>
                  </div>
                  <span class="badge bg-warning text-dark ms-auto">Chờ xác nhận</span>
                </button>
              </h2>
              <div id="collapse{{ $i }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $i }}" data-bs-parent="#orderAccordion">
                <div class="accordion-body">
                  <h6><i class="bi bi-box2-heart me-1"></i>Chi tiết sản phẩm</h6>
                  <table class="table table-bordered mb-3">
                    <thead>
                      <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Size</th>
                        <th>Màu</th>
                        <th>Giá</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Áo thun nam</td>
                        <td>2</td>
                        <td>L</td>
                        <td>Đen</td>
                        <td>200.000đ</td>
                      </tr>
                      <tr>
                        <td>Quần jean nữ</td>
                        <td>1</td>
                        <td>M</td>
                        <td>Xanh</td>
                        <td>350.000đ</td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="row">
                    <div class="col-md-6">
                      <p><strong>Voucher:</strong> GIAM10%</p>
                      <p><strong>Thanh toán:</strong> COD</p>
                    </div>
                    <div class="col-md-6 text-end">
                      <p><strong>Tạm tính:</strong> 750.000đ</p>
                      <p><strong>Giảm giá:</strong> -75.000đ</p>
                      <p><strong>Phí ship:</strong> 30.000đ</p>
                      <hr>
                      <h5 class="text-danger"><strong>Tổng thanh toán: 705.000đ</strong></h5>
                    </div>
                  </div>

                  <div class="text-end mt-3">
                    <button class="btn btn-danger"><i class="bi bi-x-circle"></i> Hủy đơn hàng</button>
                  </div>
                  <p class="text-center mt-2 small text-muted">(* Bạn chỉ có thể hủy khi đơn hàng chưa được xác nhận)</p>
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
