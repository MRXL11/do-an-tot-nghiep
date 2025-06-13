@extends('client.pages.page-layout')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Hình ảnh sản phẩm (carousel) -->
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow">
                        <div class="carousel-item active">
                            <img src="{{ asset('assets/images/single-product-01.jpg') }}" class="d-block w-100"
                                alt="Ảnh chính">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('assets/images/single-product-02.jpg') }}" class="d-block w-100"
                                alt="Ảnh phụ">
                        </div>
                        <!-- Thêm ảnh nếu có -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="mb-3">
                    <img src="{{ asset('assets/images/single-product-01.jpg') }}" class="img-fluid rounded mb-2"
                        alt="Main product image">
                </div>
            </div>

            <!-- Chi tiết sản phẩm -->
            <div class="col-md-6">
                <h2>Giày thể thao</h2>
                <p class="text-muted">Mã sản phẩm: 421987</p>
                <h4 class="text-danger fw-bold">$75.00</h4>

                <p class="mt-3">
                    Áo khoác nam với thiết kế tối giản, chất liệu vải nhẹ, thoáng khí, giữ ấm tốt. Phù hợp sử dụng hàng ngày
                    hoặc khi đi du lịch.
                </p>

                <!-- Màu sắc -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Màu sắc:</label><br>
                    <button class="btn btn-outline-success btn-sm me-2">Xanh Rêu</button>
                    <button class="btn btn-outline-dark btn-sm me-2">Đen</button>
                    <button class="btn btn-outline-secondary btn-sm">Xám</button>
                </div>

                <!-- Kích thước -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kích thước:</label>
                    <select class="form-select w-auto">
                        <option>Chọn size</option>
                        <option>S</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                    </select>
                </div>

                <!-- Số lượng -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Số lượng:</label>
                    <input type="number" class="form-control w-auto" value="1" min="1">
                </div>

                <!-- Hành động -->
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-outline-success btn-lg">
                        <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                    </button>

                    @if (Auth::check())
                        <form action="{{ route('wishlist.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-outline-danger btn-lg">
                                <i class="bi bi-heart-fill me-1"></i> Yêu thích
                            </button>
                        </form>
                    @else
                        <button class="btn btn-outline-danger btn-lg add-to-wishlist"
                            data-product='@json($productData)'>
                            <i class="bi bi-heart-fill me-1"></i>Yêu thích
                        </button>
                    @endif
                </div>


                <!-- Chính sách -->
                <div class="mt-4 border-top pt-3">
                    <p><i class="bi bi-truck me-2"></i> Giao hàng tiêu chuẩn 2-4 ngày</p>
                    <p><i class="bi bi-arrow-repeat me-2"></i> Đổi trả trong 30 ngày</p>
                </div>
            </div>
        </div>

        <!-- Bình luận -->
        <div class="row mt-5">
            <div class="col-lg-6">
                <h4><i class="bi bi-chat-left-text me-2"></i>Đánh giá khách hàng</h4>

                <div class="border rounded p-3 mb-3">
                    <strong>John Doe</strong> <span class="text-muted small">- 20/01/2025</span>
                    <p class="mb-0">Sản phẩm chất lượng, giao hàng nhanh. Rất hài lòng!</p>
                </div>
                <div class="border rounded p-3 mb-3">
                    <strong>Jane Smith</strong> <span class="text-muted small">- 18/01/2025</span>
                    <p class="mb-0">Đúng như mô tả, đóng gói kỹ. Sẽ mua lại.</p>
                </div>
            </div>

            <!-- Form bình luận -->
            <div class="col-lg-6">
                <h5><i class="bi bi-pencil-square me-2"></i>Viết đánh giá</h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Tên của bạn</label>
                        <input type="text" class="form-control" placeholder="Nguyễn Văn A" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea class="form-control" rows="4" placeholder="Nhận xét sản phẩm..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark"><i class="bi bi-send me-1"></i>Gửi bình luận</button>
                </form>
            </div>
        </div>

        <!-- Sản phẩm liên quan -->
        <div class="mt-5">
            <h4 class="mb-4"><i class="bi bi-stars text-warning me-2"></i>Sản phẩm liên quan</h4>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="{{ asset('assets/images/single-product-01.jpg') }}" class="card-img-top"
                                alt="Product">
                            <div class="card-body">
                                <h6 class="card-title">Áo Polo Nam</h6>
                                <p class="text-primary fw-semibold">$45.00</p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="#" class="btn btn-outline-primary w-100 btn-sm"><i class="bi bi-eye"></i>
                                    Xem
                                    chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Danh mục liên quan -->
        <div class="mt-5">
            <h4 class="mb-3"><i class="bi bi-tags me-2"></i>Danh mục liên quan</h4>
            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-tag"></i> Áo khoác</a>
                <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-tag"></i> Đồ thu đông</a>
                <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-tag"></i> Thời trang nam</a>
            </div>
        </div>
    </div>

    <!-- Wishlist Feedback Modal -->
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
    @if (!Auth::check())
        <script>
            // Thêm sự kiện click cho nút "Thêm vào danh sách yêu thích"
            // Chỉ chạy khi người dùng chưa đăng nhập
            document.addEventListener("DOMContentLoaded", function() {
                // Lấy tất cả các nút "Thêm vào danh sách yêu thích"
                document.querySelectorAll('.add-to-wishlist').forEach(button => {
                    // Thêm sự kiện click cho từng nút
                    button.addEventListener('click', function() {
                        const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

                        // 🔍 Lấy ID sản phẩm từ URL hiện tại
                        const productId = window.location.pathname.split("/").pop();

                        // 🟡 Gửi request lên server để kiểm tra trạng thái thật của sản phẩm
                        fetch(`/wishlist/check/product/${productId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Không tìm thấy sản phẩm hoặc lỗi máy chủ.");
                                }
                                return response.json();
                            })
                            .then(data => {
                                // ❌ Nếu sản phẩm không tồn tại hoặc không còn active
                                if (!data.status || data.status !== 'active') {
                                    alert(
                                        "❌ Sản phẩm này hiện không còn kinh doanh và không thể thêm vào wishlist."
                                    );
                                    window.location.href = "{{ route('home') }}";
                                    return;
                                }

                                // ✅ Nếu sản phẩm hợp lệ, tiến hành thêm vào wishlist
                                const product = {
                                    id: parseInt(productId),
                                    status: data.status
                                };

                                if (!wishlist.find(item => item.id === product.id)) {
                                    wishlist.push(product);
                                    localStorage.setItem("wishlist", JSON.stringify(wishlist));
                                    alert("✅ Đã thêm vào danh sách yêu thích!");
                                    location.reload();
                                } else {
                                    alert("📌 Sản phẩm đã có trong wishlist.");
                                    location.reload();
                                }
                            })
                            .catch(error => {
                                console.error("❌ Lỗi kiểm tra trạng thái sản phẩm:", error);
                                alert("⚠️ Không thể kiểm tra trạng thái sản phẩm lúc này.");
                            });
                    });
                });
            });
        </script>
    @endif

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
