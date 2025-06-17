@extends('client.pages.page-layout')

@section('content')
<div class="container">
    <div class="row">
        <!-- Hình ảnh sản phẩm (carousel) -->
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-inner rounded shadow">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/' . $product->image) }}" class="d-block w-100" alt="{{ $product->name }}">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                </button>
            </div>

            <div class="mb-3">
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded mb-2" alt="{{ $product->name }}">
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">Mã sản phẩm: {{ $product->id }}</p>
            <h4 class="text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</h4>

            <p class="mt-3">{{ $product->description }}</p>

            <!-- Màu sắc (giả lập nếu chưa có dữ liệu thực) -->
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
            <div class="d-grid gap-2 d-md-block">
                <button class="btn btn-outline-success btn-lg me-2"><i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ</button>
                <button class="btn btn-outline-danger btn-lg"><i class="bi bi-heart-fill me-1"></i>Yêu thích</button>
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
                    <img src="{{ asset('assets/images/single-product-01.jpg') }}" class="card-img-top" alt="Product">
                    <div class="card-body">
                        <h6 class="card-title">Áo Polo Nam</h6>
                        <p class="text-primary fw-semibold">45.000 đ</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="#" class="btn btn-outline-primary w-100 btn-sm"><i class="bi bi-eye"></i> Xem chi tiết</a>
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
            <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-tag"></i> {{ $product->category->name ?? 'Thời trang' }}</a>
        </div>
    </div>
</div>
@endsection
