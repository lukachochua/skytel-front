@extends('adminlte::page')

@section('title', 'Edit Plan')

@section('content_header')
    <h1>Edit Plan</h1>
@stop

@section('content')
    <div class="container">
        <!-- Displaying success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form to edit the plan -->
        <form action="{{ route('plans.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Plan Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Plan Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Plan Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $plan->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3" required>{{ old('description', $plan->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                            id="price" name="price" value="{{ old('price', $plan->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="plan_type_id">Plan Type</label>
                        <select class="form-control @error('plan_type_id') is-invalid @enderror" id="plan_type_id"
                            name="plan_type_id" required>
                            @foreach ($planTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ $type->id == old('plan_type_id', $plan->plan_type_id) ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('plan_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Conditional TV Plans and Packages -->
            <div id="fiber-optic-fields" class="card mt-4 @if ($fiberOpticTypeId != $plan->plan_type_id) d-none @endif">
                <div class="card-header">
                    <h3 class="card-title">TV Plans</h3>
                </div>
                <div class="card-body">
                    @if ($plan->tvPlans->count())
                        <!-- Display Existing TV Plans -->
                        @foreach ($plan->tvPlans as $tvPlan)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title">TV Plan: {{ $tvPlan->name }}</h4>
                                </div>
                                <div class="card-body">
                                    <p><strong>Description:</strong> {{ $tvPlan->description }}</p>
                                    <p><strong>Price:</strong> {{ $tvPlan->price }}</p>
                                    <a href="{{ route('tvplans.edit', $tvPlan->id) }}" class="btn btn-warning">Edit TV
                                        Plan</a>
                                    <form action="{{ route('tvplans.destroy', $tvPlan->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete TV Plan</button>
                                    </form>
                                </div>

                                <!-- Display Packages for this TV Plan -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title">Packages</h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($tvPlan->packages->count())
                                            <!-- Display Existing Packages -->
                                            @foreach ($tvPlan->packages as $package)
                                                <div class="mb-2">
                                                    <p><strong>Name:</strong> {{ $package->name }}</p>
                                                    <p><strong>Description:</strong> {{ $package->description }}</p>
                                                    <p><strong>Price:</strong> {{ $package->price }}</p>
                                                    <a href="{{ route('packages.edit', $package->id) }}"
                                                        class="btn btn-warning btn-sm">Edit Package</a>
                                                    <form action="{{ route('packages.destroy', $package->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete
                                                            Package</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No packages available for this TV Plan.</p>
                                        @endif

                                        <!-- Form to Add New Package -->
                                        <div class="mt-3">
                                            <h6>Add New Package</h6>
                                            <div class="form-group">
                                                <label for="packages[name]">Package Name</label>
                                                <input type="text" class="form-control" id="packages[name]"
                                                    name="packages[{{ $tvPlan->id }}][name]"
                                                    placeholder="Enter Package Name">
                                            </div>

                                            <div class="form-group">
                                                <label for="packages[description]">Package Description</label>
                                                <textarea class="form-control" id="packages[description]" name="packages[{{ $tvPlan->id }}][description]"
                                                    rows="2" placeholder="Enter Package Description"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="packages[price]">Package Price</label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="packages[price]" name="packages[{{ $tvPlan->id }}][price]"
                                                    placeholder="Enter Package Price">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- No TV Plans Found Message -->
                        <p>No TV Plans available for this Fiber Optic Plan.</p>
                    @endif

                    <!-- Form to Add New TV Plan -->
                    <div id="add-tv-plan" class="mt-4 @if ($plan->tvPlans->count()) d-none @endif">
                        <h5>Add New TV Plan</h5>
                        <div class="form-group">
                            <label for="tv_plans[name]">Name</label>
                            <input type="text" class="form-control" id="tv_plans[name]" name="tv_plans[0][name]"
                                placeholder="Enter TV Plan Name">
                        </div>

                        <div class="form-group">
                            <label for="tv_plans[description]">Description</label>
                            <textarea class="form-control" id="tv_plans[description]" name="tv_plans[0][description]" rows="2"
                                placeholder="Enter TV Plan Description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="tv_plans[price]">Price</label>
                            <input type="number" step="0.01" class="form-control" id="tv_plans[price]"
                                name="tv_plans[0][price]" placeholder="Enter TV Plan Price">
                        </div>
                    </div>

                    <!-- Form to Add New Package (if TV Plan is selected) -->
                    <div id="add-package" class="mt-4 d-none">
                        <h6>Add New Package</h6>
                        <div class="form-group">
                            <label for="package_name">Package Name</label>
                            <input type="text" class="form-control" id="package_name" name="new_package[name]"
                                placeholder="Enter Package Name">
                        </div>

                        <div class="form-group">
                            <label for="package_description">Package Description</label>
                            <textarea class="form-control" id="package_description" name="new_package[description]" rows="2"
                                placeholder="Enter Package Description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="package_price">Package Price</label>
                            <input type="number" step="0.01" class="form-control" id="package_price"
                                name="new_package[price]" placeholder="Enter Package Price">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-4">Update Plan</button>
        </form>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const planTypeSelect = document.getElementById('plan_type_id');
            const fiberOpticFields = document.getElementById('fiber-optic-fields');
            const addTvPlanDiv = document.getElementById('add-tv-plan');
            const addPackageDiv = document.getElementById('add-package');

            function toggleFiberOpticFields() {
                const isFiberOptic = planTypeSelect.value == {{ $fiberOpticTypeId }};
                fiberOpticFields.classList.toggle('d-none', !isFiberOptic);
                addTvPlanDiv.classList.toggle('d-none', !!document.querySelector('.tv-plan-card'));
                addPackageDiv.classList.toggle('d-none', !isFiberOptic || !document.querySelector('.tv-plan-card'));
            }

            // Initial check on page load
            toggleFiberOpticFields();

            // Check on change event
            planTypeSelect.addEventListener('change', toggleFiberOpticFields);
        });
    </script>
@stop
