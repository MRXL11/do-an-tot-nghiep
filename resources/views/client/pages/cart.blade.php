@extends('client.pages.page-layout')
@section('content')

<section class="section py-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-cart-fill me-2"></i>Giỏ hàng của bạn</h5>
            </div>

            <!-- Bảng hiển thị danh sách sản phẩm trong giỏ -->
            <div class="table-responsive bg-white">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th><input type="checkbox" id="check-all"></th> <!-- Checkbox chọn tất cả -->
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
                        @foreach($cartItems as $item)
                        <tr id="row-{{ $item->id }}"> <!-- Mỗi sản phẩm có 1 id riêng -->
                            <td>
                                <!-- Checkbox cho từng sản phẩm -->
                                <input type="checkbox" class="item-checkbox" 
                                    data-id="{{ $item->id }}" 
                                    data-price="{{ $item->productVariant->price }}" 
                                    data-quantity="{{ $item->quantity }}">
                            </td>
                            <td>
                                <!-- Hình ảnh sản phẩm -->
                                <img src="{{ asset('storage/' . $item->productVariant->product->image) }}" alt="" width="60">
                            </td>
                            <td>
                                <!-- Tên sản phẩm -->
                                <div class="fw-semibold">{{ $item->productVariant->product->name }}</div>
                            </td>
                            <td>
                                <!-- Phân loại: Size / Màu -->
                                {{ $item->productVariant->size }} / {{ $item->productVariant->color }}
                            </td>
                            <td class="text-primary fw-bold">
                                <!-- Giá sản phẩm -->
                                ${{ $item->productVariant->price }}
                            </td>
                            <td>
                                <!-- Tăng giảm số lượng -->
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-secondary btn-sm btn-minus" data-cartid="{{ $item->id }}">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="text" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" readonly 
                                        class="form-control text-center mx-1 quantity-input">
                                    <button class="btn btn-outline-secondary btn-sm btn-plus" 
                                        data-cartid="{{ $item->id }}" 
                                        data-stock="{{ $item->productVariant->stock_quantity }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="fw-bold item-total" id="item-total-{{ $item->id }}">
                                <!-- Tổng tiền của từng sản phẩm -->
                                ${{ $item->productVariant->price * $item->quantity }}
                            </td>
                            <td>
                                <!-- Nút xóa sản phẩm khỏi giỏ -->
                                <button class="btn btn-outline-danger btn-remove" data-cartid="{{ $item->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Phần tổng cộng và nút xóa chọn -->
            <div class="bg-white shadow-sm p-3 mt-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <button type="button" class="btn btn-danger btn-remove-selected mb-2 mb-md-0">
                        Xóa sản phẩm đã chọn
                    </button>
                </div>
                <div class="text-end">
                    <span class="me-3 fs-5">
                        Tổng cộng (<span id="selected-count">0</span> sản phẩm): 
                        <strong id="total" class="text-danger fs-5">$0.00</strong>
                    </span>
                    <a href="#" class="btn btn-warning text-white">Tiến hành thanh toán</a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    .quantity-input {
        width: 50px;
        height: 30px;
    }
    table th, table td {
        vertical-align: middle !important;
    }
</style>

<!-- Phần JS xử lý sự kiện  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Cập nhật số lượng sản phẩm
    function updateQuantity(id, qty) {
        $.post('{{ route("cart.update") }}', {
            _token: '{{ csrf_token() }}', // token chống CSRF
            cart_id: id,
            quantity: qty
        }, function(res) {
            // Cập nhật tổng tiền của sản phẩm sau khi thay đổi số lượng
            $('#item-total-' + id).text('$' + res.itemTotal.toFixed(2));
            updateSummary(); 
            
        });
    }

    // Cập nhật tổng cộng (tổng số sp chọn + tổng tiền)
    function updateSummary() {
        let total = 0;
        let count = 0;
        $('.item-checkbox:checked').each(function() {
            const id = $(this).data('id');
            const price = parseFloat($(this).data('price'));
            const qty = parseInt($('#quantity-' + id).val());
            total += price * qty;
            count++; // đếm số sản phẩm đã chọn
        });
        $('#total').text('$' + total.toFixed(2)); 
        $('#selected-count').text(count);
    }

    // Giảm số lượng
    $('.btn-minus').click(function() {
        const id = $(this).data('cartid');
        const input = $('#quantity-' + id);
        let qty = parseInt(input.val()) - 1;
        if(qty >= 1) { // không cho giảm dưới 1
            input.val(qty);
            updateQuantity(id, qty);
        } else {
            alert('Tối thiểu là 1');
        }
    });

    // Tăng số lượng
    $('.btn-plus').click(function() {
        const id = $(this).data('cartid');
        const input = $('#quantity-' + id);
        let qty = parseInt(input.val()) + 1;
        const stock = $(this).data('stock'); // kiểm tra tồn kho
        if(qty <= stock) { // không cho vượt quá tồn kho
            input.val(qty);
            updateQuantity(id, qty);
        } else {
            alert('Chỉ còn ' + stock);
        }
    });

    // Xóa 1 sản phẩm
    $('.btn-remove').click(function(e) {
        e.preventDefault();
        const button = $(this);
        const id = button.data('cartid');

        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // đỏ đẹp
            cancelButtonColor: '#3085d6', // xanh
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            backdrop: true,
            allowOutsideClick: false,
            position: 'center' // Hiện ở giữa đẹp
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('{{ route("cart.remove") }}', {
                    _token: '{{ csrf_token() }}',
                    cart_id: id
                }, function(res) {
                    if(res.success) {
                        $('#row-' + id).remove();
                        updateSummary();

                        $('#cart-count').text(res.newCartCount);
                        if(res.newCartCount == 0){
                            $('#cart-count').hide();
                        } else {
                            $('#cart-count').show();
                        }

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Đã xóa sản phẩm!',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                });
            }
        });
    });

    // Xóa các sản phẩm đã chọn
    $('.btn-remove-selected').click(function(e) {
        e.preventDefault();
        const selected = [];
        $('.item-checkbox:checked').each(function() {
            selected.push($(this).data('id'));
        });

        if(selected.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Chưa chọn sản phẩm nào!',
                text: 'Hãy chọn ít nhất một sản phẩm để xóa.',
                timer: 1500,
                showConfirmButton: false,
                position: 'center'
            });
            return;
        }

        Swal.fire({
            title: 'Xóa các sản phẩm đã chọn?',
            text: "Bạn có chắc chắn muốn xóa tất cả sản phẩm đã chọn?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa hết',
            cancelButtonText: 'Hủy',
            backdrop: true,
            allowOutsideClick: false,
            position: 'center'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('{{ route("cart.removeSelected") }}', {
                    _token: '{{ csrf_token() }}',
                    cart_ids: selected
                }, function(res) {
                    if(res.success) {
                        selected.forEach(id => $('#row-' + id).remove());
                        updateSummary();

                        $('#cart-count').text(res.newCartCount);
                        if(res.newCartCount == 0){
                            $('#cart-count').hide();
                        } else {
                            $('#cart-count').show();
                        }

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Đã xóa các sản phẩm đã chọn!',
                            showConfirmButton: false,
                            timer: 1200
                        });
                    }
                });
            }
        });
    });

    // chọn tất cả sản phẩm
    $('#check-all').change(function() {
        $('.item-checkbox').prop('checked', $(this).prop('checked')); // check/uncheck tất cả
        updateSummary();
    });

    //check/uncheck từng sản phẩm
    $('.item-checkbox').change(function() {
        $('#check-all').prop('checked', $('.item-checkbox:checked').length === $('.item-checkbox').length);
        updateSummary();
    });

    updateSummary();
});
</script>
@endsection
