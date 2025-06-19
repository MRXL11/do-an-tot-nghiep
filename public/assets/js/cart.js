$(document).on('click', '.btn-add-cart', function(e) {
    e.preventDefault();

    var variantId = $('#size-select').val();
    var quantity = $('#quantity-input').val();

    $.ajax({
        url: '/cart/add-ajax',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_variant_id: variantId,
            quantity: quantity
        },
        success: function(res) {
            if(res.success) {
                // Thông báo ở giữa màn hình
                Swal.fire({
                    position: 'center', // hiện giữa
                    icon: 'success',
                    title: res.message, // hoặc 'Sản phẩm đã được thêm vào Giỏ hàng'
                    showConfirmButton: false,
                    timer: 1500 // tự tắt sau 1.5s
                });

                $('#cart-count').text(res.cart_count);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: res.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Có lỗi xảy ra khi thêm vào giỏ hàng!'
            });
        }
    });
});