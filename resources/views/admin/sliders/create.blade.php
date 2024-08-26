@extends('layouts.app')

@section('subtitle', isset($slider) ? __('slider.edit') : __('slider.create'))
@section('content_header_title', isset($slider) ? __('slider.edit') : __('slider.create'))
@section('content_header_subtitle', isset($slider) ? __('slider.edit_slider') : __('slider.add_new_slider'))

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ isset($slider) ? __('slider.edit_slider') : __('slider.add_new_slider') }}</h3>
            </div>
            <div class="card-body">
                <!-- Back Button -->
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> @lang('dashboard.back')
                </a>

                <form action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store') }}"
                    method="POST" enctype="multipart/form-data" x-data="dynamicForm()">
                    @csrf
                    @if (isset($slider))
                        @method('PUT')
                    @endif

                    <!-- Georgian Fields -->
                    <div id="georgian-fields">
                        <h2 class="h5 text-dark mb-3">@lang('dashboard.georgian_fields')</h2>

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">@lang('slider.title') (GE):</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $slider->title ?? '') }}" required>
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">@lang('slider.description') (GE):</label>
                            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $slider->description ?? '') }}</textarea>
                            @error('description')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- English Fields -->
                    <div id="english-fields" style="display: none;">
                        <h2 class="h5 text-dark mb-3">@lang('dashboard.english_fields')</h2>

                        <div class="mb-3">
                            <label for="title_en" class="form-label fw-bold">@lang('slider.title') (EN):</label>
                            <input type="text" name="title_en" id="title_en" class="form-control"
                                value="{{ old('title_en', $slider->title_en ?? '') }}" required>
                            @error('title_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description_en" class="form-label fw-bold">@lang('slider.description') (EN):</label>
                            <textarea name="description_en" id="description_en" rows="4" class="form-control">{{ old('description_en', $slider->description_en ?? '') }}</textarea>
                            @error('description_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">@lang('slider.image'):</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if (isset($slider) && $slider->image)
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}"
                                class="img-thumbnail mt-2" style="max-width: 150px;">
                        @endif
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Navigation Buttons -->
                    <button type="button" id="next-button" class="btn btn-success fw-bold" @click="switchToEnglish">
                        @lang('dashboard.next')
                    </button>

                    <button type="submit" id="submit-button" class="btn btn-primary fw-bold d-none">
                        {{ isset($slider) ? __('slider.update') : __('slider.create') }} @lang('slider.slider')
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop
