@extends('client.pages.page-layout')

@section('content')
    @if (session('warning'))
        <div class="container">
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Bắt đầu form thanh toán --}}
    <form method="POST" action="{{ route('checkout.submit') }}">
        @csrf
        <div class="container">
            <div class="row justify-content-center align-items-start">
                <!-- Danh sách sản phẩm -->
                <div class="col-lg-7 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <a href="{{ route('cart.index') }}" class="text-decoration-none text-primary">
                                    <i class="bi bi-cart-fill me-2"></i>Quay lại giỏ hàng
                                </a>
                            </h5>
                            <hr>
                            <p class="text-muted mb-3">
                                Bạn đã chọn <strong class="text-danger">{{ count($cartItems) }} sản phẩm</strong>
                            </p>

                            <!-- Hiển thị từng sản phẩm đã chọn -->
                            @foreach ($cartItems as $item)
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->productVariant->image ?? 'images/default-product.jpg') }}"
                                                alt="Product" class="img-thumbnail" style="width: 60px;">
                                            <div class="ms-3">
                                                <h6 class="mb-1">{{ $item->productVariant->product->name }}</h6>
                                                <small class="text-muted">
                                                    Size: {{ $item->productVariant->size }},
                                                    Màu: {{ $item->productVariant->color }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-4">
                                            <span class="fw-semibold">x{{ $item->quantity }}</span>
                                            <span class="text-primary fw-bold">
                                                {{ number_format($item->productVariant->price * $item->quantity, 0, ',', '.') }}
                                                ₫
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Chi tiết thanh toán -->
                <div class="col-lg-5">
                    <div class="card bg-light border-0 shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="bi bi-credit-card-fill me-2 text-primary"></i>Chi tiết thanh
                                    toán
                                </h5>
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" class="rounded-circle"
                                    width="40" alt="avatar">
                            </div>

                            <!-- Phương thức thanh toán -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Chọn phương thức thanh toán:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" value="cod"
                                            id="cod" checked>
                                        <label class="form-check-label" for="cod"><i
                                                class="bi bi-cash-stack me-1"></i>COD</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" value="momo"
                                            id="momo">
                                        <label class="form-check-label" for="momo"><i
                                                class="bi bi-phone me-1"></i>Momo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" value="card"
                                            id="card">
                                        <label class="form-check-label" for="card"><i
                                                class="bi bi-credit-card me-1"></i>Thẻ</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Nội dung từng phương thức thanh toán -->
                            <div id="cod-details" class="payment-method-details">
                                <div class="alert alert-success py-2 mb-3">
                                    <i class="bi bi-truck me-2"></i> Thanh toán khi nhận hàng (COD)
                                </div>
                            </div>

                            <div id="card-details" class="payment-method-details" style="display: none;">
                                <div class="alert alert-info py-2 mb-3">
                                    <i class="bi bi-credit-card-2-front me-2"></i> Thanh toán bằng thẻ tín dụng/ghi nợ
                                </div>
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
                            </div>

                            <!-- Mã giảm giá -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Mã giảm giá</label>
                                <div class="input-group">
                                    <input type="text" id="coupon-code" name="coupon_code" class="form-control"
                                        placeholder="Nhập mã">
                                    <button type="button" class="btn btn-outline-primary" id="apply-coupon">Áp
                                        dụng</button>
                                </div>
                                <small id="coupon-feedback" class="text-danger d-block mt-1"
                                    style="display: none;"></small>
                            </div>

                            <!-- Chọn địa chỉ có sẵn -->
                            <!-- Dropdown chọn địa chỉ -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Chọn địa chỉ giao hàng:</label>
                                <select class="form-select" id="address-select">
                                    <option value="">-- Chọn địa chỉ --</option>
                                    @foreach ($user->shippingAddresses ?? [] as $address)
                                        <option value="{{ $address->id }}" data-name="{{ $address->user->name }}"
                                            data-phone="{{ $address->phone_number }}"
                                            data-address="{{ $address->full_address }}">
                                            {{ $address->full_address }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hiển thị chi tiết bên dưới -->
                            <div id="address-details" class="border p-3 rounded bg-light d-none">
                                <p class="mb-1"><strong>Người nhận:</strong> <span id="detail-name"></span></p>
                                <p class="mb-1"><strong>Số điện thoại:</strong> <span id="detail-phone"></span></p>
                                <p class="mb-0"><strong>Địa chỉ:</strong> <span id="detail-address"></span></p>
                            </div>

                            <!-- THÔNG TIN GIAO HÀNG -->
                            <div class="mb-4 mt-4">
                                <label class="form-label fw-semibold">Thông tin giao hàng</label>

                                <div class="mb-2">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Họ và tên người nhận">
                                </div>

                                <div class="mb-2">
                                    <input type="text" name="phone_number" class="form-control"
                                        placeholder="Số điện thoại">
                                </div>

                                <div class="mb-2">
                                    <input type="text" name="address" class="form-control"
                                        placeholder="Địa chỉ cụ thể (Số nhà, tên đường...)">
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="ward" class="form-control" placeholder="Xã">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="district" class="form-control" placeholder="Quận">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="city" class="form-control"
                                            placeholder="Thành phố">
                                    </div>
                                </div>
                            </div>

                            <!-- Tổng tiền -->
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Tạm tính:</span>
                                <strong>{{ number_format($subtotal, 0, ',', '.') }} ₫
                                </strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Phí vận chuyển:</span>
                                <strong>20.000 ₫</strong>
                            </div>
                            {{-- Hiển thị thông tin giảm giá --}}
                            {{-- Cần sửa lại để thay đổi khi mã giảm giá được nhập --}}
                            <div class="d-flex justify-content-between">
                                <span>Giảm giá:</span>
                                <strong>-0 ₫</strong>
                            </div>
                            <div class="d-flex justify-content-between fs-5 mt-2">
                                <span>Tổng cộng:</span>
                                <strong class="text-danger">
                                    {{ number_format($subtotal + 20000, 0, ',', '.') }} ₫
                                </strong>
                            </div>

                            <!-- Điều khoản -->
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="agree">
                                <label class="form-check-label" for="agree">
                                    Tôi đồng ý với <a href="#" class="text-decoration-underline">chính sách mua
                                        hàng</a>
                                </label>
                            </div>

                            <!-- Nút thanh toán -->
                            <button type="submit" class="btn btn-success w-100 mt-3" id="submit-btn">
                                <i class="bi bi-cart-check me-2"></i>Thanh toán
                                ({{ number_format($subtotal + 20000, 0, ',', '.') }} ₫)
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form> {{-- Kết thúc form --}}
@endsection

@section('scripts')
    <script>
        // Khởi tạo khi trang được tải
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy các input radio và nút thanh toán
            const radios = document.querySelectorAll('input[name="paymentMethod"]');
            const submitBtn = document.getElementById('submit-btn');
            const details = {
                cod: document.getElementById("cod-details"),
                momo: document.getElementById("momo-details"),
                card: document.getElementById("card-details")
            };
            const total = "{{ number_format($subtotal + 20000, 0, ',', '.') }} ₫"; // Tổng tiền

            // Hàm cập nhật giao diện nút thanh toán
            function updatePaymentButton() {
                const selected = document.querySelector('input[name="paymentMethod"]:checked').value;

                // Cập nhật văn bản và kiểu dáng nút theo phương thức thanh toán
                if (selected === 'cod') {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Đặt hàng`;
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.remove('btn-warning');
                    submitBtn.classList.add('btn-success');
                } else if (selected === 'card') {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Thanh toán bằng thẻ (${total})`;
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.remove('btn-warning');
                    submitBtn.classList.add('btn-primary');
                } else {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Thanh toán (${total})`;
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-warning');
                }

                // Hiển thị chi tiết phương thức thanh toán
                Object.keys(details).forEach(key => {
                    if (details[key]) {
                        details[key].style.display = (key === selected) ? "block" : "none";
                    }
                });
            }

            // Gắn sự kiện thay đổi cho radio buttons
            radios.forEach(radio => radio.addEventListener("change", updatePaymentButton));

            // Gọi hàm để hiển thị trạng thái ban đầu
            updatePaymentButton();
        });

        // Hiển thị thông tin địa chỉ khi chọn
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('address-select');
            const detailBox = document.getElementById('address-details');
            const nameSpan = document.getElementById('detail-name');
            const phoneSpan = document.getElementById('detail-phone');
            const addressSpan = document.getElementById('detail-address');

            // Cập nhật thông tin địa chỉ khi chọn từ dropdown
            select.addEventListener('change', function() {
                const selected = select.options[select.selectedIndex];

                if (selected.value) {
                    nameSpan.textContent = selected.dataset.name || '';
                    phoneSpan.textContent = selected.dataset.phone || '';
                    addressSpan.textContent = selected.dataset.address || '';
                    detailBox.classList.remove('d-none');
                } else {
                    detailBox.classList.add('d-none');
                }
            });
        });

        // Kiểm tra đồng ý với chính sách trước khi submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!document.getElementById('agree').checked) {
                e.preventDefault();
                alert('Bạn cần đồng ý với chính sách mua hàng để tiếp tục.');
            }
        });
    </script>
@endsection
