@extends('layouts.app')

@section('subtitle', isset($slider) ? __('slider.edit') : __('slider.create'))
@section('content_header_title', isset($slider) ? __('sliders.edit') : __('slider.create'))
@section('content_header_subtitle', __('sliders.manage'))

@section('content_body')
    <div class="container" x-data="dynamicForm()">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ isset($slider) ? __('slider.edit') : __('slider.create') }}</h3>
            </div>
            <div class="card-body">
                <!-- Back Button -->
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> @lang('slider.back')
                </a>

                <form action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('slider.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($slider))
                        @method('PUT')
                    @endif

                    <!-- Georgian Fields -->
                    <div id="georgian-fields" x-show="!showEnglishFields">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">@lang('slider.title')</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $slider->title ?? '') }}" required>
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">@lang('slider.description')</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $slider->description ?? '') }}</textarea>
                            @error('description')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- English Fields -->
                    <div id="english-fields" x-show="showEnglishFields" style="display: none;">
                        <div class="mb-3">
                            <label for="title-en" class="form-label fw-bold">@lang('slider.title_en')</label>
                            <input type="text" name="title_en" id="title-en" class="form-control"
                                value="{{ old('title_en', $slider->translations['title']['en'] ?? '') }}" required>
                            @error('title_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description-en" class="form-label fw-bold">@lang('slider.description_en')</label>
                            <textarea name="description_en" id="description-en" class="form-control" rows="4">{{ old('description_en', $slider->translations['description']['en'] ?? '') }}</textarea>
                            @error('description_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Additional English-specific fields can go here -->
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">@lang('slider.image')</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if (isset($slider) && $slider->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}"
                                    class="img-fluid" width="100">
                            </div>
                        @endif
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Next Button -->

                    <button type="button" id="next-button" class="btn btn-primary" @click="switchToEnglish()">
                        @lang('dashboard.next')
                    </button>
                    <!-- Submit Button -->
                    <button type="submit" id="submit-button" class="btn btn-success d-none">
                        {{ isset($slider) ? __('slider.update') : __('slider.create') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop
