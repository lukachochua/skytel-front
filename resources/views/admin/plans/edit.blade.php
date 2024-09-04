@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Plan</h1>
        <form action="{{ route('home.plans.update', $plan->id) }}" method="POST">
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
            @if ($plan->type === 'Fiber Optic')
                <div id="tv-plan-fields">
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
                                @foreach ($tvPlan->packages as $index => $package)
                                    <div class="form-group package-form">
                                        <label for="packages[{{ $index }}][name]">Package Name</label>
                                        <input type="text" id="packages[{{ $index }}][name]"
                                            name="packages[{{ $index }}][name]" class="form-control"
                                            value="{{ $package->name }}">
                                        <label for="packages[{{ $index }}][price]">Package Price</label>
                                        <input type="number" id="packages[{{ $index }}][price]"
                                            name="packages[{{ $index }}][price]" class="form-control"
                                            value="{{ $package->price }}">
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                        </div>
                    @endif
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Update Plan</button>
        </form>
    </div>

    <script>
        document.getElementById('type').addEventListener('change', function() {
            var tvPlanFields = document.getElementById('tv-plan-fields');
            if (this.value === 'Fiber Optic') {
                tvPlanFields.style.display = 'block';
            } else {
                tvPlanFields.style.display = 'none';
            }
        });
    </script>
@endsection
