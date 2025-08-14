@php
    $banner = App\Models\Banner::first();
@endphp
<div class="col-lg-8">
    <div class="left-content">
        <div class="thumb" style="height: 412px; position: relative; background-color: #000;">
            <div class="inner-content" @if(!$banner || !$banner->show_text) style="display: none;" @endif>
                <h4>{{ $banner->title ?? 'Chào mừng đến với chúng tôi' }}</h4>
                <span>{{ $banner->subtitle ?? 'Thời trang, phong cách &amp; thể hiện cá tính' }}</span>
                <div class="main-border-button">
                    <a href="#">Mua ngay!</a>
                </div>
            </div>

            <div class="banner-slider">
                <img src="{{ $banner && $banner->image_path_1 ? asset('storage/' . $banner->image_path_1) : asset('assets/images/left-banner-image.jpg') }}" alt="Banner 1" class="active">
                <img src="{{ $banner && $banner->image_path_2 ? asset('storage/' . $banner->image_path_2) : asset('assets/images/left-banner-image.jpg') }}" alt="Banner 2">
                <img src="{{ $banner && $banner->image_path_3 ? asset('storage/' . $banner->image_path_3) : asset('assets/images/left-banner-image.jpg') }}" alt="Banner 3">
            </div>

            <div class="slider-controls">
                <button class="btn btn-outline-light btn-sm" id="prev-slide">&lt;</button>
                <button class="btn btn-outline-light btn-sm" id="next-slide">&gt;</button>
            </div>
        </div>
    </div>
</div>

<style>
.main-banner .left-content .thumb {
    position: relative;
    width: 100%;
    max-width: 100%;
    overflow: hidden;
}

.main-banner .left-content .banner-slider {
    position: relative;
    width: 100%;
    height: 100%;
}

/* Crossfade: ảnh chồng lên nhau, chỉ đổi opacity */
.main-banner .left-content .banner-slider img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    will-change: opacity;
}

.main-banner .left-content .banner-slider img.active {
    opacity: 1;
    z-index: 1;
}

.main-banner .left-content .inner-content {
    position: absolute;
    left: 100px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
}

.main-banner .left-content .inner-content h4 {
    color: #fff;
    margin-top: -10px;
    font-size: 52px;
    font-weight: 700;
    margin-bottom: 20px;
}

.main-banner .left-content .inner-content span {
    font-size: 16px;
    color: #fff;
    font-weight: 400;
    font-style: italic;
    display: block;
    margin-bottom: 30px;
}

.main-banner .left-content .slider-controls {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    z-index: 10;
}

.main-banner .left-content .slider-controls button {
    background: rgba(0, 0, 0, 0.5);
    border: none;
    padding: 10px 15px;
    font-size: 24px;
    line-height: 1;
}

.main-banner .left-content .slider-controls button:hover {
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
}

.main-banner .left-content .slider-controls #prev-slide { margin-left: 10px; }
.main-banner .left-content .slider-controls #next-slide { margin-right: 10px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('.banner-slider img');
    const prevBtn = document.getElementById('prev-slide');
    const nextBtn = document.getElementById('next-slide');

    if (!images.length || !prevBtn || !nextBtn) return;

    let currentImage = 0;
    let autoSlideInterval;

    function showImage(index) {
        // ✅ Chuẩn hoá index TRƯỚC khi toggle class để không có khoảng đen
        const next = (index + images.length) % images.length;

        images.forEach((img, i) => {
            img.classList.toggle('active', i === next);
        });

        currentImage = next;
    }

    function startAutoSlide() {
        stopAutoSlide(); // tránh nhân đôi interval
        autoSlideInterval = setInterval(() => {
            showImage(currentImage + 1);
        }, 3000);
    }

    function stopAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
    }

    prevBtn.addEventListener('click', () => {
        stopAutoSlide();
        showImage(currentImage - 1);
        startAutoSlide();
    });

    nextBtn.addEventListener('click', () => {
        stopAutoSlide();
        showImage(currentImage + 1);
        startAutoSlide();
    });

    // Khởi tạo
    showImage(currentImage);
    startAutoSlide();

    // Tuỳ chọn: tạm dừng khi hover để tránh flicker khi bấm nhanh
    const thumb = document.querySelector('.thumb');
    if (thumb) {
        thumb.addEventListener('mouseenter', stopAutoSlide);
        thumb.addEventListener('mouseleave', startAutoSlide);
    }
});
</script>
