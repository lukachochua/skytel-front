@extends('layouts.app')

@section('subtitle', __('team.create'))
@section('content_header_title', __('team.dashboard'))
@section('content_header_subtitle', __('team.add_new_item'))

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('team.create') }}</h3>
            </div>
            <div class="card-body">
                <!-- Back Button -->
                <a href="{{ route('team.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> @lang('dashboard.back')
                </a>

                <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data" x-data="dynamicForm()">
                    @csrf

                    <!-- Georgian Fields -->
                    <div id="georgian-fields">
                        <h2 class="h5 text-dark mb-3">@lang('dashboard.georgian_fields')</h2>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">@lang('team.name') (GE):</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label fw-bold">@lang('team.position') (GE):</label>
                            <input type="text" name="position" id="position" class="form-control"
                                value="{{ old('position') }}" required>
                            @error('position')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">@lang('team.description') (GE):</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- English Fields -->
                    <div id="english-fields" style="display: none;">
                        <h2 class="h5 text-dark mb-3">@lang('dashboard.english_fields')</h2>

                        <div class="mb-3">
                            <label for="name_en" class="form-label fw-bold">@lang('team.name') (EN):</label>
                            <input type="text" name="name_en" id="name_en" class="form-control"
                                value="{{ old('name_en') }}">
                            @error('name_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position_en" class="form-label fw-bold">@lang('team.position') (EN):</label>
                            <input type="text" name="position_en" id="position_en" class="form-control"
                                value="{{ old('position_en') }}">
                            @error('position_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description_en" class="form-label fw-bold">@lang('team.description') (EN):</label>
                            <textarea name="description_en" id="description_en" rows="3" class="form-control">{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="mb-3">
                        <label for="photo" class="form-label fw-bold">@lang('team.photo'):</label>
                        <input type="file" name="photo" id="photo" class="form-control">
                        @error('photo')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <button type="button" id="next-button" class="btn btn-success fw-bold" @click="switchToEnglish">
                        @lang('dashboard.next')
                    </button>

                    <button type="submit" id="submit-button" class="btn btn-primary fw-bold d-none">
                        @lang('team.create')
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop

