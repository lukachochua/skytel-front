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
                <input type="number" id="price" name="price" step="0.01"
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
                    data-fiber-optic-id="{{ $fiberOpticType->id }}">
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
                style="display: {{ $plan->plan_type_id == $fiberOpticType->id ? 'block' : 'none' }};">
                <h3>TV Plan Details</h3>
                <div class="form-group">
                    <label for="tv_plan_name">TV Plan Name</label>
                    <input type="text" id="tv_plan_name" name="tv_plan_name"
                        class="form-control @error('tv_plan_name') is-invalid @enderror"
                        value="{{ old('tv_plan_name', $plan->tvPlans->first()->name ?? '') }}">
                    @error('tv_plan_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tv_plan_description">TV Plan Description</label>
                    <textarea id="tv_plan_description" name="tv_plan_description"
                        class="form-control @error('tv_plan_description') is-invalid @enderror">{{ old('tv_plan_description', $plan->tvPlans->first()->description ?? '') }}</textarea>
                    @error('tv_plan_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tv_plan_price">TV Plan Price</label>
                    <input type="number" id="tv_plan_price" name="tv_plan_price" step="0.01"
                        class="form-control @error('tv_plan_price') is-invalid @enderror"
                        value="{{ old('tv_plan_price', $plan->tvPlans->first()->price ?? '') }}">
                    @error('tv_plan_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Package Fields -->
                <div id="package-fields">
                    <h4>Packages</h4>
                    <div id="packages-container">
                        @forelse ($plan->tvPlans->first()->packages ?? [] as $index => $package)
                            <div class="form-group package-form">
                                <input type="hidden" name="packages[{{ $index }}][id]"
                                    value="{{ $package->id }}">
                                <label for="packages[{{ $index }}][name]">Package Name</label>
                                <input type="text" id="packages[{{ $index }}][name]"
                                    name="packages[{{ $index }}][name]"
                                    class="form-control @error('packages.' . $index . '.name') is-invalid @enderror"
                                    value="{{ old('packages.' . $index . '.name', $package->name) }}">
                                @error('packages.' . $index . '.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label for="packages[{{ $index }}][price]">Package Price</label>
                                <input type="number" id="packages[{{ $index }}][price]"
                                    name="packages[{{ $index }}][price]" step="0.01"
                                    class="form-control @error('packages.' . $index . '.price') is-invalid @enderror"
                                    value="{{ old('packages.' . $index . '.price', $package->price) }}">
                                @error('packages.' . $index . '.price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="button" class="btn btn-danger remove-package">Remove Package</button>
                            </div>
                        @empty
                            <div class="form-group package-form">
                                <label for="packages[0][name]">Package Name</label>
                                <input type="text" id="packages[0][name]" name="packages[0][name]"
                                    class="form-control @error('packages.0.name') is-invalid @enderror">
                                @error('packages.0.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label for="packages[0][price]">Package Price</label>
                                <input type="number" id="packages[0][price]" name="packages[0][price]" step="0.01"
                                    class="form-control @error('packages.0.price') is-invalid @enderror">
                                @error('packages.0.price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="button" class="btn btn-danger remove-package">Remove Package</button>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Plan</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const planTypeSelect = $('#plan_type_id');
            const tvPlanFields = $('#tv-plan-fields');
            const fiberOpticTypeId = planTypeSelect.data('fiber-optic-id');

            planTypeSelect.change(function() {
                if ($(this).val() == fiberOpticTypeId) {
                    tvPlanFields.show();
                } else {
                    tvPlanFields.hide();
                }
            });

            let packageIndex =
                {{ $plan->tvPlans && $plan->tvPlans->first()->packages ? $plan->tvPlans->first()->packages->count() : 0 }};

            $('#add-package').click(function() {
                packageIndex++;
                const newPackage = `
                <div class="form-group package-form">
                    <label for="packages[${packageIndex}][name]">Package Name</label>
                    <input type="text" id="packages[${packageIndex}][name]" name="packages[${packageIndex}][name]" class="form-control">
                    <label for="packages[${packageIndex}][price]">Package Price</label>
                    <input type="number" id="packages[${packageIndex}][price]" name="packages[${packageIndex}][price]" step="0.01" class="form-control">
                    <button type="button" class="btn btn-danger remove-package">Remove Package</button>
                </div>
            `;
                $('#packages-container').append(newPackage);
            });

            $(document).on('click', '.remove-package', function() {
                $(this).closest('.package-form').remove();
            });
        });
    </script>
@endpush
