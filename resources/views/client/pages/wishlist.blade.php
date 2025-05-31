@extends('client.pages.page-layout')
@section('content')
<div class="container">
    <h4 class="mb-4"><i class="bi bi-heart-fill text-danger me-2"></i>Sản phẩm yêu thích của bạn</h4>

    <!-- Table yêu thích -->
    <div class="table-responsive mb-4 shadow-sm">
        <table class="table table-hover align-middle bg-white rounded  text-center">
            <thead class="table-success">
                <tr>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Tên sản phẩm</th>
                     <th scope="col">Size</th>
                    <th scope="col">Màu sắc</th>
                    <th scope="col">Danh mục</th>
                    <th scope="col" >Giá</th>
                    <th scope="col" wigth="150px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td style="width: 100px;">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp"
                             alt="Product" class="img-thumbnail" style="max-width: 50px;">
                    </td>
                    <td>Áo thun thể thao</td>
                    <td>M</td>
                    <td>Đen</td>
                    <td>Thời trang</td>
                    <td><strong class="text-primary">$199.00</strong></td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm me-2"><i class="bi bi-x-circle"></i> Xóa</button>
                        <button class="btn btn-outline-success btn-sm"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</button>
                        <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye"></i> Xem chi tiết</button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link">Trước</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Tiếp</a></li>
        </ul>
    </nav>

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
                        <button class="btn btn-sm btn-outline-success w-100"><i class="bi bi-eye"></i> Xem chi tiết</button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
