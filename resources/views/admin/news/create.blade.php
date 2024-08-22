@extends('layouts.app')

@section('subtitle', __('news.create'))
@section('content_header_title', __('news.create'))
@section('content_header_subtitle', __('news.add_new_item'))

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('news.create') }}</h3>
            </div>
            <div class="card-body">
                <!-- Back Button -->
                <a href="{{ route('news.dashboard') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> @lang('dashboard.back')
                </a>

                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" x-data="dynamicForm()">
                    @csrf
                    <div id="georgian-fields">
                        <h2 class="h5 text-dark mb-3">@lang('dashboard.georgian_fields')</h2>

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">@lang('news.title') (GE):</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title') }}" required>
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">@lang('news.text') (GE):</label>
                            <textarea name="body" id="body" rows="5" class="form-control" required>{{ old('body') }}</textarea>
                            @error('body')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="english-fields" style="display: none;">
                        <h2 class="h5 text-dark mb-3">@lang('news.english_fields')</h2>

                        <div class="mb-3">
                            <label for="title_en" class="form-label fw-bold">@lang('news.title') (EN):</label>
                            <input type="text" name="title_en" id="title_en" class="form-control"
                                value="{{ old('en.title') }}" required>
                            @error('en.title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body_en" class="form-label fw-bold">@lang('news.text') (EN):</label>
                            <textarea name="body_en" id="body_en" rows="5" class="form-control" required>{{ old('body_en') }}</textarea>
                            @error('body_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">@lang('news.image'):</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label fw-bold">@lang('news.tags'):</label>
                        <input type="text" name="tags" id="tags" class="form-control"
                            value="{{ old('tags') }}">
                        @error('tags')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="button" id="next-button" class="btn btn-success fw-bold" @click="switchToEnglish">
                        @lang('dashboard.next')
                    </button>

                    <button type="submit" id="submit-button" class="btn btn-primary fw-bold d-none">
                        @lang('news.create')
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop
