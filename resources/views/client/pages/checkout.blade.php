@extends('client.pages.page-layout')
@section('content')
<div class="container">
    <div class="row justify-content-center align-items-start">
        <!-- Danh sách sản phẩm -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="mb-3">
                        <a href="" class="text-decoration-none text-primary">
                            <i class="bi bi-cart-fill me-2"></i>Quay lại giỏ hàng
                        </a>
                    </h5>
                    <hr>
                    <p class="text-muted mb-3">Bạn đã chọn <strong class="text-danger">4 sản phẩm</strong></p>

                    <!-- Sản phẩm -->
                    @for ($i = 0; $i < 2; $i++)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp"
                                     alt="Product" class="img-thumbnail" style="width: 60px;">
                                <div class="ms-3">
                                    <h6 class="mb-1">Quần âu</h6>
                                    <small class="text-muted">Size: M, Navy Blue</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                <span class="fw-semibold">x2</span>
                                <span class="text-primary fw-bold">$900</span>
                                <a href="#" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Chi tiết thanh toán -->
        <div class="col-lg-5">
            <div class="card bg-light border-0 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-credit-card-fill me-2 text-primary"></i>Chi tiết thanh toán</h5>
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" class="rounded-circle" width="40" alt="avatar">
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Chọn phương thức thanh toán:</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" value="cod" id="cod" checked>
                                <label class="form-check-label" for="cod"><i class="bi bi-cash-stack me-1"></i>COD</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" value="momo" id="momo">
                                <label class="form-check-label" for="momo"><i class="bi bi-phone me-1"></i>Momo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" value="card" id="card">
                                <label class="form-check-label" for="card"><i class="bi bi-credit-card me-1"></i>Thẻ</label>
                            </div>
                        </div>
                    </div>

                    <!-- Chi tiết COD -->
                    <div id="cod-details" class="payment-method-details">
                        <div class="alert alert-success py-2 mb-3">
                            <i class="bi bi-truck me-2"></i> Thanh toán khi nhận hàng (COD)
                        </div>
                    </div>

                    <!-- Chi tiết Momo -->
                    <div id="momo-details" class="payment-method-details" style="display: none;">
                        <div class="alert alert-warning py-2 mb-3">
                            <i class="bi bi-qr-code me-2"></i> Quét mã QR để thanh toán qua Momo
                        </div>
                        <div class="text-center mb-2">
                            <img src="https://tse2.mm.bing.net/th?id=OIP.yNhEU48kUAE37NleMUMZMwHaHS&pid=Api&P=0&h=180"
                                 alt="Momo QR" class="img-fluid rounded shadow" style="max-height: 180px;">
                        </div>
                        <p class="text-center small">(Vui lòng kiểm tra kỹ thông tin trước khi xác nhận thanh toán)</p>
                    </div>

                    <!-- Chi tiết thẻ -->
                    <div id="card-details" class="payment-method-details" style="display: none;">
                        <div class="alert alert-info py-2 mb-3">
                            <i class="bi bi-credit-card-2-front me-2"></i> Thanh toán bằng thẻ tín dụng/ghi nợ
                        </div>
                        <form>
                            <div class="mb-2">
                                <label class="form-label">Tên chủ thẻ</label>
                                <input type="text" class="form-control" placeholder="Nguyễn Văn A">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Số thẻ</label>
                                <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Ngày hết hạn</label>
                                    <input type="text" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Mã CVV</label>
                                    <input type="password" class="form-control" placeholder="***">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Thông tin người nhận -->
                    <div class="mb-3 mt-4">
                        <label class="form-label fw-semibold">Thông tin giao hàng</label>
                        <input type="text" class="form-control mb-2" placeholder="Nhập địa chỉ nhận hàng">
                        <input type="text" class="form-control" placeholder="Nhập số điện thoại">
                    </div>

                    <!-- Tổng tiền -->
                    <hr>
                    <div class="d-flex justify-content-between"><span>Tạm tính:</span><strong>$4798.00</strong></div>
                    <div class="d-flex justify-content-between"><span>Phí vận chuyển:</span><strong>$20.00</strong></div>
                    <div class="d-flex justify-content-between fs-5 mt-2">
                        <span>Tổng cộng:</span><strong class="text-danger">$4818.00</strong>
                    </div>

                    <!-- Đồng ý điều khoản -->
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="agree">
                        <label class="form-check-label" for="agree">
                            Tôi đồng ý với <a href="#" class="text-decoration-underline">chính sách mua hàng</a>
                        </label>
                    </div>

                    <!-- Nút thanh toán -->
                    <button class="btn btn-success w-100 mt-3">
                        <i class="bi bi-cart-check me-2"></i>Thanh toán ($4818.00)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


     
@endsection

<!-- SCRIPT -->
@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const radios = document.querySelectorAll('input[name="paymentMethod"]');
    const details = {
        cod: document.getElementById("cod-details"),
        momo: document.getElementById("momo-details"),
        card: document.getElementById("card-details")
    };

    function showSelectedPayment() {
        const selected = document.querySelector('input[name="paymentMethod"]:checked').value;
        Object.keys(details).forEach(key => {
            details[key].style.display = (key === selected) ? "block" : "none";
        });
    }

    radios.forEach(radio => radio.addEventListener("change", showSelectedPayment));

    // Mặc định hiển thị
    showSelectedPayment();
});
</script>
@endsection