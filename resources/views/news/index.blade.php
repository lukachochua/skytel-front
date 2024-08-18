<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">News List</h1>
        <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">Create News</a>

        <div class="list-group">
            @foreach ($news as $newsItem)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('news.show', $newsItem->id) }}"
                        class="text-decoration-none">{{ $newsItem->title }}</a>
                    <div>
                        <a href="{{ route('news.edit', $newsItem->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('news.destroy', $newsItem->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
