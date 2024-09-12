@extends('layouts.app')

@section('subtitle', __('team.edit'))
@section('content_header_title', __('team.dashboard'))
@section('content_header_subtitle', __('team.edit_member'))

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('team.edit_member') }}</h3>
            </div>
            <div class="card-body">
                <!-- Back Button -->
                <a href="{{ route('team.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> @lang('team.back')
                </a>

                <form action="{{ route('team.update', $team->id) }}" method="POST" enctype="multipart/form-data"
                    x-data="dynamicForm()">
                    @csrf
                    @method('PUT')

                    <!-- Georgian Fields -->
                    <div id="georgian-fields">
                        <h2 class="h5 text-dark mb-3">@lang('team.georgian_fields')</h2>

                        <div class="mb-3">
                            <label for="name" class="form-label">@lang('team.name') (GE):</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $team->getTranslation('name', 'ka')) }}" required>
                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">@lang('team.position') (GE):</label>
                            <input type="text" name="position" id="position" class="form-control"
                                value="{{ old('position', $team->getTranslation('position', 'ka')) }}" required>
                            @error('position')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">@lang('team.description') (GE):</label>
                            <textarea name="description" id="description" class="form-control" required>{{ old('description', $team->getTranslation('description', 'ka')) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- English Fields -->
                    <div id="english-fields" style="display: none;">
                        <h2 class="h5 text-dark mb-3">@lang('team.english_fields')</h2>

                        <div class="mb-3">
                            <label for="name_en" class="form-label">@lang('team.name') (EN):</label>
                            <input type="text" name="name_en" id="name_en" class="form-control"
                                value="{{ old('name_en', $team->getTranslation('name', 'en')) }}" required>
                            @error('name_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position_en" class="form-label">@lang('team.position') (EN):</label>
                            <input type="text" name="position_en" id="position_en" class="form-control"
                                value="{{ old('position_en', $team->getTranslation('position', 'en')) }}" required>
                            @error('position_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description_en" class="form-label">@lang('team.description') (EN):</label>
                            <textarea name="description_en" id="description_en" class="form-control" required>{{ old('description_en', $team->getTranslation('description', 'en')) }}</textarea>
                            @error('description_en')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">@lang('team.photo'):</label>
                        <input type="file" name="photo" id="photo" class="form-control">
                        @if ($team->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $team->photo) }}" alt="{{ $team->name }}"
                                    width="150">
                            </div>
                        @endif
                        @error('photo')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <button type="button" id="next-button" class="btn btn-success fw-bold" @click="switchToEnglish">
                        @lang('team.next')
                    </button>

                    <button type="submit" id="submit-button" class="btn btn-primary fw-bold d-none">
                        @lang('team.update')
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
