@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Plan</h1>
        <form action="{{ route('plans.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Plan Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $plan->name) }}"
                    required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description', $plan->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control"
                    value="{{ old('price', $plan->price) }}" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="plan_type_id" class="form-control" required>
                    <option value="1" {{ $plan->plan_type_id === 1 ? 'selected' : '' }}>Fiber Optic</option>
                    <option value="2" {{ $plan->plan_type_id === 2 ? 'selected' : '' }}>WiFi/Radio</option>
                    <option value="3" {{ $plan->plan_type_id === 3 ? 'selected' : '' }}>Corporate</option>
                </select>
            </div>

            <div id="tv-plan-fields" style="display: {{ $plan->plan_type_id === 1 ? 'block' : 'none' }};">
                <h3>TV Plan Details</h3>
                @if ($tvPlan)
                    <div class="form-group">
                        <label for="tv_plan_name">TV Plan Name</label>
                        <input type="text" id="tv_plan_name" name="tv_plan_name" class="form-control"
                            value="{{ old('tv_plan_name', $tvPlan->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="tv_plan_description">TV Plan Description</label>
                        <textarea id="tv_plan_description" name="tv_plan_description" class="form-control">{{ old('tv_plan_description', $tvPlan->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tv_plan_price">TV Plan Price</label>
                        <input type="number" id="tv_plan_price" name="tv_plan_price" class="form-control"
                            value="{{ old('tv_plan_price', $tvPlan->price) }}">
                    </div>

                    <div id="package-fields">
                        <h4>Packages</h4>
                        <div id="packages-container">
                            @foreach ($packages as $index => $package)
                                <div class="form-group package-form" data-id="{{ $package->id }}"
                                    data-index="{{ $index }}">
                                    <label for="packages[{{ $index }}][name]">Package Name</label>
                                    <input type="text" id="packages[{{ $index }}][name]"
                                        name="packages[{{ $index }}][name]" class="form-control"
                                        value="{{ old("packages[$index][name]", $package->name) }}">
                                    <label for="packages[{{ $index }}][price]">Package Price</label>
                                    <input type="number" id="packages[{{ $index }}][price]"
                                        name="packages[{{ $index }}][price]" class="form-control"
                                        value="{{ old("packages[$index][price]", $package->price) }}">
                                    <button type="button" class="btn btn-danger remove-package">Remove Package</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Plan</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var packagesContainer = document.getElementById('packages-container');

            packagesContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-package')) {
                    var packageForm = event.target.closest('.package-form');
                    var packageId = packageForm.getAttribute('data-id');

                    if (packageId) {
                        fetch(`/packages/${packageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    packageForm.remove();
                                } else {
                                    alert('Failed to delete package');
                                }
                            });
                    } else {
                        packageForm.remove(); // If no ID, just remove the form locally
                    }
                }
            });

            var addPackageButton = document.getElementById('add-package');
            var packageCount = {{ $packages->count() }}; // Initialize based on existing packages

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
        });
    </script>
@endsection
