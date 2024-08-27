<x-main-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="slider-details card text-white bg-dark border-0 shadow-lg p-4 w-100">
            <div class="row g-0 align-items-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}"
                        class="slider-image img-fluid rounded-start">
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-center text-center">
                    <div class="card-body">
                        <h1 class="card-title display-4">{{ $slider->title }}</h1>
                        <p class="card-text lead">{{ $slider->description }}</p>
                        <div class="mt-4">
                            <a href="{{ route('welcome') }}" class="btn btn-outline-light btn-lg">Back to
                                Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
