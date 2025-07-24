@extends('client.pages.page-layout')

@section('content')
    <form method="POST" action="{{ route('checkout.submit') }}" id="checkout-form">
        @csrf
        <input type="hidden" name="cart_item_ids" value="{{ implode(',', $cartItems->pluck('id')->toArray()) }}">
        <input type="hidden" name="shipping_address_id" id="shipping-address-id">
        <div class="container">
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
                                    <h5 class="mb-0"><i class="bi bi-credit-card-fill me-2 text-primary"></i>Chi tiết
                                        thanh toán
                                    </h5>
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp"
                                        class="rounded-circle" width="40" alt="avatar">
                                </div>

                                <!-- Phương thức thanh toán -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Chọn phương thức thanh toán:</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                value="cod" id="cod" checked>
                                            <label class="form-check-label" for="cod"><i
                                                    class="bi bi-cash-stack me-1"></i>COD</label>
                                        </div>
                                        {{-- <div class="form-check">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                value="momo" id="momo">
                                            <label class="form-check-label" for="momo"><i
                                                    class="bi bi-phone me-1"></i>Momo</label>
                                        </div> --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                value="card" id="card">
                                            <label class="form-check-label" for="card">
                                                <i class="bi bi-credit-card-2-front me-1"></i>VNpay</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nội dung từng phương thức thanh toán -->
                                <div id="cod-details" class="payment-method-details">
                                    <div class="alert alert-success py-2 mb-3">
                                        <i class="bi bi-truck me-2"></i> Thanh toán khi nhận hàng (COD)
                                    </div>
                                </div>
                                <div id="card-details" class="payment-method-details" style="DISPLAY: none;">
                                    <div class="alert alert-info py-2 mb-3">
                                        <i class="bi bi-credit-card-2-front me-2"></i> Thanh toán bằng VNpay
                                    </div>
                                    <p>Quý khách sẽ được chuyển hướng đến trang thanh toán của VNPay để hoàn tất giao dịch.
                                    </p>
                                    <p>Vui lòng chuẩn bị thẻ ngân hàng hoặc ví điện tử để thanh toán.</p>
                                </div>

                                <!-- Mã giảm giá -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Mã giảm giá</label>
                                    <div class="input-group">
                                        <input type="text" id="coupon-code" name="coupon_code"
                                            class="form-control @error('coupon_code') is-invalid @enderror"
                                            placeholder="Nhập mã" value="{{ old('coupon_code', $coupon ?? '') }}">
                                        <button type="button" class="btn btn-outline-primary" id="apply-coupon">Áp
                                            dụng</button>
                                        @error('coupon_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small id="coupon-feedback" class="form-text mt-1" style="display: none;"></small>
                                </div>

                                <!-- Chọn địa chỉ có sẵn -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Chọn địa chỉ giao hàng:</label>
                                    <select class="form-select" id="address-select">
                                        <option value="">-- Chọn địa chỉ --</option>
                                        @foreach ($user->shippingAddresses ?? [] as $address)
                                            <option value="{{ $address->id }}" data-name="{{ $address->name }}"
                                                data-phone="{{ $address->phone_number }}"
                                                data-address="{{ $address->address }}" data-ward="{{ $address->ward }}"
                                                data-district="{{ $address->district }}"
                                                data-city="{{ $address->city }}"
                                                data-full-address="{{ $address->full_address }}">
                                                {{ $address->full_address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Hiển thị chi tiết địa chỉ đã chọn -->
                                <div id="address-details" class="border p-3 rounded bg-light d-none">
                                    <p class="mb-1"><strong>Người nhận:</strong> <span id="detail-name"></span></p>
                                    <p class="mb-1"><strong>Số điện thoại:</strong> <span id="detail-phone"></span></p>
                                    <p class="mb-0"><strong>Địa chỉ:</strong> <span id="detail-address"></span></p>
                                </div>

                                <!-- Thông tin giao hàng (nhập thủ công) -->
                                <div class="mb-4 mt-4" id="manual-address-input">
                                    <label class="form-label fw-semibold">Thông tin giao hàng</label>
                                    <div class="mb-2">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Họ và tên người nhận" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="phone_number"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            placeholder="Số điện thoại" value="{{ old('phone_number') }}">
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            placeholder="Địa chỉ cụ thể (Số nhà, tên đường...)"
                                            value="{{ old('address') }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <input type="text" name="ward"
                                                class="form-control @error('ward') is-invalid @enderror" placeholder="Xã"
                                                value="{{ old('ward') }}">
                                            @error('ward')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <input type="text" name="district"
                                                class="form-control @error('district') is-invalid @enderror"
                                                placeholder="Quận" value="{{ old('district') }}">
                                            @error('district')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <input type="text" name="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                placeholder="Thành phố" value="{{ old('city') }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Tổng tiền -->
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span>Tạm tính:</span>
                                    <strong>{{ number_format($subtotal, 0, ',', '.') }} ₫</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Phí vận chuyển:</span>
                                    <strong>20.000 ₫</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Giảm giá:</span>
                                    <strong id="discount-amount">-{{ number_format($discount, 0, ',', '.') }} ₫</strong>
                                </div>
                                <div class="d-flex justify-content-between fs-5 mt-2">
                                    <span>Tổng cộng:</span>
                                    <strong class="text-danger" id="total-amount">
                                        {{ number_format($total, 0, ',', '.') }} ₫
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
                                    ({{ number_format($total, 0, ',', '.') }} ₫)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const radios = document.querySelectorAll('input[name="paymentMethod"]');
            const submitBtn = document.getElementById('submit-btn');
            const details = {
                cod: document.getElementById("cod-details"),
                momo: document.getElementById("momo-details"),
                card: document.getElementById("card-details")
            };
            const totalElement = document.getElementById('total-amount');
            const discountElement = document.getElementById('discount-amount');
            const couponFeedback = document.getElementById('coupon-feedback');
            const applyCouponBtn = document.getElementById('apply-coupon');
            const couponInput = document.getElementById('coupon-code');
            const cartItemIds = "{{ implode(',', $cartItems->pluck('id')->toArray()) }}";
            const form = document.getElementById('checkout-form');
            const select = document.getElementById('address-select');
            const detailBox = document.getElementById('address-details');
            const manualAddressInput = document.getElementById('manual-address-input');
            const shippingAddressIdInput = document.getElementById('shipping-address-id');
            const nameSpan = document.getElementById('detail-name');
            const phoneSpan = document.getElementById('detail-phone');
            const addressSpan = document.getElementById('detail-address');
            const nameInput = document.querySelector('input[name="name"]');
            const phoneInput = document.querySelector('input[name="phone_number"]');
            const addressInput = document.querySelector('input[name="address"]');
            const wardInput = document.querySelector('input[name="ward"]');
            const districtInput = document.querySelector('input[name="district"]');
            const cityInput = document.querySelector('input[name="city"]');
            let lastModified = localStorage.getItem('cartLastModified') || Date.now().toString();

            // Kiểm tra trạng thái thanh toán và giỏ hàng
            function checkPaymentAndCartStatus() {
                if (localStorage.getItem('paymentInProgress') === '1') {
                    Swal.fire({
                        title: 'Đang xử lý thanh toán',
                        text: 'Một tab khác đang thực hiện thanh toán. Vui lòng làm mới trang để tiếp tục.',
                        icon: 'warning',
                        confirmButtonText: 'Làm mới ngay',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    return false;
                }
                return true;
            }

            // Lắng nghe sự kiện storage để phát hiện thay đổi
            window.addEventListener('storage', function(event) {

                if (event.key === 'paymentInProgress' && event.newValue === '1') {
                    Swal.fire({
                        title: 'Đang xử lý thanh toán',
                        text: 'Một tab khác đang thực hiện thanh toán. Vui lòng làm mới trang để tiếp tục.',
                        icon: 'warning',
                        confirmButtonText: 'Làm mới ngay',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }

                if (event.key === 'cartLastModified' && event.newValue !== lastModified) {
                    Swal.fire({
                        title: 'Giỏ hàng đã thay đổi',
                        text: 'Giỏ hàng của bạn đã được cập nhật ở tab khác. Vui lòng làm mới trang để tiếp tục.',
                        icon: 'warning',
                        confirmButtonText: 'Làm mới ngay',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            });

            // Cập nhật nút thanh toán dựa trên phương thức
            function updatePaymentButton() {
                const selected = document.querySelector('input[name="paymentMethod"]:checked').value;
                const total = totalElement.textContent.trim();
                if (selected === 'cod') {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Đặt hàng`;
                    submitBtn.classList.remove('btn-primary', 'btn-warning');
                    submitBtn.classList.add('btn-success');
                } else if (selected === 'card') {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Thanh toán (${total})`;
                    submitBtn.classList.remove('btn-success', 'btn-warning');
                    submitBtn.classList.add('btn-primary');
                } else {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Thanh toán momo (${total})`;
                    submitBtn.classList.remove('btn-primary', 'btn-success');
                    submitBtn.classList.add('btn-warning');
                }
                Object.keys(details).forEach(key => {
                    if (details[key]) {
                        details[key].style.display = (key === selected) ? "block" : "none";
                    }
                });
            }

            radios.forEach(radio => radio.addEventListener("change", updatePaymentButton));
            updatePaymentButton();

            // Xử lý chọn địa chỉ
            select.addEventListener('change', function() {
                const selected = select.options[select.selectedIndex];
                if (selected.value) {
                    nameSpan.textContent = selected.dataset.name || '';
                    phoneSpan.textContent = selected.dataset.phone || '';
                    addressSpan.textContent = selected.dataset.fullAddress || '';
                    detailBox.classList.remove('d-none');
                    nameInput.value = selected.dataset.name || '';
                    phoneInput.value = selected.dataset.phone || '';
                    addressInput.value = selected.dataset.address || '';
                    wardInput.value = selected.dataset.ward || '';
                    districtInput.value = selected.dataset.district || '';
                    cityInput.value = selected.dataset.city || '';
                    shippingAddressIdInput.value = selected.value;
                    manualAddressInput.classList.add('d-none');
                } else {
                    detailBox.classList.add('d-none');
                    manualAddressInput.classList.remove('d-none');
                    nameInput.value = '';
                    phoneInput.value = '';
                    addressInput.value = '';
                    wardInput.value = '';
                    districtInput.value = '';
                    cityInput.value = '';
                    shippingAddressIdInput.value = '';
                }
            });

            // Xử lý áp dụng mã giảm giá
            applyCouponBtn.addEventListener('click', function() {
                const couponCode = couponInput.value.trim();
                if (!couponCode) {
                    couponFeedback.textContent = 'Vui lòng nhập mã giảm giá.';
                    couponFeedback.className = 'form-text text-danger mt-1';
                    couponFeedback.style.display = 'block';
                    return;
                }

                fetch('{{ route('checkout.applyCoupon') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            coupon_code: couponCode,
                            cart_item_ids: cartItemIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        couponFeedback.style.display = 'block';
                        if (data.success) {
                            couponFeedback.textContent = data.message;
                            couponFeedback.className = 'form-text text-success mt-1';
                            discountElement.textContent = `-${data.formatted_discount}`;
                            totalElement.textContent = data.formatted_total;
                            updatePaymentButton();
                        } else {
                            couponFeedback.textContent = data.message;
                            couponFeedback.className = 'form-text text-danger mt-1';
                        }
                    })
                    .catch(error => {
                        couponFeedback.textContent = 'Có lỗi xảy ra khi áp dụng mã giảm giá.';
                        couponFeedback.className = 'form-text text-danger mt-1';
                        couponFeedback.style.display = 'block';
                    });
            });

            // Xử lý gửi form thanh toán
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const paymentMethod = formData.get('paymentMethod');
                const shippingAddressId = formData.get('shipping_address_id');
                const name = formData.get('name');
                const phoneNumber = formData.get('phone_number');
                const address = formData.get('address');

                // Kiểm tra dữ liệu trước khi gửi
                if (!paymentMethod) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lỗi',
                        text: 'Vui lòng chọn phương thức thanh toán.',
                        timer: 1500
                    });
                    return;
                }
                if (!shippingAddressId && (!name || !phoneNumber || !address)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lỗi',
                        text: 'Vui lòng nhập đầy đủ thông tin giao hàng hoặc chọn địa chỉ có sẵn.',
                        timer: 1500
                    });
                    return;
                }
                if (!document.getElementById('agree').checked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lỗi',
                        text: 'Bạn cần đồng ý với chính sách mua hàng để tiếp tục.',
                        timer: 1500
                    });
                    return;
                }

                // Kiểm tra trạng thái thanh toán
                if (!checkPaymentAndCartStatus()) {
                    return;
                }

                // Đánh dấu bắt đầu thanh toán
                localStorage.setItem('paymentInProgress', '1');

                // Gửi yêu cầu
                fetch('{{ route('checkout.submit') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error('Sản phẩm này đã được đặt rồi. Vui lòng quay lại trang giỏ hàng! ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            // Cập nhật cartLastModified và lastModified cục bộ
                            lastModified = Date.now().toString();
                            localStorage.setItem('cartLastModified', lastModified);
                            if (paymentMethod === 'card' && data.vnpay_url) {
                                window.location.href = data.vnpay_url;
                            } else if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công',
                                    text: data.message || 'Đặt hàng thành công!',
                                    timer: 1500
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: data.message || 'Có lỗi xảy ra.',
                                timer: 1500
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã có lỗi xảy ra khi xử lý đơn hàng: ' + error.message,
                            timer: 1500
                        });
                    })
                    .finally(() => {
                        // Xóa paymentInProgress sau khi hoàn tất
                        localStorage.removeItem('paymentInProgress');
                    });
            });
        });
    </script>
@endsection
