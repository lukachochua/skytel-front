<x-main-layout>

    @if (session('success'))
        <x-success-message>
            <div class="z-3">
               {{ session('success') }}
            </div>
        </x-success-message>
    @endif
    <div class="container mt-4 mb-4">
        <h1 class="mb-4 mt-4">Plan Details</h1>

        <div class="card mb-4 shadow-sm border-light">
            <div class="card-body">
                <h2 class="card-title">{{ $plan->name }}</h2>
                <p class="card-text">{{ $plan->description }}</p>
                <p class="card-text"><strong>Price:</strong> ${{ number_format($plan->price, 2) }}</p>
                <p class="card-text"><strong>Type:</strong> {{ $plan->planType->name }}</p>

                @if ($plan->plan_type_id == $fiberOpticType->id && $plan->tvPlans->count() > 0)
                    <div class="mt-4 border-top pt-3">
                        <h3>TV Plan Details</h3>
                        <p><strong>Name:</strong> {{ $plan->tvPlans->first()->name }}</p>
                        <p><strong>Description:</strong> {{ $plan->tvPlans->first()->description }}</p>
                        <p><strong>Price:</strong> ${{ number_format($plan->tvPlans->first()->price, 2) }}</p>

                        @if ($plan->tvPlans->first()->packages->count() > 0)
                            <h4 class="mt-4">Packages</h4>
                            <ul class="list-group">
                                @foreach ($plan->tvPlans->first()->packages as $package)
                                    <li class="list-group-item">
                                        <strong>{{ $package->name }}</strong>
                                        <span class="float-end">${{ number_format($package->price, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Form for selecting options and providing personal info -->
        <form action="{{ route('plans.storeSelection', $plan->id) }}" method="POST">
            @csrf

            <!-- Personal Information -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>

            <!-- Plan Selection -->
            <div class="mb-3">
                <label for="plan" class="form-label">Select Plan</label>
                <input type="text" id="plan" name="plan" value="{{ $plan->name }}" class="form-control"
                    readonly>
            </div>

            <!-- TV Plan Selection -->
            @if ($plan->plan_type_id == $fiberOpticType->id && $plan->tvPlans->count() > 0)
                <div class="mb-3">
                    <label for="tvPlan" class="form-label">Select TV Plan</label>
                    <select id="tvPlan" name="tv_plan_id" class="form-select">
                        <option value="">None</option>
                        @foreach ($plan->tvPlans as $tvPlan)
                            <option value="{{ $tvPlan->id }}">{{ $tvPlan->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Package Selection -->
            @if ($plan->tvPlans->count() > 0 && $plan->tvPlans->first()->packages->count() > 0)
                <div class="mb-3">
                    <label class="form-label">Select Packages</label>
                    @foreach ($plan->tvPlans->first()->packages as $package)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="packages[]"
                                value="{{ $package->id }}" id="package{{ $package->id }}">
                            <label class="form-check-label" for="package{{ $package->id }}">
                                {{ $package->name }} - ${{ number_format($package->price, 2) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Save Selection</button>
        </form>

        <a href="{{ route('plans.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</x-main-layout>
