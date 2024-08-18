<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">{{ $news->title }}</h1>
        @if ($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" alt="News Image" class="img-fluid mb-4"
                style="max-width: 600px;">
        @endif
        <p>{{ $news->body }}</p>
        <p><strong>Tags:</strong> {{ $news->tags }}</p>
        <p><strong>Author:</strong> {{ $news->user->name }}</p>
        <a href="{{ route('news.edit', $news->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('news.destroy', $news->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('news.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</x-app-layout>
