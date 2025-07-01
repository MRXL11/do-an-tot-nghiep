@extends('client.pages.page-layout')

@section('content')
    <div class="container pt-2">
        <div class="row">
            <!-- Sidebar: Bộ lọc sản phẩm -->
            <div class="col-lg-3">
                <!-- Tìm kiếm -->
                <div class="mb-4">
                    <form class="d-flex" action="{{ route('products-client') }}" method="GET">
                        @foreach (request()->query() as $key => $value)
                            @if ($key != 'search')
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..."
                            value="{{ request()->search }}">
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Bộ lọc -->
                <div class="accordion text-center" id="productFilters">
                    <!-- Danh mục -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCategories">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseCategories">
                                <i class="bi bi-list me-2"></i> Danh mục
                            </button>
                        </h2>
                        <div id="collapseCategories" class="accordion-collapse collapse show"
                            data-bs-parent="#productFilters">
                            <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item {{ request()->is('products-client') ? 'active' : '' }}">
                                        <a href="{{ route('products-client') }}">Tất cả</a>
                                        @if (request()->is('products-client'))
                                            <i class="bi bi-check-circle ms-2"></i>
                                        @endif
                                    </li>
                                    @foreach ($categories as $category)
                                        <li class="list-group-item {{ request()->is('products-client/' . $category->slug) ? 'active' : '' }}">
                                            <a href="{{ route('products-client', $category->slug) }}">{{ $category->name }}</a>
                                            @if (request()->is('products-client/' . $category->slug))
                                                <i class="bi bi-check-circle ms-2"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Thương hiệu -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingBrand">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseBrand">
                                <i class="bi bi-tags me-2"></i> Thương hiệu
                            </button>
                        </h2>
                        <div id="collapseBrand" class="accordion-collapse collapse" data-bs-parent="#productFilters">
                            <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item {{ !request()->brand ? 'active' : '' }}">
                                        <a href="{{ route('products-client', array_merge(request()->except('brand'))) }}">Tất
                                            cả</a>
                                        @if (!request()->brand)
                                            <i class="bi bi-check-circle ms-2"></i>
                                        @endif
                                    </li>
                                    @foreach ($brands as $brand)
                                        <li class="list-group-item {{ request()->brand == $brand->id ? 'active' : '' }}">
                                            <a
                                                href="{{ route('products-client', array_merge(request()->query(), ['brand' => $brand->id])) }}">{{ $brand->name }}</a>
                                            @if (request()->brand == $brand->id)
                                                <i class="bi bi-check-circle ms-2"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Giá -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPrice">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePrice">
                                <i class="bi bi-cash me-2"></i> Giá
                            </button>
                        </h2>
                        <div id="collapsePrice" class="accordion-collapse collapse" data-bs-parent="#productFilters">
                            <div class="accordion-body text-start">
                                @php
                                    $priceRanges = [
                                        ['min' => 0, 'max' => 50000, 'label' => '0 đ - 50.000 đ'],
                                        ['min' => 50000, 'max' => 100000, 'label' => '50.000 đ - 100.000 đ'],
                                        ['min' => 100000, 'max' => 150000, 'label' => '100.000 đ - 150.000 đ'],
                                        ['min' => 150000, 'max' => 200000, 'label' => '150.000 đ - 200.000 đ'],
                                        ['min' => 200000, 'max' => 250000, 'label' => '200.000 đ - 250.000 đ'],
                                        ['min' => 250000, 'max' => null, 'label' => '250.000 đ+'],
                                    ];
                                @endphp
                                <ul class="list-unstyled">
                                    <li class="{{ !request()->price_min && !request()->price_max ? 'active' : '' }}">
                                        <a
                                            href="{{ route('products-client', array_merge(request()->except(['price_min', 'price_max']))) }}">Tất
                                            cả</a>
                                        @if (!request()->price_min && !request()->price_max)
                                            <i class="bi bi-check-circle ms-2"></i>
                                        @endif
                                    </li>
                                    @foreach ($priceRanges as $range)
                                        <li
                                            class="{{ request()->price_min == $range['min'] && request()->price_max == $range['max'] ? 'active' : '' }}">
                                            <a
                                                href="{{ route('products-client', array_merge(request()->query(), ['price_min' => $range['min'], 'price_max' => $range['max']])) }}">{{ $range['label'] }}</a>
                                            @if (request()->price_min == $range['min'] && request()->price_max == $range['max'])
                                                <i class="bi bi-check-circle ms-2"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Kích cỡ -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSize">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSize">
                                <i class="bi bi-arrows-expand me-2"></i> Kích cỡ
                            </button>
                        </h2>
                        <div id="collapseSize" class="accordion-collapse collapse" data-bs-parent="#productFilters">
                            <div class="accordion-body d-flex flex-wrap gap-2">
                                <a href="{{ route('products-client', array_merge(request()->except('size'))) }}"
                                    class="btn btn-outline-primary btn-sm {{ !request()->size ? 'active' : '' }}">Tất
                                    cả</a>
                                @foreach ($sizes as $size)
                                    <a href="{{ route('products-client', array_merge(request()->query(), ['size' => $size])) }}"
                                        class="btn btn-outline-primary btn-sm {{ request()->size == $size ? 'active' : '' }}">{{ $size }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Màu sắc -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingColor">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseColor">
                                <i class="bi bi-palette me-2"></i> Màu sắc
                            </button>
                        </h2>
                        <div id="collapseColor" class="accordion-collapse collapse" data-bs-parent="#productFilters">
                            <div class="accordion-body d-flex flex-wrap gap-2">
                                <a href="{{ route('products-client', array_merge(request()->except('color'))) }}"
                                    class="btn btn-outline-primary btn-sm {{ !request()->color ? 'active' : '' }}">Tất
                                    cả</a>
                                @foreach ($colors as $color)
                                    <a href="{{ route('products-client', array_merge(request()->query(), ['color' => $color])) }}"
                                        class="btn btn-outline-primary btn-sm {{ request()->color == $color ? 'active' : '' }}">{{ $color }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="col-lg-9">
                <!-- Sắp xếp -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3><i class="bi bi-list me-2"></i>Danh sách sản phẩm</h3>
                    <div class="btn-group  align-items-center hover-zoom">
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
                                        {{-- dữ liệu sẽ được lấy  --}}
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
                                    <div class="d-flex flex-column align-items-center gap-2 mb-3">
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

                <!-- Phân trang -->
                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- modal thông báo thành công -->
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

    <!-- modal báo lỗi -->
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

    <!-- CSS tùy chỉnh -->
    <style>
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

        .accordion-button {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .accordion-button:not(.collapsed) {
            color: #007bff;
            background-color: #e7f1ff;
        }

        .btn-outline-primary.active,
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .list-group-item.active {
            background-color: #e7f1ff;
            border-color: #007bff;
        }

        .list-group-item.active a {
            color: #007bff;
            font-weight: 500;
        }

        .btn-group .btn {
            border-radius: 0.25rem;
            margin-left: 0.25rem;
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .btn-group .btn {
                flex: 1 1 auto;
                margin-left: 0;
            }
        }
    </style>

    <script src="{{ asset('assets/js/cart.js') }}"></script>
@endsection


@section('scripts')
    {{-- đoạn này chỉ chạy khi người dùng chưa đăng nhập --}}
    {{-- để thêm sản phẩm vào localStorage --}}
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

                        // ✅ Lấy sản phẩm từ data attribute
                        const product = JSON.parse(this.dataset.product);
                        const productId = product.id;

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

