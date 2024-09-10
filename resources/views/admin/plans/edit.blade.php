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
                    value="{{ old('name', $plan->getTranslation('name', 'ka')) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name_en">Plan Name (EN)</label>
                <input type="text" id="name_en" name="name_en"
                    class="form-control @error('name_en') is-invalid @enderror"
                    value="{{ old('name_en', $plan->getTranslation('name', 'en')) }}">
                @error('name_en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $plan->getTranslation('description', 'ka')) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description_en">Description (EN)</label>
                <textarea id="description_en" name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                    required>{{ old('description_en', $plan->getTranslation('description', 'en')) }}</textarea>
                @error('description_en')
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
                style="display: {{ old('plan_type_id', $plan->plan_type_id) == $fiberOpticType->id ? 'block' : 'none' }};">
                <h3>TV Plan Details</h3>
                <div class="form-group">
                    <label for="tv_plan_name">TV Plan Name</label>
                    <input type="text" id="tv_plan_name" name="tv_plan_name"
                        class="form-control @error('tv_plan_name') is-invalid @enderror"
                        value="{{ old('tv_plan_name', $plan->tvPlans->first()->getTranslation('name', 'ka') ?? '') }}">
                    @error('tv_plan_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tv_plan_name_en">TV Plan Name (EN)</label>
                    <input type="text" id="tv_plan_name_en" name="tv_plan_name_en"
                        class="form-control @error('tv_plan_name_en') is-invalid @enderror"
                        value="{{ old('tv_plan_name_en', $plan->tvPlans->first()->getTranslation('name', 'en') ?? '') }}">
                    @error('tv_plan_name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tv_plan_description">TV Plan Description</label>
                    <textarea id="tv_plan_description" name="tv_plan_description"
                        class="form-control @error('tv_plan_description') is-invalid @enderror">{{ old('tv_plan_description', $plan->tvPlans->first()->getTranslation('description', 'ka') ?? '') }}</textarea>
                    @error('tv_plan_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tv_plan_description_en">TV Plan Description (EN)</label>
                    <textarea id="tv_plan_description_en" name="tv_plan_description_en"
                        class="form-control @error('tv_plan_description_en') is-invalid @enderror">{{ old('tv_plan_description_en', $plan->tvPlans->first()->getTranslation('description', 'en') ?? '') }}</textarea>
                    @error('tv_plan_description_en')
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
                                    name="packages[{{ $index }}][name]" class="form-control"
                                    value="{{ $package->getTranslation('name', 'ka') }}" required>
                                @error("packages.{$index}.name")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label for="packages[{{ $index }}][name_en]">Package Name (EN)</label>
                                <input type="text" id="packages[{{ $index }}][name_en]"
                                    name="packages[{{ $index }}][name_en]" class="form-control"
                                    value="{{ $package->getTranslation('name', 'en') }}" required>
                                @error("packages.{$index}.name_en")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label for="packages[{{ $index }}][price]">Package Price</label>
                                <input type="number" id="packages[{{ $index }}][price]"
                                    name="packages[{{ $index }}][price]" class="form-control" step="0.01"
                                    value="{{ $package->price }}" required>
                                @error("packages.{$index}.price")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="button" class="btn btn-danger remove-package">Remove Package</button>
                            </div>
                        @empty
                            <p>No packages available.</p>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-package">Add Package</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Plan</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#plan_type_id').on('change', function() {
                var fiberOpticId = $(this).data('fiber-optic-id');
                if ($(this).val() == fiberOpticId) {
                    $('#tv-plan-fields').show();
                } else {
                    $('#tv-plan-fields').hide();
                }
            });

            $(document).on('click', '.remove-package', function() {
                $(this).closest('.package-form').remove();
            });
        });
    </script>
@endsection
