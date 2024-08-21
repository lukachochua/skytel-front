@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Edit News')
@section('content_header_title', 'Edit News')
@section('content_header_subtitle', 'Update News Details')

{{-- Content body: main page content --}}
@section('content_body')
    <div class="container mt-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit News</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data"
                    x-data="dynamicForm()">
                    @csrf
                    @method('PUT')

                    {{-- Georgian Fields --}}
                    <div id="georgian-fields">
                        <h2 class="h5 text-dark mb-3">@lang('dashboard.georgian_fields')</h2>

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">@lang('news.title') (GE):</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $news->title) }}" required>
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label fw-bold">@lang('news.text') (GE):</label>
                            <textarea name="body" id="body" rows="5" class="form-control" required>{{ old('body', $news->body) }}</textarea>
                            @error('body')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- English Fields --}}
                    <div id="english-fields" style="display: none;">
                        <h2 class="h5 text-dark mb-3">@lang('news.english_fields')</h2>

                        <div class="mb-3">
                            <label for="title_en" class="form-label fw-bold">@lang('news.title') (EN):</label>
                            <input type="text" name="title_en" id="title_en" class="form-control"
                                value="{{ old('title_en', $news->getTranslation('title', 'en')) }}" required>
                            @error('title_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body_en" class="form-label fw-bold">@lang('news.text') (EN):</label>
                            <textarea name="body_en" id="body_en" rows="5" class="form-control" required>{{ old('body_en', $news->getTranslation('body', 'en')) }}"</textarea>
                            @error('body_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Common Fields --}}
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">@lang('news.image'):</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if ($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="Current Image" class="img-thumbnail mt-2"
                                style="max-width: 200px;">
                        @endif
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label fw-bold">@lang('news.tags'):</label>
                        <input type="text" name="tags" id="tags" class="form-control"
                            value="{{ old('tags', $news->tags) }}">
                        @error('tags')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="button" id="next-button" class="btn btn-success fw-bold" @click="switchToEnglish">
                        @lang('dashboard.next')
                    </button>

                    <button type="submit" id="submit-button" class="btn btn-primary fw-bold d-none">
                        @lang('news.update')
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop
