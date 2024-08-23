<div class="swiper-container" style="width: 100%; max-width: 800px; margin: auto; overflow: hidden;">
    <div class="swiper-wrapper">
        @foreach ($sliders as $slider)
            <div class="swiper-slide" style="width: 100%;">
                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="img-fluid w-100"
                    style="height: 400px; object-fit: cover;">
                <div class="swiper-text position-absolute text-white p-3"
                    style="bottom: 20px; left: 20px; background: rgba(0, 0, 0, 0.5);">
                    <h2 class="h5">{{ $slider->title }}</h2>
                    <p class="mb-0">{{ $slider->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
