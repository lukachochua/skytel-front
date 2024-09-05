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
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="Fiber Optic" {{ $plan->type === 'Fiber Optic' ? 'selected' : '' }}>Fiber Optic</option>
                    <option value="WiFi/Radio" {{ $plan->type === 'WiFi/Radio' ? 'selected' : '' }}>WiFi/Radio</option>
                    <option value="Corporate" {{ $plan->type === 'Corporate' ? 'selected' : '' }}>Corporate</option>
                </select>
            </div>

            {{-- Display TV Plan Fields only if the type is Fiber Optic --}}
            <div id="tv-plan-fields" style="display: {{ $plan->type === 'Fiber Optic' ? 'block' : 'none' }};">
                <h3>TV Plan Details</h3>
                @if ($plan->tvPlans->isNotEmpty())
                    @php $tvPlan = $plan->tvPlans->first(); @endphp
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
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Plan</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typeSelect = document.getElementById('type');
            var tvPlanFields = document.getElementById('tv-plan-fields');
            var packagesContainer = document.getElementById('packages-container');
            var addPackageButton = document.getElementById('add-package');
            var packageCount = {{ isset($tvPlan) && $tvPlan->packages ? $tvPlan->packages->count() : 0 }};

            typeSelect.addEventListener('change', function() {
                if (this.value === 'Fiber Optic') {
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
