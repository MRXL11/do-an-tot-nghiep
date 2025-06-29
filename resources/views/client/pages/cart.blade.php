@extends('client.pages.page-layout')
@section('content')

    <section class="section py-4">
        <div class="container">
            <div class="card shadow-sm">

                {{-- thông báo lỗi --}}
                @if (session('warning'))
                    <div class="container">
                        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-cart-fill me-2"></i>Giỏ hàng của bạn</h5>
                </div>

                <div class="table-responsive bg-white">
                    @if (!Auth::check())
                        <!-- Người dùng chưa đăng nhập -->
                        <div class="p-4 text-center">
                            <h5>Chưa có sản phẩm nào</h5>
                            <p>Vui lòng <a href="{{ route('login') }}" class="text-primary">đăng nhập</a> để xem và mua sắm
                                sản phẩm.</p>
                        </div>
                    @elseif($cartItems->isEmpty())
                        <!-- Người dùng đã đăng nhập nhưng giỏ hàng trống -->
                        <div class="p-4 text-center">
                            <h5>Chưa có sản phẩm nào trong giỏ hàng</h5>
                            <p><a href="{{ route('home') }}" class="text-primary">Mua sắm ngay</a> để thêm sản phẩm vào giỏ.
                            </p>
                        </div>
                    @else
                        <!-- Hiển thị danh sách sản phẩm trong giỏ -->
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th><input type="checkbox" id="check-all"></th>
                                    <th>Hình ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>Phân loại</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr id="row-{{ $item->id }}"
                                        class="{{ $item->productVariant->status != 'active' ? 'inactive-item' : '' }}">
                                        <td>
                                            <input type="checkbox" class="item-checkbox" data-id="{{ $item->id }}"
                                                data-price="{{ $item->productVariant->price }}"
                                                data-quantity="{{ $item->quantity }}">
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->productVariant->image ?? 'images/default-product.jpg') }}"
                                                alt="Ảnh" width="60">
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->productVariant->product->name }}</div>
                                        </td>
                                        <td>
                                            {{ $item->productVariant->size }} / {{ $item->productVariant->color }}
                                        </td>
                                        <td class="text-primary fw-bold">
                                            {{ number_format($item->productVariant->price, 0, ',', '.') }} ₫
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-outline-secondary btn-sm btn-minus"
                                                    data-cartid="{{ $item->id }}"
                                                    @if ($item->productVariant->status != 'active') disabled @endif>
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="text" id="quantity-{{ $item->id }}"
                                                    value="{{ $item->quantity }}" readonly
                                                    class="form-control text-center mx-1 quantity-input"
                                                    style="@if ($item->productVariant->status != 'active') cursor: not-allowed; @endif">
                                                <button class="btn btn-outline-secondary btn-sm btn-plus"
                                                    data-cartid="{{ $item->id }}"
                                                    data-stock="{{ $item->productVariant->stock_quantity }}"
                                                    @if ($item->productVariant->status != 'active') disabled @endif>
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="fw-bold item-total" id="item-total-{{ $item->id }}">
                                            {{ number_format($item->productVariant->price * $item->quantity, 0, ',', '.') }}
                                            ₫
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-danger btn-remove"
                                                data-cartid="{{ $item->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div
                            class="bg-white shadow-sm p-3 mt-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-danger btn-remove-selected mb-2 mb-md-0">
                                    Xóa sản phẩm đã chọn
                                </button>
                            </div>
                            <div class="text-end">
                                <span class="me-3 fs-5">
                                    Tổng cộng (<span id="selected-count">0</span> sản phẩm):
                                    <strong id="total" class="text-danger fs-5"></strong>
                                </span>
                                <a href="{{ route('checkout') }}" class="btn btn-warning text-white btn-checkout">Tiến hành
                                    thanh toán</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .quantity-input {
            width: 50px;
            height: 30px;
        }

        table th,
        table td {
            vertical-align: middle !important;
        }

        .inactive-item {
            opacity: 0.5;
        }
    </style>

    <!-- Phần JS xử lý sự kiện  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // kiểm tra trạng thái sản phẩm trên
        const cartItems = @json(
            $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'status' => $item->productVariant->status ?? 'inactive',
                ];
            }));

        $(document).ready(function() {
            let quantityUpdateTimeout;

            // Hàm render cảnh báo sản phẩm ngưng bán
            function renderInactiveWarning() {
                $('.alert-warning').remove(); // Xóa cảnh báo cũ
                const inactiveProducts = cartItems.filter(p => p.status !== 'active');
                if (inactiveProducts.length > 0) {
                    const warning = `
                    <div class="alert alert-warning mt-3">
                        ⚠️ <strong>Chú ý:</strong> Có ${inactiveProducts.length} sản phẩm đã ngưng bán.
                        Vui lòng xóa chúng khỏi giỏ hàng nếu không còn cần thiết.
                    </div>
                `;
                    $('.table-responsive').before(warning);
                }
            }

            // Cập nhật số lượng sản phẩm có debounce
            function updateQuantityDebounced(id, qty) {
                clearTimeout(quantityUpdateTimeout);
                quantityUpdateTimeout = setTimeout(() => {
                    $.post('{{ route('cart.update') }}', {
                        _token: '{{ csrf_token() }}',
                        cart_id: id,
                        quantity: qty
                    }, res => {
                        $('#item-total-' + id).text(total.toLocaleString('vi-VN') + ' ₫');
                        updateSummary();
                    });
                }, 800);
            }

            // Cập nhật số lượng ngay lập tức
            function updateQuantity(id, qty) {
                $.post('{{ route('cart.update') }}', {
                    _token: '{{ csrf_token() }}',
                    cart_id: id,
                    quantity: qty
                }, res => {
                    $('#item-total-' + id).text(total.toLocaleString('vi-VN') + ' ₫');
                    updateSummary();
                });
            }

            // Tính tổng cộng sản phẩm đã chọn
            function updateSummary() {
                let total = 0,
                    count = 0;
                $('.item-checkbox:checked').each(function() {
                    const id = $(this).data('id');
                    const price = parseFloat($(this).data('price'));
                    const qty = parseInt($('#quantity-' + id).val());
                    const product = cartItems.find(p => p.id === id);

                    if (product && product.status === 'active') {
                        total += price * qty;
                        count++;
                    } else {
                        $(this).prop('checked', false);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sản phẩm ngừng hoạt động',
                            text: 'Sản phẩm này đã ngừng bán, không thể thanh toán!',
                            timer: 1500,
                            showConfirmButton: false,
                            scrollbarPadding: false

                        });
                    }
                });
                $('#total').text(total.toLocaleString('vi-VN') + ' ₫');
                $('#selected-count').text(count);
            }

            // Hiển thị cảnh báo khi load trang
            renderInactiveWarning();

            // Giảm số lượng
            $('.btn-minus').click(function() {
                const id = $(this).data('cartid');
                const product = cartItems.find(p => p.id === id);
                if (product.status !== 'active') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sản phẩm ngừng hoạt động',
                        text: 'Không thể thay đổi!',
                        timer: 1500,
                        scrollbarPadding: false
                    });
                    return;
                }
                const input = $('#quantity-' + id);
                let qty = parseInt(input.val()) - 1;
                if (qty >= 1) {
                    input.val(qty);
                    updateQuantityDebounced(id, qty);
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: 'Số lượng tối thiểu là 1.',
                        timer: 1500,
                        scrollbarPadding: false
                    });
                }
            });

            // Tăng số lượng
            $('.btn-plus').click(function() {
                const id = $(this).data('cartid');
                const product = cartItems.find(p => p.id === id);
                if (product.status !== 'active') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sản phẩm ngừng hoạt động',
                        text: 'Không thể thay đổi!',
                        timer: 1500,
                        scrollbarPadding: false
                    });
                    return;
                }
                const input = $('#quantity-' + id);
                let qty = parseInt(input.val()) + 1;
                const stock = $(this).data('stock');
                if (qty <= stock) {
                    input.val(qty);
                    updateQuantityDebounced(id, qty);
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Thông báo',
                        text: `Chỉ còn ${stock} sản phẩm trong kho.`,
                        timer: 1500,
                        scrollbarPadding: false
                    });
                }
            });

            // Xóa 1 sản phẩm
            $('.btn-remove').click(function(e) {
                e.preventDefault();
                const id = $(this).data('cartid');
                Swal.fire({
                    title: 'Xác nhận xóa?',
                    text: 'Bạn có chắc muốn xóa sản phẩm này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    scrollbarPadding: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('{{ route('cart.remove') }}', {
                            _token: '{{ csrf_token() }}',
                            cart_id: id
                        }, res => {
                            if (res.success) {
                                $('#row-' + id).remove();

                                // Cập nhật mảng cartItems
                                const index = cartItems.findIndex(item => item.id === id);
                                if (index !== -1) cartItems.splice(index, 1);

                                updateSummary();
                                renderInactiveWarning(); // render lại cảnh báo

                                if ($('.item-checkbox').length === 0) location.reload();
                                $('#cart-count').text(res.newCartCount).toggle(res
                                    .newCartCount != 0);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã xóa!',
                                    timer: 1000,
                                    scrollbarPadding: false
                                });
                            }
                        });
                    }
                });
            });

            // Xóa các sản phẩm đã chọn
            $('.btn-remove-selected').click(function(e) {
                e.preventDefault();
                const selected = $('.item-checkbox:checked').map(function() {
                    return $(this).data('id');
                }).get();
                if (selected.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Chưa chọn sản phẩm!',
                        timer: 1500,
                        scrollbarPadding: false
                    });
                    return;
                }
                Swal.fire({
                    title: 'Xóa các sản phẩm đã chọn?',
                    text: 'Bạn có chắc muốn xóa tất cả?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa hết',
                    cancelButtonText: 'Hủy',
                    scrollbarPadding: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('{{ route('cart.removeSelected') }}', {
                            _token: '{{ csrf_token() }}',
                            cart_ids: selected
                        }, res => {
                            if (res.success) {
                                selected.forEach(id => {
                                    $('#row-' + id).remove();
                                    const index = cartItems.findIndex(item => item
                                        .id === id);
                                    if (index !== -1) cartItems.splice(index, 1);
                                });

                                updateSummary();
                                renderInactiveWarning(); // cập nhật cảnh báo ngưng bán

                                if ($('.item-checkbox').length === 0) location.reload();
                                $('#cart-count').text(res.newCartCount).toggle(res
                                    .newCartCount != 0);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã xóa các sản phẩm đã chọn!',
                                    timer: 1200,
                                    scrollbarPadding: false
                                });
                            }
                        });
                    }
                });
            });

            // Chọn/Bỏ chọn tất cả
            $('#check-all').change(function() {
                $('.item-checkbox').prop('checked', $(this).prop('checked'));
                updateSummary();
            });

            // Chọn/Bỏ chọn từng sản phẩm
            $('.item-checkbox').change(function() {
                $('#check-all').prop('checked', $('.item-checkbox:checked').length === $('.item-checkbox')
                    .length);
                updateSummary();
            });

            // Kiểm tra trước khi thanh toán
            $('.btn-checkout').click(function(e) {
                e.preventDefault();

                let selectedIds = [];

                $('.item-checkbox:checked').each(function() {
                    const id = $(this).data('id');
                    const product = cartItems.find(p => p.id === id);
                    if (product && product.status === 'active') {
                        selectedIds.push(id);
                    }
                });

                // pop up hiển thị thông báo nếu không có sản phẩm nào được chọn mà đã ấn thanh toán
                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Không thể thanh toán',
                        text: 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.',
                        timer: 2000,
                        scrollbarPadding: false
                    });
                    return;
                }

                // Chuyển hướng sang checkout kèm cart_item_ids
                const url = new URL(window.location.origin + '/checkout');
                url.searchParams.set('cart_item_ids', selectedIds.join(','));
                window.location.href = url.toString();
            });


            updateSummary();
        });
    </script>


@endsection
