<x-main-layout>
    <div class="container mt-2">
        <div class="row mt-4">
            @foreach ($latestNews as $newsItem)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if ($newsItem->image)
                            <img src="{{ asset('storage/' . $newsItem->image) }}" class="card-img-top"
                                alt="Image for {{ $newsItem->title }}" style="max-height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('news.show', $newsItem->id) }}"
                                    class="text-decoration-none text-primary">
                                    {{ $newsItem->title }}
                                </a>
                            </h5>
                            <p class="card-text">{{ Str::limit($newsItem->body, 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('news.index') }}" class="btn btn-primary">View All News</a>
        </div>
    </div>
</x-main-layout>
