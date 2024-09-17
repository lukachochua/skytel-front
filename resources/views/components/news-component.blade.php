<div class="news-container mb-5 rounded-3 shadow-sm bg-secondary-subtle" x-data="newsScroller" x-init="init()">
    <div class="border-0 border-top-0 border-bottom-0 shadow-sm rounded overflow-hidden bg-primary-subtle mb-3">
        <div class="card-body p-3">
            <h5 class="card-title mb-0 text-primary fw-bold text-start">
                {{ __('news.all_news') }}
            </h5>
        </div>
    </div>
    <div class="news-wrapper px-3" style="overflow: hidden;">
        <div class="news-scroll" x-ref="newsScroll" @mousedown.prevent="startDrag" @mousemove.prevent="drag"
            @mouseup="endDrag" @mouseleave="endDrag" @touchstart.prevent="startDrag" @touchmove.prevent="drag"
            @touchend="endDrag"
            :style="{ transform: `translateX(-${scrollPosition}px)`, transition: isDragging ? 'none' : 'transform 0.3s ease' }">
            @foreach ($latestNews as $newsItem)
                <div class="news-item pe-3">
                    <div
                        class="card border-0 border-top-0 border-bottom-0 h-100 shadow-sm rounded overflow-hidden transition-all hover-shadow bg-primary-subtle">
                        <div class="row g-0 h-100">
                            <div class="col-4 position-relative overflow-hidden">
                                @if ($newsItem->image)
                                    <img src="{{ asset('storage/' . $newsItem->image) }}"
                                        class="img-fluid h-100 w-100 object-fit-cover transition-all hover-scale"
                                        alt="Image for {{ $newsItem->title }}">
                                @else
                                    <div class="bg-primary h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-newspaper text-white fa-3x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-8">
                                <div class="card-body d-flex flex-column h-100 p-3">
                                    <h5 class="card-title mb-2 text-primary fw-bold">
                                        <a href="{{ route('news.show', $newsItem->id) }}"
                                            class="text-decoration-none text-primary hover-text-dark transition-all">
                                            {{ Str::limit($newsItem->title, 50) }}
                                        </a>
                                    </h5>
                                    <div class="mb-2">
                                        <x-news-metadata-item label="Author" :value="$newsItem->user->name" />
                                        <x-news-metadata-item label="Date" :value="$newsItem->created_at->format('M d, Y')" />
                                    </div>
                                    <p class="card-text small text-muted mb-3">
                                        {{ Str::limit(strip_tags($newsItem->body), 70) }}
                                    </p>
                                    <a href="{{ route('news.show', $newsItem->id) }}"
                                        class="btn btn-outline-primary btn-sm mt-auto align-self-start transition-all hover-bg-primary hover-text-white">
                                        Read More <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="news-navigation d-flex justify-content-between mt-2 ms-2 me-2">
        <button class="btn btn-primary me-2" @click="scrollLeft" :disabled="atStart">
            <i class="fa fa-chevron-left"></i> Previous
        </button>
        <button class="btn btn-primary" @click="scrollRight" :disabled="atEnd">
            Next <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</div>
