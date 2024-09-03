@extends('layouts.app')

@section('title', 'Create Plan')

@section('content_header')
    <h1>@lang('plans.create_plan')</h1>
@stop

@section('content')
    <div class="container">
        {{-- Success message --}}
        @if (session('success'))
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        @endif

        {{-- Form for Creating a New Plan --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">@lang('plans.create_plan')</h3>
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
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan_type_id">@lang('plans.type')</label>
                                <select id="plan_type_id" name="plan_type_id"
                                    class="form-control @error('plan_type_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Type</option>
                                    @foreach ($planTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('plan_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">@lang('plans.description')</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
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
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="tv-service-options-container" style="display: none;">
                        <h4>@lang('plans.tv_service_options')</h4>
                        <div id="services-list">
                            @foreach ($tvServices as $tvService)
                                <div class="form-check">
                                    <input type="checkbox" id="setanta-{{ $tvService->id }}"
                                        name="tv_services[{{ $tvService->id }}]" class="form-check-input" value="1">
                                    <label class="form-check-label" for="setanta-{{ $tvService->id }}">
                                        {{ $tvService->name }} - Add Setanta
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-service-button" class="btn btn-secondary">
                            @lang('plans.add_service')
                        </button>
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

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const planTypeSelect = document.getElementById('plan_type_id');
            const tvServiceOptionsContainer = document.getElementById('tv-service-options-container');
            const addServiceButton = document.getElementById('add-service-button');
            const servicesList = document.getElementById('services-list');

            planTypeSelect.addEventListener('change', function() {
                if (planTypeSelect.value ==
                    {{ \App\Models\PlanType::where('name', 'fiber_optic')->first()->id }}) {
                    tvServiceOptionsContainer.style.display = 'block';
                } else {
                    tvServiceOptionsContainer.style.display = 'none';
                }
            });

            addServiceButton.addEventListener('click', function() {
                const newService = document.createElement('div');
                newService.classList.add('service-option');
                newService.innerHTML = `
            <div class="form-check">
                <input type="checkbox" id="service1" name="services[]" value="Service1" class="form-check-input">
                <label class="form-check-label" for="service1">Service 1</label>
            </div>
        `;
                servicesList.appendChild(newService);
            });
        });
    </script>
@stop
