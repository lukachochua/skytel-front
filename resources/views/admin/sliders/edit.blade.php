@extends('layouts.app')

@section('subtitle', isset($slider) ? __('sliders.edit') : __('sliders.create'))
@section('content_header_title', isset($slider) ? __('sliders.edit') : __('sliders.create'))
@section('content_header_subtitle', __('sliders.manage'))

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ isset($slider) ? __('sliders.edit') : __('sliders.create') }}</h3>
            </div>
            <div class="card-body">
                <!-- Back Button -->
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> @lang('sliders.back')
                </a>

                <form action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($slider))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">@lang('sliders.title')</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $slider->title ?? '') }}" required>
                        @error('title')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">@lang('sliders.description')</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $slider->description ?? '') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">@lang('sliders.image')</label>
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

                    <button type="submit" class="btn btn-success">
                        {{ isset($slider) ? __('sliders.update') : __('sliders.create') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop
