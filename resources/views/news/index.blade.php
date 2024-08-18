<x-main-layout>
    <div class="container mt-4">
        <h1 class="mb-4">News List</h1>

        <div class="mb-3">
            <a href="{{ route('news.create') }}" class="btn btn-primary">Create News</a>
        </div>

        <div class="row">
            @foreach ($news as $newsItem)
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
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('news.edit', $newsItem->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('news.destroy', $newsItem->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
