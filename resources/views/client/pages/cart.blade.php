@extends('client.pages.page-layout')

@section('content')
<section class="section">
  <div class="container">
    <div class="row">

      <!-- Giỏ hàng -->
      <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <div>
              <h5 class="mb-0"><i class="bi bi-cart-fill me-2"></i>Giỏ hàng của bạn</h5>
              <small class="text-white-50">Bạn đang có {{ $cartItems->count() }} sản phẩm trong giỏ hàng</small>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0 align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th></th>
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
                  @foreach($cartItems as $item)
<tr>
    <td><input type="checkbox"></td>
    <td><img src="{{ asset('storage/'.$item->productVariant->product->image) }}" height="50" class="rounded"></td>
    <td>{{ $item->productVariant->product->name }}</td>
    <td>{{ $item->productVariant->size }}</td>
    <td>{{ $item->productVariant->color }}</td>
    <td class="text-primary fw-semibold">${{ $item->productVariant->price }}</td>
    <td>
        <div class="input-group input-group-sm">
            <button class="btn btn-outline-secondary btn-minus" data-cartid="{{ $item->id }}" type="button"><i class="bi bi-dash"></i></button>
            <input type="text" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" readonly class="form-control text-center" style="max-width: 50px;">
            <button class="btn btn-outline-secondary btn-plus" data-cartid="{{ $item->id }}" type="button"><i class="bi bi-plus"></i></button>
        </div>
    </td>
    <td class="fw-bold item-total" id="item-total-{{ $item->id }}">${{ $item->productVariant->price * $item->quantity }}</td>
    <td><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></td>
</tr>
@endforeach

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
              <form action="{{ route('cart.applyCoupon') }}" method="POST" class="input-group">
                @csrf
                <input type="text" name="coupon_code" id="coupon" class="form-control" placeholder="Nhập mã...">
                <button type="submit" class="btn btn-outline-primary">Áp dụng</button>
              </form>
            </div>
            <ul class="list-group mb-3">
              <li class="list-group-item d-flex justify-content-between">
                  <span>Tạm tính</span> <strong id="subtotal">${{ $subtotal }}</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                  <span>Phí vận chuyển</span> <strong>${{ $shipping }}</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                  <span>Tổng cộng</span> <strong id="total">${{ $total }}</strong>
              </li>
            </ul>
            <div class="d-grid gap-2">
              <a href="#" class="btn btn-primary form-control text-white">Tiến hành thanh toán</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script >
    function updateQuantity(cartId, newQuantity) {
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                cart_id: cartId,
                quantity: newQuantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#item-total-' + cartId).text('$' + response.itemTotal);
                $('#subtotal').text('$' + response.subtotal);
                $('#total').text('$' + response.total);
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    }

    $('.btn-plus').click(function() {
        var cartId = $(this).data('cartid');
        var input = $('#quantity-' + cartId);
        var quantity = parseInt(input.val()) + 1;
        input.val(quantity);
        updateQuantity(cartId, quantity);
    });

    $('.btn-minus').click(function() {
        var cartId = $(this).data('cartid');
        var input = $('#quantity-' + cartId);
        var quantity = parseInt(input.val()) - 1;
        if(quantity >= 1){
            input.val(quantity);
            updateQuantity(cartId, quantity);
        }
    });
</script>

</section>

@endsection
