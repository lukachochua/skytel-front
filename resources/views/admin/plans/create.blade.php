@extends('layouts.app')

@section('title', 'Create Plan')

@section('content_header')
    <h1>@lang('plans.create_plan')</h1>
@stop

@section('content_body')
    <div class="container mt-4">
        {{-- Success message --}}
        @if (session('success'))
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        @endif

        {{-- Form for Creating a New Plan --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">@lang('plans.create_new_plan')</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('plans.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">@lang('plans.name')</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">@lang('plans.type')</label>
                                <select id="type" name="type"
                                    class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="" disabled selected>@lang('plans.select_type')</option>
                                    <option value="fiber_optic" {{ old('type') == 'fiber_optic' ? 'selected' : '' }}>
                                        @lang('plans.fiber_optic')</option>
                                    <option value="wireless" {{ old('type') == 'wireless' ? 'selected' : '' }}>
                                        @lang('plans.wireless')</option>
                                    <option value="tv" {{ old('type') == 'tv' ? 'selected' : '' }}>@lang('plans.tv')
                                    </option>
                                    <option value="corporate" {{ old('type') == 'corporate' ? 'selected' : '' }}>
                                        @lang('plans.corporate')</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">@lang('plans.description')</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">@lang('plans.status')</label>
                                <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                        @lang('plans.active')</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        @lang('plans.inactive')</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6" id="setanta-container">
                            <div class="form-check">
                                <input type="checkbox" id="setanta" name="setanta"
                                    class="form-check-input @error('setanta') is-invalid @enderror"
                                    {{ old('setanta') ? 'checked' : '' }}>
                                <label for="setanta" class="form-check-label">@lang('plans.setanta')</label>
                                @error('setanta')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="plan-options-container" class="mt-4">
                        <h4>@lang('plans.plan_options')</h4>
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" id="add-option">
                                <i class="fas fa-plus"></i> @lang('plans.add_option')
                            </button>
                        </div>
                        <div id="options-list">
                            @if (old('options'))
                                @foreach (old('options') as $optionId => $option)
                                    <div class="option-row mb-3" id="option-{{ $optionId }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="options[{{ $optionId }}][name]"
                                                    class="form-control" value="{{ $option['name'] }}"
                                                    placeholder="@lang('plans.option_name')" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="options[{{ $optionId }}][price]"
                                                    class="form-control" value="{{ $option['price'] }}"
                                                    placeholder="@lang('plans.option_price')" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="options[{{ $optionId }}][description]"
                                                    class="form-control" value="{{ $option['description'] }}"
                                                    placeholder="@lang('plans.option_description')">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <button type="button" class="btn btn-danger remove-option"
                                                    data-option-id="{{ $optionId }}">
                                                    <i class="fas fa-trash"></i> @lang('plans.remove')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> @lang('plans.save')
                        </button>
                        <a href="{{ route('plans.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> @lang('plans.cancel')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
