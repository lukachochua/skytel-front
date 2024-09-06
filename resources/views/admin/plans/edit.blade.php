@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Plan</h1>
        <form action="{{ route('plans.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Plan Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $plan->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required>{{ $plan->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ $plan->price }}"
                    required>
            </div>

            <div class="form-group">
                <label for="plan_type_id">Type</label>
                <select id="plan_type_id" name="plan_type_id" class="form-control" required>
                    @foreach ($planTypes as $type)
                        <option value="{{ $type->id }}" {{ $plan->plan_type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Display TV Plan Fields only if the type is Fiber Optic --}}
            <div id="tv-plan-fields" style="display: {{ $plan->plan_type_id == $fiberOpticTypeId ? 'block' : 'none' }};">
                <h3>TV Plan Details</h3>
                @if ($tvPlan)
                    <div class="form-group">
                        <label for="tv_plan_name">TV Plan Name</label>
                        <input type="text" id="tv_plan_name" name="tv_plan_name" class="form-control"
                            value="{{ $tvPlan->name }}">
                    </div>
                    <div class="form-group">
                        <label for="tv_plan_description">TV Plan Description</label>
                        <textarea id="tv_plan_description" name="tv_plan_description" class="form-control">{{ $tvPlan->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tv_plan_price">TV Plan Price</label>
                        <input type="number" id="tv_plan_price" name="tv_plan_price" class="form-control"
                            value="{{ $tvPlan->price }}">
                    </div>

                    <div id="package-fields">
                        <h4>Packages</h4>
                        <div id="packages-container">
                            @if ($tvPlan->packages->isNotEmpty())
                                @foreach ($tvPlan->packages as $index => $package)
                                    <div class="form-group package-form" data-index="{{ $index }}">
                                        <label for="packages[{{ $index }}][name]">Package Name</label>
                                        <input type="text" id="packages[{{ $index }}][name]"
                                            name="packages[{{ $index }}][name]" class="form-control"
                                            value="{{ $package->name }}">
                                        <label for="packages[{{ $index }}][price]">Package Price</label>
                                        <input type="number" id="packages[{{ $index }}][price]"
                                            name="packages[{{ $index }}][price]" class="form-control"
                                            value="{{ $package->price }}">
                                        <button type="button" class="btn btn-danger remove-package">Remove Package</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                    </div>
                @else
                    <p>No TV Plan details available.</p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Plan</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var planTypeSelect = document.getElementById('plan_type_id');
            var tvPlanFields = document.getElementById('tv-plan-fields');
            var packagesContainer = document.getElementById('packages-container');
            var addPackageButton = document.getElementById('add-package');


            planTypeSelect.addEventListener('change', function() {
                if (this.value == {{ $fiberOpticTypeId }}) { // Assuming Fiber Optic type ID
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
                packageCount++; // Increment the package count
            });

            packagesContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-package')) {
                    event.target.closest('.package-form').remove();
                }
            });

            // Trigger change event on page load to show/hide TV Plan fields based on selected type
            planTypeSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
