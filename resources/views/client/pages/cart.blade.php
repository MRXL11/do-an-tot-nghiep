@extends('client.pages.page-layout')

@section('content')
 <section class="section" >
    <div class="container">
        <div class="row">
          <!-- Giỏ hàng -->
          <div class="col-lg-8 mb-4">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-0"><i class="bi bi-cart-fill me-2"></i>Giỏ hàng của bạn</h5>
        <small class="text-white-50">Bạn đang có 4 sản phẩm trong cửa hàng</small>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle text-center">
          <thead class="table-light">
            <tr>
              <th><input type="checkbox"></th>
              <th>Hình ảnh</th>
              <th>Sản phẩm</th>
              <th>Size</th>
              <th>Màu</th>
              <th>Giá</th>
              <th>Số lượng</th>
              <th>Tổng</th>
              <th>Xóa</th>
            </tr>
          </thead>
          <tbody>
            <!-- Sản phẩm 1 -->
            <tr>
              <td><input type="checkbox"></td>
              <td>
                <img src="assets/images/men-03.jpg" height="50" class="rounded">
              </td>
              <td>Product Name</td>
              <td>M</td>
              <td>Đen</td>
              <td class="text-primary fw-semibold">$99</td>
              <td>
                <div class="input-group input-group-sm">
                  <button class="btn btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                  <input type="text" class="form-control text-center" value="1" style="max-width: 50px;">
                  <button class="btn btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                </div>
              </td>
              <td class="fw-bold">$99</td>
              <td>
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>

            <!-- Sản phẩm 2 -->
            <tr>
              <td><input type="checkbox"></td>
              <td>
                <img src="assets/images/men-01.jpg" height="50" class="rounded">
              </td>
              <td>Product Name</td>
              <td>M</td>
              <td>Đen</td>
              <td class="text-primary fw-semibold">$99</td>
              <td>
                <div class="input-group input-group-sm">
                  <button class="btn btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                  <input type="text" class="form-control text-center" value="1" style="max-width: 50px;">
                  <button class="btn btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                </div>
              </td>
              <td class="fw-bold">$99</td>
              <td>
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>

            <!-- Sản phẩm 3 -->
            <tr>
              <td><input type="checkbox"></td>
              <td>
                <img src="assets/images/men-02.jpg" height="50" class="rounded">
              </td>
              <td>Product Name</td>
              <td>M</td>
              <td>Đen</td>
              <td class="text-primary fw-semibold">$99</td>
              <td>
                <div class="input-group input-group-sm">
                  <button class="btn btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                  <input type="text" class="form-control text-center" value="1" style="max-width: 50px;">
                  <button class="btn btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                </div>
              </td>
              <td class="fw-bold">$99</td>
              <td>
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

      
          <!-- Tóm tắt đơn hàng -->
          <div class="col-lg-4">
            <div class="card shadow-sm">
              <div class="card-header bg-light">
                <h5 class="text-center">Tóm tắt đơn hàng</h5>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label for="coupon" class="form-label">Mã giảm giá</label>
                  <div class="input-group">
                    <input type="text" id="coupon" class="form-control" placeholder="Nhập mã...">
                    <button class="btn btn-outline-primary">Áp dụng</button>
                  </div>
                </div>
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Tạm tính</span> <strong>$99</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Phí vận chuyển</span> <strong>$1</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Tổng cộng</span> <strong>$100</strong>
                  </li>
                </ul>
                <div class="d-grid gap-2">
               
                  <button class="btn btn-primary form-control"><a class="text-white" href="checkout.html">Tiến hành thanh toán</a></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection