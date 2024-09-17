<x-main-layout>
    <div class="container mt-5">
        <h1 class="custom-header-margin mb-5 text-center text-primary fw-bold">
            News List
        </h1>

        <div class="row">
            @foreach ($news as $newsItem)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-secondary d-flex flex-column h-100">
                        @if ($newsItem->image)
                            <img src="{{ asset('storage/' . $newsItem->image) }}" class="card-img-top"
                                alt="Image for {{ $newsItem->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">
                                <a href="{{ route('news.show', $newsItem->id) }}"
                                    class="text-decoration-none text-primary">
                                    {{ $newsItem->title }}
                                </a>
                            </h5>
                            <div class="mb-2">
                                <x-news-metadata-item label="Author" :value="$newsItem->user->name" />
                                <x-news-metadata-item label="Date" :value="$newsItem->created_at->format('M d, Y')" />
                            </div>
                            <p class="card-text mb-3 flex-grow-1">
                                {{ Str::limit(strip_tags($newsItem->body), 100) }}
                            </p>
                            <a href="{{ route('news.show', $newsItem->id) }}" class="btn btn-primary mt-auto">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $news->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</x-main-layout>
