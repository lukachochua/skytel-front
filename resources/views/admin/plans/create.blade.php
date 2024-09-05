@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Plan</h1>
        <form action="{{ route('plans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Plan Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="plan_type_id">Type</label>
                <select id="plan_type_id" name="plan_type_id" class="form-control" required>
                    <option value="">Select Plan Type</option>
                    @foreach ($planTypes as $planType)
                        <option value="{{ $planType->id }}" {{ old('plan_type_id') == $planType->id ? 'selected' : '' }}>
                            {{ $planType->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TV Plan Fields, displayed only for "Fiber Optic" type -->
            <div id="tv-plan-fields" class="form-group" style="display: none;">
                <h3>TV Plan Details</h3>
                <div class="form-group">
                    <label for="tv_plan_name">TV Plan Name</label>
                    <input type="text" id="tv_plan_name" name="tv_plan_name" class="form-control"
                        value="{{ old('tv_plan_name') }}">
                </div>
                <div class="form-group">
                    <label for="tv_plan_description">TV Plan Description</label>
                    <textarea id="tv_plan_description" name="tv_plan_description" class="form-control">{{ old('tv_plan_description') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tv_plan_price">TV Plan Price</label>
                    <input type="number" id="tv_plan_price" name="tv_plan_price" class="form-control"
                        value="{{ old('tv_plan_price') }}">
                </div>

                <!-- Package Fields -->
                <div id="package-fields">
                    <h4>Packages</h4>
                    <div id="packages-container">
                        <div class="form-group package-form">
                            <label for="packages[0][name]">Package Name</label>
                            <input type="text" id="packages[0][name]" name="packages[0][name]" class="form-control">
                            <label for="packages[0][price]">Package Price</label>
                            <input type="number" id="packages[0][price]" name="packages[0][price]" class="form-control">
                        </div>
                    </div>
                    <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Plan</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typeSelect = document.getElementById('plan_type_id');
            var tvPlanFields = document.getElementById('tv-plan-fields');
            var packagesContainer = document.getElementById('packages-container');
            var addPackageButton = document.getElementById('add-package');
            var packageCount = 1;

            // Initialize display based on current type
            if (typeSelect.value === '{{ $fiberOpticTypeId }}') {
                tvPlanFields.style.display = 'block';
            }

            typeSelect.addEventListener('change', function() {
                if (this.value === '{{ $fiberOpticTypeId }}') {
                    tvPlanFields.style.display = 'block';
                } else {
                    tvPlanFields.style.display = 'none';
                }
            });

            addPackageButton.addEventListener('click', function() {
                var packageForm = document.createElement('div');
                packageForm.classList.add('form-group', 'package-form');
                packageForm.setAttribute('data-index', packageCount);

                packageForm.innerHTML = `
                    <label for="packages[${packageCount}][name]">Package Name</label>
                    <input type="text" id="packages[${packageCount}][name]" name="packages[${packageCount}][name]" class="form-control">
                    <label for="packages[${packageCount}][price]">Package Price</label>
                    <input type="number" id="packages[${packageCount}][price]" name="packages[${packageCount}][price]" class="form-control">
                    <button type="button" class="btn btn-danger remove-package">Remove Package</button>
                `;

                packagesContainer.appendChild(packageForm);
                packageCount++;
            });

            packagesContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-package')) {
                    event.target.closest('.package-form').remove();
                }
            });
        });
    </script>
@endsection
