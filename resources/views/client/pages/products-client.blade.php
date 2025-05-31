@extends('client.pages.page-layout')

@section('content')

    <div class="container">
        <div class="row ">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="mb-4">
                    <form class="d-flex" action="#">
                        <input type="text" class="form-control" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Accordion Filters -->
                <div class="accordion" id="productFilters">
                    <!-- Categories -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCategories">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories">
                                Danh mục
                            </button>
                        </h2>
                        <div id="collapseCategories" class="accordion-collapse collapse show" data-bs-parent="#productFilters">
                            <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><a href="#">Nam</a></li>
                                    <li class="list-group-item"><a href="#">Nữ</a></li>
                                    <li class="list-group-item"><a href="#">Túi xách</a></li>
                                    <li class="list-group-item"><a href="#">Giày dép</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingBrand">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrand">
                                Thương hiệu
                            </button>
                        </h2>
                        <div id="collapseBrand" class="accordion-collapse collapse" data-bs-parent="#productFilters">
                            <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><a href="#">Gucci</a></li>
                                    <li class="list-group-item"><a href="#">Nike</a></li>
                                    <li class="list-group-item"><a href="#">Adidas</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPrice">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice">
                                Giá
                            </button>
                        </h2>
                        <div id="collapsePrice" class="accordion-collapse collapse show" data-bs-parent="#productFilters">
                            <div class="accordion-body">
                                <div class="shop__sidebar__price">
                                    <ul class="list-unstyled">
                                        <li><a class="" href="#">0 đ - 50.000 đ</a></li>
                                        <li><a href="#">50.000 đ - 100.000 đ</a></li>
                                        <li><a href="#">100.000 đ - 150.000 đ</a></li>
                                        <li><a href="#">150.000 đ - 200.000 đ</a></li>
                                        <li><a href="#">200.000 đ - 250.000 đ</a></li>
                                        <li><a href="#">250.000 đ+</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSize">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSize">
                                Kích cỡ
                            </button>
                        </h2>
                        <div id="collapseSize" class="accordion-collapse collapse" data-bs-parent="#productFilters">
                            <div class="accordion-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm">M</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">L</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">XL</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">XXL</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">2XL</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Màu sắc -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingColor">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseColor">
                                Màu sắc
                            </button>
                        </h2>
                        <div id="collapseColor" class="accordion-collapse collapse" data-bs-parent="#productFilters">
                            <div class="accordion-body d-flex flex-wrap gap-2">
                                <span class="d-inline-block rounded-circle bg-dark" style="width: 20px; height: 20px;"></span>
                                <span class="d-inline-block rounded-circle bg-primary" style="width: 20px; height: 20px;"></span>
                                <span class="d-inline-block rounded-circle bg-danger" style="width: 20px; height: 20px;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
            <div class="row">
                <div class="col-12 mb-4">
                    <h2 class="text-center">Danh mục sản phẩm A</h2>
                </div>
                <!-- Fake Product 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border">
                        <div class="position-relative">
                            <img src="https://cf.shopee.vn/file/18e32978f46350820581cee0087eff52" class="card-img-top img-fluid" alt="Sản phẩm 1" style="height: 250px; object-fit: cover;">
                            <button class="btn btn-light position-absolute top-0 end-0 m-2 btn btn-outline-danger"><i class="bi bi-heart"></i></button>
                        </div>
                <div class="card-body text-center d-flex flex-column">
                <h5 class="card-title">Áo thun nam</h5>

                <!-- Phần đánh giá sao + lượt bán + yêu thích theo cột -->
                <div class="d-flex flex-column align-items-center gap-2 mb-3">
                    <!-- Đánh giá sao -->
                    <div class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    </div>

                    <!-- Số lượt bán -->
                    <div class="text-muted">
                    <i class="bi bi-basket3"></i> 150 bán
                    </div>

                    <!-- Số lượt yêu thích -->
                    <div class="text-muted">
                    <i class="bi bi-heart"></i> 320 yêu thích
                    </div>
                </div>

                <p class="text-danger fw-bold mb-3">199.000 đ</p>

                <div class="d-flex gap-2 mt-auto justify-content-center">
                    <a href="#" class="btn btn-outline-primary"><i class="bi bi-eye"></i> Xem</a>
                    <a href="#" class="btn btn-outline-danger"><i class="bi bi-cart"></i> Thêm</a>
                </div>
                </div>


                    </div>
                </div>

                <!-- Fake Product 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border">
                        <div class="position-relative">
                            <img src="https://trungsneaker.com/wp-content/uploads/2022/12/giay-nike-court-vision-mid-smoke-grey-dn3577-002-44-1020x680.jpg" class="card-img-top img-fluid" alt="Sản phẩm 2" style="height: 250px; object-fit: cover;">
                            <button class="btn btn-light position-absolute top-0 end-0 m-2 btn btn-outline-danger"><i class="bi bi-heart"></i></button>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title">Giày thể thao</h5>
                            <!-- Phần đánh giá sao + lượt bán + yêu thích theo cột -->
                <div class="d-flex flex-column align-items-center gap-2 mb-3">
                    <!-- Đánh giá sao -->
                    <div class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    </div>

                    <!-- Số lượt bán -->
                    <div class="text-muted">
                    <i class="bi bi-basket3"></i> 150 bán
                    </div>

                    <!-- Số lượt yêu thích -->
                    <div class="text-muted">
                    <i class="bi bi-heart"></i> 320 yêu thích
                    </div>
                </div>

                <p class="text-danger fw-bold mb-3">199.000 đ</p>

                <div class="d-flex gap-2 mt-auto justify-content-center">
                    <a href="#" class="btn btn-outline-primary"><i class="bi bi-eye"></i> Xem</a>
                    <a href="#" class="btn btn-outline-danger"><i class="bi bi-cart"></i> Thêm</a>
                </div>
                        </div>
                    </div>
                </div>

                <!-- Fake Product 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border">
                        <div class="position-relative">
                            <img src="https://babuhandmade.com/wp-content/uploads/2018/09/tui-xach-nu-da-bo-handmade-4.jpg" class="card-img-top img-fluid" alt="Sản phẩm 3" style="height: 250px; object-fit: cover;">
                            <button class="btn btn-light position-absolute top-0 end-0 m-2 btn btn-outline-danger"><i class="bi bi-heart"></i></button>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title">Túi xách</h5>
                            <!-- Phần đánh giá sao + lượt bán + yêu thích theo cột -->
                <div class="d-flex flex-column align-items-center gap-2 mb-3">
                    <!-- Đánh giá sao -->
                    <div class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    </div>

                    <!-- Số lượt bán -->
                    <div class="text-muted">
                    <i class="bi bi-basket3"></i> 150 bán
                    </div>

                    <!-- Số lượt yêu thích -->
                    <div class="text-muted">
                    <i class="bi bi-heart"></i> 320 yêu thích
                    </div>
                </div>

                <p class="text-danger fw-bold mb-3">199.000 đ</p>

                <div class="d-flex gap-2 mt-auto justify-content-center">
                    <a href="#" class="btn btn-outline-primary"><i class="bi bi-eye"></i> Xem</a>
                    <a href="#" class="btn btn-outline-danger"><i class="bi bi-cart"></i> Thêm</a>
                </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>



@endsection
