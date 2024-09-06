@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Plan</h1>
        <form action="{{ route('plans.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Plan Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $plan->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $plan->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price"
                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $plan->price) }}"
                    required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="plan_type_id">Type</label>
                <select id="plan_type_id" name="plan_type_id"
                    class="form-control @error('plan_type_id') is-invalid @enderror" required
                    data-fiber-optic-id="{{ $fiberOpticTypeId }}">
                    <option value="">Select Plan Type</option>
                    @foreach ($planTypes as $planType)
                        <option value="{{ $planType->id }}"
                            {{ old('plan_type_id', $plan->plan_type_id) == $planType->id ? 'selected' : '' }}>
                            {{ $planType->name }}
                        </option>
                    @endforeach
                </select>
                @error('plan_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- TV Plan Fields, displayed only for "Fiber Optic" type -->
            <div id="tv-plan-fields" class="form-group"
                style="display: {{ old('plan_type_id', $plan->plan_type_id) == $fiberOpticTypeId ? 'block' : 'none' }};">
                <h3>TV Plan Details</h3>

                @foreach ($plan->tvPlans as $index => $tvPlan)
                    <div class="form-group">
                        <label for="tv_plans[{{ $index }}][name]">TV Plan Name</label>
                        <input type="text" id="tv_plans[{{ $index }}][name]"
                            name="tv_plans[{{ $index }}][name]"
                            class="form-control @error('tv_plans.' . $index . '.name') is-invalid @enderror"
                            value="{{ old('tv_plans.' . $index . '.name', $tvPlan->name) }}">
                        @error('tv_plans.' . $index . '.name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tv_plans[{{ $index }}][description]">TV Plan Description</label>
                        <textarea id="tv_plans[{{ $index }}][description]" name="tv_plans[{{ $index }}][description]"
                            class="form-control @error('tv_plans.' . $index . '.description') is-invalid @enderror">{{ old('tv_plans.' . $index . '.description', $tvPlan->description) }}</textarea>
                        @error('tv_plans.' . $index . '.description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tv_plans[{{ $index }}][price]">TV Plan Price</label>
                        <input type="number" id="tv_plans[{{ $index }}][price]"
                            name="tv_plans[{{ $index }}][price]"
                            class="form-control @error('tv_plans.' . $index . '.price') is-invalid @enderror"
                            value="{{ old('tv_plans.' . $index . '.price', $tvPlan->price) }}">
                        @error('tv_plans.' . $index . '.price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <!-- Package Fields -->
            <div id="package-fields">
                <h4>Packages</h4>
                <div id="packages-container">
                    @if ($plan->tvPlans->isNotEmpty() && $plan->tvPlans->first()->packages->isNotEmpty())
                        @foreach ($plan->tvPlans->first()->packages as $index => $package)
                            <div class="form-group package-form">
                                <label for="packages[{{ $index }}][name]">Package Name</label>
                                <input type="text" id="packages[{{ $index }}][name]"
                                    name="packages[{{ $index }}][name }}"
                                    class="form-control @error('packages.*.name') is-invalid @enderror"
                                    value="{{ old('packages.' . $index . '.name', $package->name) }}">
                                @error('packages.*.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label for="packages[{{ $index }}][price]">Package Price</label>
                                <input type="number" id="packages[{{ $index }}][price]"
                                    name="packages[{{ $index }}][price }}"
                                    class="form-control @error('packages.*.price') is-invalid @enderror"
                                    value="{{ old('packages.' . $index . '.price', $package->price) }}">
                                @error('packages.*.price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    @else
                        <p>No packages available for this plan.</p>
                    @endif
                </div>
                <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                <button type="submit" class="btn btn-primary">Update Plan</button>
            </div>
    </div>
    </form>
    </div>
    @endsection


    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var planTypeSelect = document.getElementById('plan_type_id');
                var tvPlanFields = document.getElementById('tv-plan-fields');
                var addTvPlanButton = document.getElementById('add-tv-plan'); // Create button for adding TV plans

                // On change of plan type, show/hide the TV Plan fields
                planTypeSelect.addEventListener('change', function() {
                    if (this.value == {{ $fiberOpticTypeId }}) {
                        tvPlanFields.style.display = 'block';
                    } else {
                        tvPlanFields.style.display = 'none';
                    }
                });

                addTvPlanButton.addEventListener('click', function() {
                    // Logic for dynamically adding a new TV plan field (similar to the packages example)
                    var tvPlanCount = document.querySelectorAll('.tv-plan-form').length;
                    var tvPlanForm = document.createElement('div');
                    tvPlanForm.classList.add('form-group', 'tv-plan-form');

                    tvPlanForm.innerHTML = `
            <label for="tv_plans[${tvPlanCount}][name]">TV Plan Name</label>
            <input type="text" name="tv_plans[${tvPlanCount}][name]" class="form-control">
            <label for="tv_plans[${tvPlanCount}][description]">TV Plan Description</label>
            <textarea name="tv_plans[${tvPlanCount}][description]" class="form-control"></textarea>
            <label for="tv_plans[${tvPlanCount}][price]">TV Plan Price</label>
            <input type="number" name="tv_plans[${tvPlanCount}][price]" class="form-control">
        `;

                    tvPlanFields.appendChild(tvPlanForm);
                });
            });
        </script>
    @endsection
