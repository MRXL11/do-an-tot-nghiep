@extends('client.pages.page-layout')

@section('content')
    <form method="POST" action="{{ route('checkout.submit') }}" id="checkout-form">
        @csrf
        <input type="hidden" name="cart_item_ids" value="{{ implode(',', $cartItems->pluck('id')->toArray()) }}">
        <input type="hidden" name="shipping_address_id" id="shipping-address-id">
        <div class="container">
            <div class="row justify-content-center align-items-start">
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

                <div class="col-lg-5">
                    <div class="card bg-light border-0 shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="bi bi-credit-card-fill me-2 text-primary"></i>Chi tiết thanh toán</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Chọn phương thức thanh toán:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" value="cod" id="cod" checked>
                                        <label class="form-check-label" for="cod"><i class="bi bi-cash-stack me-1"></i>COD</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" value="card" id="card">
                                        <label class="form-check-label" for="card"><i class="bi bi-credit-card-2-front me-1"></i>VNpay</label>
                                    </div>
                                </div>
                            </div>
                            <div id="cod-details" class="payment-method-details">
                                <div class="alert alert-success py-2 mb-3"><i class="bi bi-truck me-2"></i> Thanh toán khi nhận hàng (COD)</div>
                            </div>
                            <div id="card-details" class="payment-method-details" style="display: none;">
                                <div class="alert alert-info py-2 mb-3"><i class="bi bi-credit-card-2-front me-2"></i> Thanh toán bằng VNpay</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Voucher giảm giá</label>
                                <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#coupon-modal">
                                    <i class="bi bi-ticket-percent-fill me-2"></i> Chọn Voucher
                                </button>
                                <div id="applied-coupons-list" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Chọn địa chỉ giao hàng:</label>
                                <select class="form-select" id="address-select">
                                    <option value="">-- Thêm địa chỉ mới --</option>
                                    @foreach ($user->shippingAddresses ?? [] as $address)
                                        <option value="{{ $address->id }}" data-name="{{ $address->name }}" data-phone="{{ $address->phone_number }}" data-address="{{ $address->address }}" data-ward="{{ $address->ward }}" data-district="{{ $address->district }}" data-city="{{ $address->city }}" data-full-address="{{ $address->full_address }}">
                                            {{ $address->full_address }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="address-details" class="border p-3 rounded bg-light d-none">
                                <p class="mb-1"><strong>Người nhận:</strong> <span id="detail-name"></span></p>
                                <p class="mb-1"><strong>Số điện thoại:</strong> <span id="detail-phone"></span></p>
                                <p class="mb-0"><strong>Địa chỉ:</strong> <span id="detail-address"></span></p>
                            </div>
                            <div class="mb-4 mt-4" id="manual-address-input">
                                <label class="form-label fw-semibold">Thông tin giao hàng</label>
                                <div class="mb-2">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Họ và tên người nhận" value="{{ old('name') }}">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Số điện thoại" value="{{ old('phone_number') }}">
                                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Địa chỉ cụ thể (Số nhà, tên đường...)" value="{{ old('address') }}">
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2"><input type="text" name="ward" class="form-control @error('ward') is-invalid @enderror" placeholder="Xã/Phường" value="{{ old('ward') }}">@error('ward')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-4 mb-2"><input type="text" name="district" class="form-control @error('district') is-invalid @enderror" placeholder="Quận/Huyện" value="{{ old('district') }}">@error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-4 mb-2"><input type="text" name="city" class="form-control @error('city') is-invalid @enderror" placeholder="Tỉnh/Thành phố" value="{{ old('city') }}">@error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                </div>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Tạm tính:</span>
                                <strong>{{ number_format($subtotal, 0, ',', '.') }} ₫</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Phí vận chuyển:</span>
                                <strong>{{ number_format($shippingFee, 0, ',', '.') }} ₫</strong>
                            </div>
                            {{-- Placeholder cho các loại giảm giá --}}
                            <div id="order-discount-row" class="d-flex justify-content-between text-success" style="display: none;">
                                <span>Giảm giá đơn hàng:</span>
                                <strong id="order-discount-amount"></strong>
                            </div>
                            <div id="shipping-discount-row" class="d-flex justify-content-between text-success" style="display: none;">
                                <span>Giảm giá vận chuyển:</span>
                                <strong id="shipping-discount-amount"></strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fs-5 mt-2">
                                <span>Tổng cộng:</span>
                                <strong class="text-danger" id="total-amount">
                                    {{ number_format($subtotal + $shippingFee, 0, ',', '.') }} ₫
                                </strong>
                            </div>

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="agree" checked>
                                <label class="form-check-label" for="agree">
                                    Tôi đồng ý với <a href="#" class="text-decoration-underline">chính sách mua hàng</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mt-3" id="submit-btn">
                                <i class="bi bi-cart-check me-2"></i>Thanh toán
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="coupon-modal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">Chọn Voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="coupon-list-container">
                        <div class="text-center" id="coupon-loader">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                        <h6 class="text-primary fw-bold">Mã giảm giá đơn hàng</h6>
                        <div id="order-coupons-list" class="mb-4">
                        </div>
                        <hr>
                        <h6 class="text-primary fw-bold">Mã giảm giá vận chuyển</h6>
                        <div id="shipping-coupons-list">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // [GIỮ NGUYÊN] - Khai báo biến cho các chức năng có sẵn
            const radios = document.querySelectorAll('input[name="paymentMethod"]');
            const submitBtn = document.getElementById('submit-btn');
            const details = {
                cod: document.getElementById("cod-details"),
                card: document.getElementById("card-details")
            };
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

            // [GIỮ NGUYÊN] - Khai báo biến cho logic mã giảm giá
            let appliedCoupons = { order: null, shipping: null };
            const subtotal = {{ $subtotal }};
            const shippingFee = {{ $shippingFee }};
            const cartItemIds = "{{ implode(',', $cartItems->pluck('id')->toArray()) }}";
            const couponModal = new bootstrap.Modal(document.getElementById('coupon-modal'));
            const couponListContainer = document.getElementById('coupon-list-container');
            const couponLoader = document.getElementById('coupon-loader');
            const orderCouponsList = document.getElementById('order-coupons-list');
            const shippingCouponsList = document.getElementById('shipping-coupons-list');
            const appliedCouponsList = document.getElementById('applied-coupons-list');
            const totalAmountEl = document.getElementById('total-amount');
            const orderDiscountRow = document.getElementById('order-discount-row');
            const orderDiscountAmountEl = document.getElementById('order-discount-amount');
            const shippingDiscountRow = document.getElementById('shipping-discount-row');
            const shippingDiscountAmountEl = document.getElementById('shipping-discount-amount');

            // [GIỮ NGUYÊN] - Logic xử lý thanh toán và địa chỉ
            function updatePaymentButton() {
                const selected = document.querySelector('input[name="paymentMethod"]:checked').value;
                const total = totalAmountEl.textContent.trim();
                if (selected === 'cod') {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Đặt hàng`;
                } else {
                    submitBtn.innerHTML = `<i class="bi bi-cart-check me-2"></i>Thanh toán (${total})`;
                }
                Object.keys(details).forEach(key => {
                    if (details[key]) details[key].style.display = (key === selected) ? "block" : "none";
                });
            }
            radios.forEach(radio => radio.addEventListener("change", updatePaymentButton));
            updatePaymentButton();

            select.addEventListener('change', function() {
                const selected = select.options[select.selectedIndex];
                const useNewAddress = !selected.value;
                detailBox.classList.toggle('d-none', useNewAddress);
                manualAddressInput.classList.toggle('d-none', !useNewAddress);
                if (!useNewAddress) {
                    nameSpan.textContent = selected.dataset.name || '';
                    phoneSpan.textContent = selected.dataset.phone || '';
                    addressSpan.textContent = selected.dataset.fullAddress || '';
                    nameInput.value = selected.dataset.name || '';
                    phoneInput.value = selected.dataset.phone || '';
                    addressInput.value = selected.dataset.address || '';
                    wardInput.value = selected.dataset.ward || '';
                    districtInput.value = selected.dataset.district || '';
                    cityInput.value = selected.dataset.city || '';
                    shippingAddressIdInput.value = selected.value;
                } else {
                    nameInput.value = ''; phoneInput.value = ''; addressInput.value = '';
                    wardInput.value = ''; districtInput.value = ''; cityInput.value = '';
                    shippingAddressIdInput.value = '';
                }
            });
            select.dispatchEvent(new Event('change'));

            // [GIỮ NGUYÊN] - Logic cho mã giảm giá
            document.querySelector('[data-bs-target="#coupon-modal"]').addEventListener('click', fetchAvailableCoupons);

            async function fetchAvailableCoupons() {
                couponLoader.style.display = 'block';
                orderCouponsList.innerHTML = '';
                shippingCouponsList.innerHTML = '';
                try {
                    const response = await fetch(`{{ route('checkout.getAvailableCoupons') }}?cart_item_ids=${cartItemIds}`);
                    const coupons = await response.json();
                    renderCouponsInModal(coupons);
                } catch (error) {
                    orderCouponsList.innerHTML = `<p class="text-danger text-center">Không thể tải danh sách voucher.</p>`;
                } finally {
                    couponLoader.style.display = 'none';
                }
            }

            function renderCouponsInModal(coupons) {
                const orderCoupons = coupons.filter(c => c.type === 'order');
                const shippingCoupons = coupons.filter(c => c.type === 'shipping');

                if (orderCoupons.length > 0) {
                    orderCoupons.forEach(coupon => {
                        orderCouponsList.appendChild(createCouponElement(coupon));
                    });
                } else {
                    orderCouponsList.innerHTML = `<p class="text-muted text-center">Không có voucher nào phù hợp.</p>`;
                }

                if (shippingCoupons.length > 0) {
                    shippingCoupons.forEach(coupon => {
                        shippingCouponsList.appendChild(createCouponElement(coupon));
                    });
                } else {
                    shippingCouponsList.innerHTML = `<p class="text-muted text-center">Không có voucher nào phù hợp.</p>`;
                }

                couponListContainer.querySelectorAll('.apply-coupon-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => handleApplyOrRemoveCoupon(e.target.dataset.code));
                });
            }

            function createCouponElement(coupon) {
                const isApplied = appliedCoupons[coupon.type]?.code === coupon.code;
                const isDisabled = !isApplied && appliedCoupons[coupon.type] !== null;
                const couponEl = document.createElement('div');
                couponEl.className = 'card mb-2';
                couponEl.innerHTML = `
                    <div class="card-body d-flex justify-content-between align-items-center p-2">
                        <div>
                            <h6 class="card-title mb-0 text-success">${coupon.code}</h6>
                            <small class="text-muted">${coupon.description}</small>
                        </div>
                        <button class="btn btn-sm btn-primary apply-coupon-btn" data-code="${coupon.code}" ${isDisabled ? 'disabled' : ''}>
                            ${isApplied ? 'Bỏ chọn' : 'Áp dụng'}
                        </button>
                    </div>`;
                return couponEl;
            }

            function handleApplyOrRemoveCoupon(code) {
                let codesToApply = new Set();
                if (appliedCoupons.order) codesToApply.add(appliedCoupons.order.code);
                if (appliedCoupons.shipping) codesToApply.add(appliedCoupons.shipping.code);

                if (codesToApply.has(code)) {
                    codesToApply.delete(code);
                } else {
                    codesToApply.add(code);
                }
                recalculateTotals(Array.from(codesToApply));
            }

            function handleRemoveCouponFromTag(type) {
                let codesToApply = new Set();
                if (appliedCoupons.order) codesToApply.add(appliedCoupons.order.code);
                if (appliedCoupons.shipping) codesToApply.add(appliedCoupons.shipping.code);

                if (appliedCoupons[type]) {
                    codesToApply.delete(appliedCoupons[type].code);
                }
                recalculateTotals(Array.from(codesToApply));
            }

            async function recalculateTotals(codes) {
                couponModal.hide();
                Swal.fire({ title: 'Đang cập nhật...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });

                try {
                    const response = await fetch('{{ route('checkout.applyCoupons') }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: JSON.stringify({ coupon_codes: codes, cart_item_ids: cartItemIds })
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Lỗi khi áp dụng mã.');

                    appliedCoupons = { order: null, shipping: null };
                    data.applied_coupons.forEach(c => { appliedCoupons[c.type] = c; });
                    
                    updateUI(data.order_discount, data.shipping_discount, data.total);
                    Swal.close();
                } catch (error) {
                    Swal.fire('Lỗi', error.message, 'error');
                }
            }

            // [SỬA ĐỔI] - Cập nhật UI để hiển thị loại voucher
            function updateUI(orderDiscount, shippingDiscount, total) {
                appliedCouponsList.innerHTML = '';
                Object.values(appliedCoupons).forEach(coupon => {
                    if (coupon) {
                        // Xác định văn bản hiển thị dựa trên loại coupon
                        const couponTypeText = coupon.type === 'order' ? 'Giảm giá đơn hàng' : 'Giảm giá vận chuyển';
                        
                        const appliedEl = document.createElement('div');
                        appliedEl.className = 'alert alert-success py-2 px-3 mt-2 d-flex justify-content-between align-items-center';
                        appliedEl.innerHTML = `
                            <span>
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>${coupon.code}</strong>
                                <small class="text-muted fst-italic ms-2">(${couponTypeText})</small>
                            </span>
                            <button type="button" class="btn-close remove-coupon-btn" data-type="${coupon.type}"></button>`;
                        appliedCouponsList.appendChild(appliedEl);
                    }
                });

                appliedCouponsList.querySelectorAll('.remove-coupon-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => handleRemoveCouponFromTag(e.target.dataset.type));
                });

                orderDiscountRow.style.display = (orderDiscount > 0) ? 'flex' : 'none';
                orderDiscountAmountEl.textContent = `- ${orderDiscount.toLocaleString('vi-VN')} ₫`;

                shippingDiscountRow.style.display = (shippingDiscount > 0) ? 'flex' : 'none';
                shippingDiscountAmountEl.textContent = `- ${shippingDiscount.toLocaleString('vi-VN')} ₫`;

                totalAmountEl.textContent = `${total.toLocaleString('vi-VN')} ₫`;
                updatePaymentButton();
            }
            
            // [GIỮ NGUYÊN] - Logic submit form
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                if (!document.getElementById('agree').checked) {
                    Swal.fire({icon: 'warning', title: 'Lỗi', text: 'Bạn cần đồng ý với chính sách mua hàng.'});
                    return;
                }
                Swal.fire({ title: 'Đang xử lý đơn hàng...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });
                
                fetch('{{ route('checkout.submit') }}', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.vnpay_url) {
                            window.location.href = data.vnpay_url;
                        } else {
                            window.location.href = data.redirect;
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Lỗi', text: data.message || 'Có lỗi xảy ra.' });
                    }
                })
                .catch(error => {
                    Swal.fire({ icon: 'error', title: 'Lỗi', text: 'Đã có lỗi xảy ra khi xử lý đơn hàng.' });
                });
            });
        });
    </script>
@endsection