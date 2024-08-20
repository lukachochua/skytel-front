<x-main-layout>
    <div class="container mt-4">
        <!-- News Card -->
        <div class="card border-light shadow-lg rounded p-4">
            <!-- News Image -->
            @if ($news->image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="News Image" class="img-fluid rounded border"
                        style="max-width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <!-- News Title -->
            <h1 class="text-primary mb-4 text-center">{{ $news->title }}</h1>

            <!-- News Tags and Author -->
            <div class="mb-4">
                <div class="border-top border-bottom py-3 mb-3">
                    <p class="font-weight-bold mb-1">Author:</p>
                    <p class="text-muted">{{ $news->user->name }}</p>
                </div>
                <div class="border-top border-bottom py-3 mb-3">
                    <p class="font-weight-bold mb-1">Tags:</p>
                    <p class="text-muted">{{ $news->tags }}</p>
                </div>
            </div>

            <!-- News Body -->
            <div class="mb-4">
                <p class="lead">{{ $news->body }}</p>
            </div>

            <!-- Back to List Button -->
            <div class="text-center mt-4">
                <a href="{{ route('news.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</x-main-layout>
