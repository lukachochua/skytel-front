<div class="swiper-container modern-tech-slider">
    <div class="swiper-wrapper">
        @foreach ($sliders as $slider)
            <div class="swiper-slide">
                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="slide-image">
                <div class="slide-content">
                    <h2 class="slide-title">{{ $slider->title }}</h2>
                    <p class="slide-description">{{ $slider->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
