<div class="col-lg-6">
    <div class="left-content">
        <div class="slideshow-container" id="slideshow-container">
            @if(isset($slides) && $slides->count() > 0)
                @foreach($slides as $index => $slide)
                    {{-- SỬA LỖI Ở ĐÂY: Đã xóa class "fade" --}}
                    <div class="mySlides">
                        <div class="numbertext">{{ $index + 1 }} / {{ $slides->count() }}</div>

                        @if($slide->news_id)
                            <a href="{{ route('news.show', $slide->news_id) }}">
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" style="width:100%; height:100%; object-fit: cover;">
                            </a>
                        @else
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" style="width:100%; height:100%; object-fit: cover;">
                        @endif

                        <div class="text">{{ $slide->title }}</div>
                    </div>
                @endforeach
                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>
            @else
                <p>Không có slide nào để hiển thị.</p>
            @endif
        </div>
        <br>
        <div style="text-align:center" id="dot-container">
            @if(isset($slides) && $slides->count() > 0)
                @foreach($slides as $index => $slide)
                    <span class="dot" onclick="currentSlide({{ $index + 1 }})"></span>
                @endforeach
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (slides.length === 0) return;
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            if (slides.length > 0) {
                 slides[slideIndex - 1].style.display = "block";
            }
            if (dots.length > 0) {
                dots[slideIndex - 1].className += " active";
            }
        }
    </script>
@endpush