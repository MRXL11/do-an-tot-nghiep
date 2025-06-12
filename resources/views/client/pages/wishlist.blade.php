@extends('client.pages.page-layout')
@section('content')
    <div class="container">
        <h4 class="mb-4"><i class="bi bi-heart-fill text-danger me-2"></i>Sản phẩm yêu thích của bạn</h4>

        {{-- nếu người dùng đã đăng nhập -> hiển thị wishlist từ db --}}
        @auth
            @if ($wishlistItems->isEmpty())
                <p>Bạn chưa có sản phẩm yêu thích nào.</p>
                <p class="text-muted mb-2">Hãy thêm sản phẩm vào danh sách yêu thích để dễ dàng theo dõi và mua sắm sau này.</p>
            @else
                <div class="table-responsive mb-4 shadow-sm">
                    <!-- Table yêu thích -->
                    <table class="table table-hover align-middle bg-white rounded text-center">
                        <thead class="table-success">
                            <tr>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Thương hiệu</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wishlistItems as $item)
                                <tr>
                                    <td style="width: 100px;">
                                        <img src="{{ Storage::url($item->product->thumbnail) }}" alt="Product"
                                            class="img-thumbnail" style="max-width: 50px;">
                                    </td>
                                    <td style="vertical-align: middle">{{ $item->product->category->name }}</td>
                                    <td style="vertical-align: middle">{{ $item->product->brand->name }}</td>
                                    <td style="vertical-align: middle">
                                        <strong class="text-primary">
                                            {{ $item->product->name }}
                                        </strong>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <form method="POST" action="{{ route('wishlist.destroy', $item->id) }}">
                                                {{-- Xoá sản phẩm khỏi wishlist --}}
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm me-2" type="submit"
                                                    onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này khỏi danh sách yêu thích?')">
                                                    <i class="bi bi-x-circle"></i>
                                                    Xoá
                                                </button>
                                            </form>

                                            <a class="btn btn-outline-primary btn-sm"
                                                href="{{ route('detail-product', $item->product->id) }}">
                                                <i class="bi bi-eye"></i>
                                                Chi tiết
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endauth

        <!-- Phân trang -->
        @if (!empty($wishlistItems) && $wishlistItems->hasPages())
            {{ $wishlistItems->links() }}
        @endif
        {{-- Kết thúc phần hiển thị wishlist cho người dùng đã đăng nhập --}}

        {{-- Nếu người dùng chưa đăng nhập -> hiển thị wishlist từ localStorage (nếu có) --}}
        {{-- Phần hiển thị được xử lý bằng js --}}
        @guest
            <div id="wishlist-container">Đang tải...</div>
        @endguest

        <!-- Sản phẩm liên quan -->
        <div class="mt-5">
            <h5 class="mb-4"><i class="bi bi-stars text-warning me-2"></i>Sản phẩm liên quan</h5>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/347/092/products/nike-air-jordan-1-low-gs-553560-141.jpg"
                                class="card-img-top" alt="Product">
                            <div class="card-body">
                                <h6 class="card-title mb-1">Giày chạy bộ nam</h6>
                                <p class="card-text text-primary fw-semibold">$299.00</p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <button class="btn btn-sm btn-outline-success w-100"><i class="bi bi-eye"></i> Xem chi
                                    tiết</button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Wishlist Success Modal -->
    <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="wishlistModalLabel">
                        <i class="bi bi-heart-fill me-2"></i> Thông báo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="bi bi-check-circle-fill text-success display-4 mb-3"></i>
                    <p class="mb-0 fs-5">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Wishlist Error Modal -->
    <div class="modal fade" id="wishlistErrorModal" tabindex="-1" aria-labelledby="wishlistErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="wishlistErrorModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Lỗi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="bi bi-x-circle-fill text-danger display-4 mb-3"></i>
                    <p class="mb-0 fs-5">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (Auth::check())
        {{-- Đồng bộ wishlist từ localStorage lên server khi người dùng đã đăng nhập
             Chỉ chạy khi trang đã tải xong
             và người dùng đã đăng nhập
             và có dữ liệu trong localStorage --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Lấy dữ liệu wishlist từ localStorage
                const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

                // Nếu có dữ liệu wishlist thì gửi yêu cầu đồng bộ lên server
                // Chỉ gửi yêu cầu nếu wishlist không rỗng
                if (wishlist.length > 0) {
                    if (wishlist.length > 0 && !localStorage.getItem('wishlist_synced')) {
                        fetch("{{ route('wishlist.sync') }}", {
                                method: "POST",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    wishlist: JSON.stringify(
                                        wishlist) // <-- truyền chuỗi JSON đúng như controller yêu cầu
                                })
                            })
                            // Chuyển đổi phản hồi từ server sang JSON
                            .then(response => response.json())
                            // Xử lý kết quả trả về từ server
                            .then(data => {
                                if (data.success) {
                                    localStorage.removeItem('wishlist'); // ✅ chỉ xóa khi thật sự lưu được vào DB
                                    localStorage.setItem('wishlist_synced', 'true'); // ✅ gắn cờ đã sync
                                    console.log("✅ Đồng bộ thành công");
                                    location.reload(); // Tải lại trang để cập nhật wishlist
                                } else {
                                    console.warn("⚠️ Lỗi khi đồng bộ wishlist:", data.message);
                                }
                            })
                            .catch(error => {
                                console.error("❌ Lỗi kết nối đồng bộ wishlist:", error);
                            });
                    }
                }
            });
        </script>
    @endif

    {{-- xử lý lưu sản phẩm vào localStorage cho người dùng chưa đăng nhập --}}
    <script>
        // Xử lý hiển thị danh sách yêu thích từ localStorage
        // Chỉ chạy khi người dùng chưa đăng nhập
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy container và dữ liệu từ localStorage
            const container = document.getElementById("wishlist-container");
            const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

            // Kiểm tra nếu wishlist rỗng
            if (wishlist.length === 0) {
                container.innerHTML = "<p>Chưa có sản phẩm nào trong danh sách yêu thích.</p>";
                return;
            }

            // Tạo HTML cho danh sách yêu thích
            let html =
                `<div class="table-responsive mb-4 shadow-sm">
                <table class="table table-hover align-middle bg-white rounded text-center">
                    <thead class="table-success">
                        <tr>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Thương hiệu</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
        `;

            // Duyệt qua từng sản phẩm trong wishlist
            wishlist.forEach(item => {
                html +=
                    `
                    <tbody>
                        <tr>
                            <td style="width: 100px;">
                                <img src="${item.thumbnail}" alt="Product"
                                    class="img-thumbnail" style="max-width: 50px;">
                            </td>
                            <td style="vertical-align: middle">${item.category}</td>
                            <td style="vertical-align: middle">${item.brand}</td>
                            <td style="vertical-align: middle">
                                <strong class="text-primary">
                                    ${item.name}
                                </strong>
                            </td>
                            <td style="vertical-align: middle">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-outline-danger btn-sm me-2" onclick="removeFromWishlist(${item.id})">
                                        <i class="bi bi-x-circle"></i> Xoá
                                    </button>
                                    <a class="btn btn-outline-primary btn-sm" href="/detail-product/${item.id}">
                                        <i class="bi bi-eye"></i> Chi tiết
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                `;
            });

            // Kết thúc HTML
            html += `</table>
        </div>
        `;

            // Chèn HTML vào container
            container.innerHTML = html;
        });

        // Hàm xoá sản phẩm khỏi wishlist
        // Chỉ chạy khi người dùng chưa đăng nhập
        function removeFromWishlist(productId) {
            let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
            wishlist = wishlist.filter(item => item.id !== productId);
            if (confirm("Bạn có chắc muốn xoá sản phẩm này khỏi danh sách yêu thích?")) {
                localStorage.setItem("wishlist", JSON.stringify(wishlist));
                alert("✅ Sản phẩm đã được xoá khỏi danh sách yêu thích.");
                location.reload(); // Tải lại trang để cập nhật danh sách
            }
        }
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('wishlistModal'));
                modal.show();

                // Auto close sau 3 giây
                setTimeout(() => {
                    modal.hide();
                }, 3000);
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('wishlistErrorModal'));
                modal.show();

                // Tự đóng sau 4 giây
                setTimeout(() => {
                    modal.hide();
                }, 4000);
            });
        </script>
    @endif
@endsection
