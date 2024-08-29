@extends('layouts.app')

@section('title', 'Edit Plan')

@section('content_header')
    <h1>@lang('plans.edit_plan')</h1>
@stop

@section('content')
    <div class="container">
        {{-- Success message --}}
        @if (session('success'))
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        @endif

        {{-- Form for Editing an Existing Plan --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">@lang('plans.edit_plan')</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('plans.update', $plan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">@lang('plans.name')</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $plan->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">@lang('plans.type')</label>
                                <select id="type" name="type"
                                    class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="" disabled>Select Type</option>
                                    <option value="fiber_optic"
                                        {{ old('type', $plan->type) == 'fiber_optic' ? 'selected' : '' }}>Fiber Optic
                                    </option>
                                    <option value="wireless" {{ old('type', $plan->type) == 'wireless' ? 'selected' : '' }}>
                                        Wireless</option>
                                    <option value="tv" {{ old('type', $plan->type) == 'tv' ? 'selected' : '' }}>TV
                                    </option>
                                    <option value="corporate"
                                        {{ old('type', $plan->type) == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">@lang('plans.description')</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $plan->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">@lang('plans.status')</label>
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="active"
                                        {{ old('status', $plan->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive"
                                        {{ old('status', $plan->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6" id="setanta-container">
                            <div class="form-group form-check">
                                <input type="checkbox" id="setanta" name="setanta"
                                    class="form-check-input @error('setanta') is-invalid @enderror"
                                    {{ old('setanta', $plan->setanta) ? 'checked' : '' }}>
                                <label for="setanta" class="form-check-label">@lang('plans.setanta')</label>
                                @error('setanta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="plan-options-container">
                        <h4>@lang('plans.plan_options')</h4>
                        <div class="form-group mb-3">
                            <button type="button" class="btn btn-secondary" id="add-option">
                                <i class="fas fa-plus"></i> @lang('plans.add_option')
                            </button>
                        </div>
                        <div id="options-list">
                            @foreach ($plan->planOptions as $option)
                                <div class="option-row mb-3" id="option-{{ $option->id }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="options[{{ $option->id }}][name]"
                                                class="form-control" value="{{ $option->name }}"
                                                placeholder="@lang('plans.option_name')" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="options[{{ $option->id }}][price]"
                                                class="form-control" value="{{ $option->price }}"
                                                placeholder="@lang('plans.option_price')" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="options[{{ $option->id }}][description]"
                                                class="form-control" value="{{ $option->description }}"
                                                placeholder="@lang('plans.option_description')">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <button type="button" class="btn btn-danger remove-option"
                                                data-option-id="{{ $option->id }}">
                                                <i class="fas fa-trash"></i> @lang('plans.remove')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group mb-3">
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
