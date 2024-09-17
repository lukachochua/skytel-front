<x-main-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-lg overflow-hidden text-white bg-dark">
                    @if ($news->image)
                        <div class="news-image-container">
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="news-image">
                        </div>
                    @endif

                    <div class="card-body p-4">
                        <h1 class="card-title text-warning text-center mb-4">{{ $news->title }}</h1>

                        <div class="news-metadata mb-4">
                            <div class="d-flex justify-content-between border-top border-bottom py-3">
                                <x-news-metadata-item label="Author" :value="$news->user->name" />
                                <x-news-metadata-item label="Tags" :value="$news->tags" />
                            </div>
                        </div>

                        <div class="news-content mb-4">
                            {!! $news->body !!}
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('news.index') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .news-image-container {
                height: 400px;
                overflow: hidden;
            }

            .news-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .news-content {
                font-size: 1.1rem;
                line-height: 1.6;
            }

            .news-content p {
                margin-bottom: 1rem;
            }

            .news-content img {
                max-width: 100%;
                height: auto;
            }

            .news-content table {
                width: 100%;
                margin-bottom: 1rem;
                color: #fff;
                border-collapse: collapse;
            }

            .news-content th,
            .news-content td {
                padding: 0.75rem;
                border: 1px solid #dee2e6;
            }
        </style>
    @endpush
</x-main-layout>
