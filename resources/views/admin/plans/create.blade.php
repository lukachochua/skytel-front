@extends('layouts.app')

@section('subtitle', __('plans.create'))
@section('content_header_title', __('plans.dashboard'))
@section('content_header_subtitle', __('plans.create'))

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('plans.create') }}</h3>
            </div>
            <div class="card-body">
                <!-- Back Button -->
                <a href="{{ route('plans.dashboard') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> @lang('dashboard.back')
                </a>

                <form action="{{ route('plans.store') }}" method="POST" enctype="multipart/form-data" x-data="planForm" x-init="init()">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">@lang('plans.name'):</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label fw-bold">@lang('plans.type'):</label>
                        <select name="type" id="type" class="form-select" x-ref="type" @change="toggleTvFields" required>
                            <option value="fiber_optic" {{ old('type') == 'fiber_optic' ? 'selected' : '' }}>Fiber Optic</option>
                            <option value="wireless" {{ old('type') == 'wireless' ? 'selected' : '' }}>Wireless</option>
                            <option value="tv" {{ old('type') == 'tv' ? 'selected' : '' }}>TV</option>
                            <option value="corporate" {{ old('type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                        </select>
                        @error('type')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TV Fields -->
                    <div id="tv-fields" x-show="showTvFields" style="display: none;">
                        <div class="mb-3">
                            <label for="tv_service" class="form-label fw-bold">@lang('plans.tv_service'):</label>
                            <select name="tv_service_id" id="tv_service" class="form-select">
                                <option value="">@lang('plans.select_tv_service')</option>
                                @foreach ($tvServices as $tvService)
                                    <option value="{{ $tvService->id }}" {{ old('tv_service_id') == $tvService->id ? 'selected' : '' }}>
                                        {{ $tvService->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tv_service_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tv_service_option" class="form-label fw-bold">@lang('plans.tv_service_option'):</label>
                            <select name="tv_service_option_id" id="tv_service_option" class="form-select">
                                <option value="">@lang('plans.select_tv_service_option')</option>
                                @foreach ($tvServiceOptions as $tvServiceOption)
                                    @if($tvServiceOption->enabled) <!-- Only show enabled options -->
                                        <option value="{{ $tvServiceOption->id }}" {{ old('tv_service_option_id') == $tvServiceOption->id ? 'selected' : '' }}>
                                            {{ $tvServiceOption->option_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('tv_service_option_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">@lang('plans.description'):</label>
                        <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">@lang('plans.status'):</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold">
                        @lang('plans.create')
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop
