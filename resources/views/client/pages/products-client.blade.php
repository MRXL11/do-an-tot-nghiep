@extends('client.pages.page-layout')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <!-- Sidebar: Bộ lọc sản phẩm -->
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    {{-- Search --}}
                    <div class="shop__sidebar__search mb-4">
                        <form action="{{ route('products-client') }}" method="GET" class="d-flex">
                            @foreach(request()->query() as $key => $value)
                                @if($key !== 'search')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request()->search }}" class="form-control me-2 rounded-3 shadow-sm">
                            <button type="submit" class="btn btn-primary rounded-3 shadow-sm">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Accordion --}}
                    <div class="shop__sidebar__accordion">
                        <div class="accordion" id="shopSidebarAccordion">
                            {{-- Categories --}}
                            <div class="card border-0 shadow-sm rounded-3 ">
                                <div class="card-heading p-3 bg-light rounded-top-3">
                                    <a data-bs-toggle="collapse" href="#collapseCategories" aria-expanded="true" class="text-dark fw-bold text-uppercase d-flex justify-content-between align-items-center">
                                    <i class="bi bi-list"></i> Danh mục
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </div>
                                <div id="collapseCategories" class="collapse show" data-bs-parent="#shopSidebarAccordion">
                                    <div class="card-body p-3">
                                        <div class="shop__sidebar__categories">
                                            <ul class="list-unstyled">
                                                @foreach($categories as $cat)
                                                    <li class="{{ request()->category == $cat->id ? 'active' : '' }}">
                                                        <a href="{{ route('products-client', array_merge(request()->query(), ['category' => $cat->id])) }}" class="d-block py-2 px-3 rounded-2">
                                                            {{ $cat->name }} ({{ $cat->products_count ?? 0 }})
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Branding --}}
                            <div class="card border-0 shadow-sm rounded-3 ">
                                <div class="card-heading p-3 bg-light rounded-top-3">
                                    <a data-bs-toggle="collapse" href="#collapseBrand" aria-expanded="true" class="text-dark fw-bold text-uppercase d-flex justify-content-between align-items-center">
                                      <i class="bi bi-tags"></i>  Thương hiệu
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </div>
                                <div id="collapseBrand" class="collapse show" data-bs-parent="#shopSidebarAccordion">
                                    <div class="card-body p-3">
                                        <div class="shop__sidebar__brand">
                                            <ul class="list-unstyled">
                                                @foreach($brands as $brand)
                                                    <li class="{{ request()->brand == $brand->id ? 'active' : '' }}">
                                                        <a href="{{ route('products-client', array_merge(request()->query(), ['brand' => $brand->id])) }}" class="d-block py-2 px-3 rounded-2">
                                                            {{ $brand->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Filter Price --}}
                            <div class="card border-0 shadow-sm rounded-3 ">
                                <div class="card-heading p-3 bg-light rounded-top-3">
                                    <a data-bs-toggle="collapse" href="#collapsePrice" aria-expanded="true" class="text-dark fw-bold text-uppercase d-flex justify-content-between align-items-center">
                                     <i class="bi bi-currency-dollar"></i>   Lọc theo giá
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </div>
                                <div id="collapsePrice" class="collapse show" data-bs-parent="#shopSidebarAccordion">
                                    <div class="card-body p-3">
                                        <div class="shop__sidebar__price">
                                            @php
                                                $priceRanges = [
                                                    ['min'=>0,'max'=>50,'label'=>'$0.00 - $50.00'],
                                                    ['min'=>50,'max'=>100,'label'=>'$50.00 - $100.00'],
                                                    ['min'=>100,'max'=>150,'label'=>'$100.00 - $150.00'],
                                                    ['min'=>150,'max'=>200,'label'=>'$150.00 - $200.00'],
                                                    ['min'=>200,'max'=>250,'label'=>'$200.00 - $250.00'],
                                                    ['min'=>250,'max'=>null,'label'=>'250.00+'],
                                                ];
                                            @endphp
                                            <ul class="list-unstyled">
                                                @foreach($priceRanges as $range)
                                                    <li class="{{ request()->price_min == $range['min'] && request()->price_max == $range['max'] ? 'active' : '' }}">
                                                        <a href="{{ route('products-client', array_merge(request()->query(), ['price_min'=>$range['min'],'price_max'=>$range['max']])) }}" class="d-block py-2 px-3 rounded-2">
                                                            {{ $range['label'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Size --}}
                            <div class="card border-0 shadow-sm rounded-3 ">
                                <div class="card-heading p-3 bg-light rounded-top-3">
                                    <a data-bs-toggle="collapse" href="#collapseSize" aria-expanded="true" class="text-dark fw-bold text-uppercase d-flex justify-content-between align-items-center">
                                    <i class="bi bi-aspect-ratio"></i>  Kích cỡ
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </div>
                                <div id="collapseSize" class="collapse show" data-bs-parent="#shopSidebarAccordion">
                                    <div class="card-body p-3">
                                        <div class="shop__sidebar__size">
                                            @foreach($sizes as $size)
                                                <label for="size-{{ $size }}" class="btn btn-outline-dark rounded-3 m-1 {{ request()->size == $size ? 'active' : '' }}">
                                                    {{ $size }}
                                                    <input type="radio" name="size" id="size-{{ $size }}"
                                                        onchange="location.href='{{ route('products-client', array_merge(request()->query(), ['size'=>$size])) }}'" {{ request()->size == $size ? 'checked' : '' }}>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Colors --}}
                            <div class="card border-0 shadow-sm rounded-3 ">
                                <div class="card-heading p-3 bg-light rounded-top-3">
                                    <a data-bs-toggle="collapse" href="#collapseColor" aria-expanded="true" class="text-dark fw-bold text-uppercase d-flex justify-content-between align-items-center">
                                    <i class="bi bi-palette"></i>  Màu sắc
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </div>
                                <div id="collapseColor" class="collapse show" data-bs-parent="#shopSidebarAccordion">
                                    <div class="card-body p-3">
                                        <div class="shop__sidebar__color">
                                            @foreach($colors as $color)
                                                <label class="c-{{ $loop->iteration }} {{ request()->color == $color ? 'active' : '' }}" for="color-{{ $color }}">
                                                    <input type="radio" name="color" id="color-{{ $color }}"
                                                        onchange="location.href='{{ route('products-client', array_merge(request()->query(), ['color'=>$color])) }}'" {{ request()->color == $color ? 'checked' : '' }}>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tags --}}     {{-- chưa có tags --}}
                            {{-- <div class="card border-0 shadow-sm rounded-3 ">
                                <div class="card-heading p-3 bg-light rounded-top-3">
                                    <a data-bs-toggle="collapse" href="#collapseTags" aria-expanded="true" class="text-dark fw-bold text-uppercase d-flex justify-content-between align-items-center">
                                    <i class="bi bi-badge"></i>  Tags
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </div>
                                <div id="collapseTags" class="collapse show" data-bs-parent="#shopSidebarAccordion">
                                    <div class="card-body p-3">
                                        <div class="shop__sidebar__tags">
                                       
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="col-lg-9">
                <!-- Sắp xếp -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3><i class="bi bi-list me-2"></i>Danh sách sản phẩm</h3>
                    <div class="btn-group align-items-center hover-zoom">
                        <a href="{{ route('products-client', array_merge(request()->query(), ['sort' => 'newest'])) }}"
                            class="btn btn-outline-primary {{ request()->sort == 'newest' || !request()->sort ? 'active' : '' }}"><i
                                class="bi bi-sort-alpha-down"></i> Mới nhất</a>
                        <a href="{{ route('products-client', array_merge(request()->query(), ['sort' => 'sales'])) }}"
                            class="btn btn-outline-primary {{ request()->sort == 'sales' ? 'active' : '' }}"><i
                                class="bi bi-bag-check"></i> Bán chạy</a>
                        <a href="{{ route('products-client', array_merge(request()->query(), ['sort' => 'likes'])) }}"
                            class="btn btn-outline-primary {{ request()->sort == 'likes' ? 'active' : '' }}"><i
                                class="bi bi-heart"></i> lượt thích</a>
                        <a href="{{ route('products-client', array_merge(request()->query(), ['sort' => 'discount'])) }}"
                            class="btn btn-outline-primary {{ request()->sort == 'discount' ? 'active' : '' }}"><i
                                class="bi bi-star"></i> Đánh giá</a>
                    </div>
                </div>

                <!-- Hiển thị thông tin bộ lọc hiện tại -->
                <div class="mb-4">
                    @php
                        $filters = [];
                        if (request()->has('category') && request()->category) {
                            $category = $categories->firstWhere('id', request()->category);
                            $filters[] = 'Danh mục: ' . ($category ? $category->name : 'Không xác định');
                        }
                        if (request()->has('brand') && request()->brand) {
                            $brand = $brands->firstWhere('id', request()->brand);
                            $filters[] = 'Thương hiệu: ' . ($brand ? $brand->name : 'Không xác định');
                        }
                        if (request()->has('size') && request()->size) {
                            $filters[] = 'Kích cỡ: ' . request()->size;
                        }
                        if (request()->has('color') && request()->color) {
                            $filters[] = 'Màu sắc: ' . request()->color;
                        }
                        if (request()->has('price_min') && request()->price_min !== null) {
                            $filters[] =
                                'Giá: ' .
                                number_format(request()->price_min) .
                                ' đ - ' .
                                (request()->price_max ? number_format(request()->price_max) . ' đ' : '+');
                        }
                        if ($searchTerm) {
                            $filters[] = 'Tìm kiếm: ' . $searchTerm;
                        }
                    @endphp
                    @if (!empty($filters))
                        <p class="text-muted">Lọc theo: {{ implode(', ', $filters) }}</p>
                        <a href="{{ route('products-client') }}" class="btn btn-sm btn-outline-danger">Xóa bộ lọc</a>
                    @endif
                    @if ($noResults)
                        <div class="alert alert-warning mt-3">
                            Không tìm thấy sản phẩm nào phù hợp. <a href="{{ route('products-client') }}"
                                class="alert-link">Xóa bộ lọc</a> để xem tất cả sản phẩm.
                        </div>
                    @endif
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border">
                                <div class="position-relative py-2">
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                        class="card-img-top img-fluid px-2" alt="{{ $product->name }}"
                                        style="height: 250px; object-fit: cover;">
                                    </img>
                                    @php
                                        /* lấy data sản phẩm để truyền vào view,
                                         sau đó dùng JS để xử lý thêm vào localStorage để lưu wishlist cho user chưa đăng nhập */
                                        $productData = [
                                            'id' => $product->id,
                                            'status' => $product->status,
                                        ];
                                    @endphp
                                    {{-- Hiển thị nút yêu thích theo trạng thái người dùng hiện tại --}}
                                    @if (Auth::check())
                                        <form action="{{ route('wishlist.store') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button class="btn btn-danger position-absolute top-0 end-0 m-2"
                                                type="submit"><i class="bi bi-heart"></i></button>
                                        </form>
                                    @else
                                        {{-- Hiển thị nút yêu thích cho khách chưa đăng nhập --}}
                                        <button class="btn btn-danger position-absolute top-0 end-0 m-2 add-to-wishlist"
                                            data-product='@json($productData)'>
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    @endif
                                    @if ($product->variants->whereNotNull('discount_price')->count() > 0)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2"
                                            style="z-index:1;">Sale</span>
                                    @endif
                                    @if ($product->variants->where('is_new', true)->count() > 0)
                                        <span class="badge bg-success position-absolute"
                                            style="top: 2.5rem; right: 0.5rem; z-index:1;">Mới</span>
                                    @endif
                                </div>
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                                    <div class="d-flex flex-column align-items-center gap-2 ">
                                        <div class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $product->reviews->avg('rating'))
                                                    <i class="bi bi-star-fill"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="text-muted">
                                            <i class="bi bi-basket3"></i> {{ $product->sales_count }} bán
                                        </div>
                                        <div class="text-muted">
                                            <i class="bi bi-heart"></i> {{ $product->likes_count }} yêu thích
                                        </div>
                                    </div>
                                    @if ($product->variants->whereNotNull('discount_price')->count() > 0)
                                        <p class="text-danger fw-bold mb-0">
                                            {{ number_format($product->variants->min('discount_price')) }} đ</p>
                                        <p class="text-muted text-decoration-line-through">
                                            {{ number_format($product->variants->min('price')) }} đ</p>
                                    @else
                                        <p class="text-danger fw-bold mb-3">
                                            {{ number_format($product->variants->min('price')) }} đ</p>
                                    @endif
                                    <div class="d-flex gap-2 mt-auto justify-content-center">
                                        <a href="{{ route('detail-product', ['id' => $product->id]) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i> Xem
                                        </a>
                                        <a href="" class="btn btn-outline-danger"><i class="bi bi-cart"></i> Thêm</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted">Không có sản phẩm nào.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="wishlistModalLabel">
                        <i class="bi bi-heart-fill me-2"></i> Thông báo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="bi bi-check-circle-fill text-success display-4 mb-3"></i>
                    <p class="mb-0 fs-5">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="wishlistErrorModal" tabindex="-1" aria-labelledby="wishlistErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="wishlistErrorModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Lỗi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="bi bi-x-circle-fill text-danger display-4 mb-3"></i>
                    <p class="mb-0 fs-5">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        /* General card styling for product cards */
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .card:hover .btn-outline-primary {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .card:hover .btn-outline-danger {
            background-color: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        /* Sidebar-specific styling */
        .shop__sidebar {
            /* padding: 20px; */
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .shop__sidebar__search form {
            position: relative;
        }

        .shop__sidebar__search input {
            border: 1px solid #dee2e6;
            border-radius: 25px;
            padding:0px 20px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .shop__sidebar__search input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        .shop__sidebar__search button {
            border-radius: 25px;
            padding: 0 20px;
            background: #007bff;
            border: none;
            transition: background-color 0.3s;
        }

        .shop__sidebar__search button:hover {
            background: #0056b3;
        }

        .shop__sidebar__accordion .card {
            border: none;
            border-radius: 10px;
            margin-bottom: ;
            overflow: hidden;
        }

        .shop__sidebar__accordion .card-heading {
            background: #f8f9fa;
            padding: ;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
        }

        .shop__sidebar__accordion .card-heading a {
            color: #333;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .shop__sidebar__accordion .card-heading a:not(.collapsed) {
            color: #007bff;
        }

        .shop__sidebar__accordion .card-body {
            padding: ;
            border-top: 1px solid #e9ecef;
        }

        .shop__sidebar__categories ul,
        .shop__sidebar__price ul,
        .shop__sidebar__brand ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .shop__sidebar__categories ul li,
        .shop__sidebar__price ul li,
        .shop__sidebar__brand ul li {
            margin-bottom: 5px;
        }

        .shop__sidebar__categories ul li a,
        .shop__sidebar__price ul li a,
        .shop__sidebar__brand ul li a {
            color: #495057;
            font-size: 14px;
            text-decoration: none;
            display: block;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .shop__sidebar__categories ul li.active a,
        .shop__sidebar__price ul li.active a,
        .shop__sidebar__brand ul li.active a {
            background: #e7f1ff;
            color: #007bff;
            font-weight: 600;
        }

        .shop__sidebar__categories ul li a:hover,
        .shop__sidebar__price ul li a:hover,
        .shop__sidebar__brand ul li a:hover {
            background: #f1f5f8;
            color: #007bff;
        }

        .shop__sidebar__size {
            padding-top: 10px;
        }

        .shop__sidebar__size label {
            font-size: 14px;
            font-weight: 500;
            border: 1px solid #dee2e6;
            padding: 8px ;
            margin-right: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 25px;
        }

        .shop__sidebar__size label.active,
        .shop__sidebar__size label:hover {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .shop__sidebar__size label input {
            display: none;
        }

        .shop__sidebar__color {
            padding-top: 10px;
        }

        .shop__sidebar__color label {
            height: 32px;
            width: 32px;
            border-radius: 50%;
            margin-right: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            position: relative;
            display: inline-block;
            transition: transform 0.3s;
        }

        .shop__sidebar__color label.active:after,
        .shop__sidebar__color label:hover:after {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border: 2px solid #007bff;
            border-radius: 50%;
        }

        .shop__sidebar__color label input {
            display: none;
        }

        .shop__sidebar__color label.c-1 { background: #0b090c; }
        .shop__sidebar__color label.c-2 { background: #20315f; }
        .shop__sidebar__color label.c-3 { background: #f1af4d; }
        .shop__sidebar__color label.c-4 { background: #636068; }
        .shop__sidebar__color label.c-5 { background: #57594d; }
        .shop__sidebar__color label.c-6 { background: #e8bac4; }
        .shop__sidebar__color label.c-7 { background: #d6c1d7; }
        .shop__sidebar__color label.c-8 { background: #ed1c24; }
        .shop__sidebar__color label.c-9 { background: #ffffff; }

        .shop__sidebar__tags {
            padding-top: 10px;
        }

        .shop__sidebar__tags a {
            color: #404040;
            font-size: 13px;
            font-weight: 600;
            background: #f1f5f8;
            padding: 6px ;
            border-radius: 25px;
            text-decoration: none;
            margin-right: 8px;
            margin-bottom: 8px;
            display: inline-block;
            transition: all 0.3s;
        }

        .shop__sidebar__tags a:hover {
            background: #007bff;
            color: #fff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .shop__sidebar {
                padding: ;
            }

            .shop__sidebar__search input {
                font-size: 13px;
                padding: 8px ;
            }

            .shop__sidebar__search button {
                padding: 0 ;
            }

            .shop__sidebar__accordion .card-heading {
                font-size: 14px;
            }

            .shop__sidebar__categories ul li a,
            .shop__sidebar__price ul li a,
            .shop__sidebar__brand ul li a {
                font-size: 13px;
                padding: 6px 10px;
            }

            .shop__sidebar__size label {
                font-size: 13px;
                padding: 6px 12px;
            }

            .shop__sidebar__color label {
                height: 28px;
                width: 28px;
            }
        }
    </style>

    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script>document.addEventListener('DOMContentLoaded', function() {
    const accordionIds = ['collapseCategories', 'collapseBrand', 'collapsePrice', 'collapseSize', 'collapseColor', 'collapseTags'];
    
    // Lấy trạng thái từ localStorage
    let accordionStates = JSON.parse(localStorage.getItem('accordionStates')) || {};
    
    // Đặt trạng thái ban đầu cho các accordion
    accordionIds.forEach(id => {
        const collapseElement = document.getElementById(id);
        if (collapseElement) {
            if (accordionStates.hasOwnProperty(id)) {
                if (accordionStates[id] === false) {
                    collapseElement.classList.remove('show');
                } else {
                    collapseElement.classList.add('show');
                }
            } else {
                // Nếu không có trạng thái, để mặc định là mở
                collapseElement.classList.add('show');
            }
        }
    });
    
    // Lắng nghe sự kiện show và hide của các accordion
    accordionIds.forEach(id => {
        const collapseElement = document.getElementById(id);
        if (collapseElement) {
            collapseElement.addEventListener('show.bs.collapse', function() {
                accordionStates[id] = true;
                localStorage.setItem('accordionStates', JSON.stringify(accordionStates));
            });
            collapseElement.addEventListener('hide.bs.collapse', function() {
                accordionStates[id] = false;
                localStorage.setItem('accordionStates', JSON.stringify(accordionStates));
            });
        }
    });
});</script>
@endsection

@section('scripts')
    @if (!Auth::check())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll('.add-to-wishlist').forEach(button => {
                    button.addEventListener('click', function() {
                        const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
                        const product = JSON.parse(this.dataset.product);
                        const productId = product.id;

                        fetch(`/wishlist/check/product/${productId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Không tìm thấy sản phẩm hoặc lỗi máy chủ.");
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (!data.status || data.status !== 'active') {
                                    alert("❌ Sản phẩm này hiện không còn kinh doanh và không thể thêm vào wishlist.");
                                    window.location.href = "{{ route('home') }}";
                                    return;
                                }

                                const product = {
                                    id: parseInt(productId),
                                    status: data.status
                                };

                                if (!wishlist.find(item => item.id === product.id)) {
                                    wishlist.push(product);
                                    localStorage.setItem("wishlist", JSON.stringify(wishlist));
                                    alert("✅ Đã thêm vào danh sách yêu thích!");
                                } else {
                                    alert("📌 Sản phẩm đã có trong wishlist.");
                                }

                                location.reload();
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
                setTimeout(() => {
                    modal.hide();
                }, 4000);
            });
        </script>
    @endif
    
@endsection