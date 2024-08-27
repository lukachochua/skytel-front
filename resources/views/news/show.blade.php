<x-main-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!-- News Card -->
        <div class="card border-0 shadow-lg rounded-lg overflow-hidden text-white bg-dark w-100"
            style="max-width: 800px;">
            <!-- News Image -->
            @if ($news->image)
                <div class="text-center">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="News Image" class="img-fluid w-100"
                        style="height: 400px; object-fit: cover;">
                </div>
            @endif

            <!-- News Content -->
            <div class="p-4">
                <!-- News Title -->
                <h1 class="text-warning text-center mb-4">{{ $news->title }}</h1>

                <!-- News Tags and Author -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between border-top border-bottom py-3">
                        <div>
                            <p class="mb-1 text-muted">Author:</p>
                            <p class="font-weight-bold">{{ $news->user->name }}</p>
                        </div>
                        <div>
                            <p class="mb-1 text-muted">Tags:</p>
                            <p class="font-weight-bold">{{ $news->tags }}</p>
                        </div>
                    </div>
                </div>

                <!-- News Body -->
                <div class="mb-4">
                    <p class="lead">{{ $news->body }}</p>
                </div>

                <!-- Back to List Button -->
                <div class="text-center mt-4">
                    <a href="{{ route('news.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
