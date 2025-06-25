@extends('client.pages.page-layout')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Product images (carousel) -->
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow">
                        @php
                            $active = true;
                            $images = [];
                            // Use product thumbnail as fallback if variant has no image
                            foreach ($product->variants as $variant) {
                                $image = $variant->image ?? $product->thumbnail;
                                if ($image) {
                                    $images[] = asset($image);
                                }
                            }
                            // Fallback to default image if no images available
                            $images = !empty($images) ? $images : [asset('assets/images/single-product-01.jpg')];
                        @endphp
                        @foreach ($images as $image)
                            <div class="carousel-item {{ $active ? 'active' : '' }}">
                                <img src="{{ $image }}" class="d-block w-100" alt="Ảnh sản phẩm">
                            </div>
                            @php $active = false; @endphp
                        @endforeach
                    </div>
                    @if (count($images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        </button>
                    @endif
                </div>

                <div class="mb-3">
                    <img src="{{ $images[0] }}" class="img-fluid rounded mb-2" alt="Ảnh sản phẩm chính">
                </div>
            </div>

            <!-- Product details -->
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p class="text-muted">Mã sản phẩm: {{ $product->sku }}</p>
                <h4 class="text-danger fw-bold" id="variant-price">
                    ${{ number_format($selectedVariant->price, 2) }}
                </h4>

                <p class="mt-3">
                    {{ $product->description ?? ($product->short_description ?? 'Không có mô tả.') }}
                </p>

                <!-- Color selection -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Màu sắc:</label><br>
                    @foreach ($product->variants->groupBy('color') as $color => $variants)
                        <button
                            class="btn btn-outline-{{ $selectedVariant->color === $color ? 'success' : 'secondary' }} btn-sm me-2 variant-btn"
                            data-variant-id="{{ $variants->first()->id }}" data-price="{{ $variants->first()->price }}"
                            data-image="{{ asset($variants->first()->image ?? $product->thumbnail) }}"
                            data-stock="{{ $variants->first()->stock_quantity }}">
                            {{ $color }}
                        </button>
                    @endforeach
                </div>

                <!-- Size selection -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kích thước:</label>
                    <select class="form-select w-auto" id="size-select">
                        @foreach ($product->variants->where('color', $selectedVariant->color) as $variant)
                            <option value="{{ $variant->id }}" data-price="{{ $variant->price }}"
                                data-image="{{ asset($variant->image ?? $product->thumbnail) }}"
                                data-stock="{{ $variant->stock_quantity }}"
                                {{ $selectedVariant->id === $variant->id ? 'selected' : '' }}>
                                {{ $variant->size }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity selection -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Số lượng:</label>
                    <input type="number" class="form-control w-auto" value="1" min="1"
                        max="{{ $selectedVariant->stock_quantity }}" id="quantity-input">
                    <small class="text-muted">Còn {{ $selectedVariant->stock_quantity }} sản phẩm</small>
                </div>

                <!-- Action buttons -->
                <div class="d-grid gap-2 d-md-block">
                    @if (Auth::check())
                        <button 
                            type="button"
                            class="btn btn-outline-success btn-lg me-2 btn-add-cart" 
                            data-qty="1"
                            data-image="{{ asset($selectedVariant->image ?? $product->thumbnail) }}"
                        >
                            <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                        </button>
                    @else
                        <div class="alert alert-warning mt-3" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i> Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để mua sắm.
                        </div>
                    @endif

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

                <!-- Policies -->
                <div class="mt-4 border-top pt-3">
                    <p><i class="bi bi-truck me-2"></i> Giao hàng tiêu chuẩn 2-4 ngày</p>
                    <p><i class="bi bi-arrow-repeat me-2"></i> Đổi trả trong 30 ngày</p>
                </div>
            </div>
        </div>

        <!-- Reviews section -->
        <div class="row mt-5">
            <div class="col-lg-6">
                <h4><i class="bi bi-chat-left-text me-2"></i>Đánh giá khách hàng</h4>
                @if ($reviews->isEmpty())
                    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                @else
                    @foreach ($reviews as $review)
                        <div class="border rounded p-3 mb-3">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="text-muted small">- {{ $review->created_at->format('d/m/Y') }}</span>
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                @endfor
                            </div>
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Review form -->
            <div class="col-lg-6">
                <h5><i class="bi bi-pencil-square me-2"></i>Viết đánh giá</h5>
                @auth
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label class="form-label">Điểm đánh giá</label>
                            <select class="form-select w-auto" name="rating" required>
                                <option value="">Chọn số sao</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} sao</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea class="form-control" rows="4" name="comment" placeholder="Nhận xét sản phẩm..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark"><i class="bi bi-send me-1"></i>Gửi bình luận</button>
                    </form>
                @else
                    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.</p>
                @endauth
            </div>
        </div>

        <!-- Related products -->
        <div class="mt-5">
            <h4 class="mb-4"><i class="bi bi-stars text-warning me-2"></i>Sản phẩm liên quan</h4>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="{{ asset('assets/images/single-product-01.jpg') }}" class="card-img-top"
                                alt="Sản phẩm">
                            <div class="card-body">
                                <h6 class="card-title">Áo Polo Nam</h6>
                                <p class="text-primary fw-semibold">$45.00</p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="#" class="btn btn-outline-primary w-100 btn-sm"><i class="bi bi-eye"></i>
                                    Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Related categories -->
        <div class="mt-5">
            <h4 class="mb-3"><i class="bi bi-tags me-2"></i>Danh mục liên quan</h4>
            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-tag"></i> Áo khoác</a>
                <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-tag"></i> Đồ thu đông</a>
                <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-tag"></i> Thời trang nam</a>
            </div>
        </div>
    </div>

    <!-- modal báo thành công -->
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

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const variantButtons = document.querySelectorAll('.variant-btn');
            const sizeSelect = document.getElementById('size-select');
            const priceElement = document.getElementById('variant-price');
            const quantityInput = document.getElementById('quantity-input');
            const carouselInner = document.querySelector('.carousel-inner');
            const mainImage = document.querySelector('.mb-3 img');

            // Update variant details
            function updateVariantDetails(variantId, price, image, stock) {
                priceElement.textContent = `$${parseFloat(price).toFixed(2)}`;
                quantityInput.max = stock;
                quantityInput.value = Math.min(quantityInput.value, stock);
                mainImage.src = image;

                // Update carousel
                carouselInner.innerHTML =
                    `<div class="carousel-item active"><img src="${image}" class="d-block w-100" alt="Ảnh sản phẩm"></div>`;
            }

            // Handle color button click
            variantButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const variantId = button.dataset.variantId;
                    const price = button.dataset.price;
                    const image = button.dataset.image;
                    const stock = button.dataset.stock;

                    // Update active button
                    variantButtons.forEach(btn => btn.classList.remove('btn-outline-success'));
                    variantButtons.forEach(btn => btn.classList.add('btn-outline-secondary'));
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-outline-success');

                    // Fetch sizes for selected color via AJAX
                    fetch(
                            `/detail-product/{{ $product->id }}/variants?color=${encodeURIComponent(button.textContent)}`
                        )
                        .then(response => response.json())
                        .then(data => {
                            sizeSelect.innerHTML = '';
                            data.variants.forEach(variant => {
                                const option = document.createElement('option');
                                option.value = variant.id;
                                option.textContent = variant.size;
                                option.dataset.price = variant.price;
                                option.dataset.image = variant.image ||
                                    '{{ asset($product->thumbnail) }}';
                                option.dataset.stock = variant.stock_quantity;
                                sizeSelect.appendChild(option);
                            });

                            // Update details with first variant of selected color
                            updateVariantDetails(variantId, price, image, stock);
                        });
                });
            });

            // Handle size selection
            sizeSelect.addEventListener('change', () => {
                const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
                const variantId = selectedOption.value;
                const price = selectedOption.dataset.price;
                const image = selectedOption.dataset.image;
                const stock = selectedOption.dataset.stock;

                updateVariantDetails(variantId, price, image, stock);
            });
        });
    </script>

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

    {{-- xử lý hiển thị modal thông báo --}}
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

</script>


</script>

@endsection
