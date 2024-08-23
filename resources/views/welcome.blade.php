<x-main-layout>
    <div class="container mt-4">
        <x-slider :sliders="$sliders" />

        <h1 class="mb-4 text-center text-primary">Latest News</h1>

        <div class="row">
            @foreach ($latestNews as $newsItem)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-secondary d-flex flex-column h-100 shadow-sm rounded">
                        @if ($newsItem->image)
                            <img src="{{ asset('storage/' . $newsItem->image) }}" class="card-img-top"
                                alt="Image for {{ $newsItem->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h5 class="card-title mb-2">
                                <a href="{{ route('news.show', $newsItem->id) }}"
                                    class="text-decoration-none text-primary">
                                    {{ $newsItem->title }}
                                </a>
                            </h5>
                            <p class="card-text mb-3 flex-grow-1 overflow-auto">
                                {{ Str::limit($newsItem->body, 100) }}
                            </p>
                            <a href="{{ route('news.show', $newsItem->id) }}" class="btn btn-primary mt-auto">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('news.index') }}" class="btn btn-primary">
                <i class="fas fa-newspaper"></i> View All News
            </a>
        </div>
    </div>
</x-main-layout>
