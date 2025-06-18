<section class="section" id="men">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h2>Thời trang nam mới nhất</h2>
                    <span>Chú trọng đến từng chi tiết chính là điều khiến HN_447 khác biệt so với các chủ đề khác.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="men-item-carousel">
                    <div class="owl-men-item owl-carousel">
                        @foreach ($products as $product)
                            <div class="item">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li>
                                                <a href="{{ route('product.detail', $product->slug) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}">
                                </div>
                                <div class="down-content">
                                    <h4>{{ $product->name }}</h4>
                                    <span>{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                    <ul class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <li><i class="fa fa-star{{ $i <= ($product->rating ?? 0) ? '' : '-o' }}"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
