<x-main-layout>
    @if (session('success'))
        <x-success-message>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </x-success-message>
    @endif

    <div class="container mt-5 mb-5" x-data="planForm()">
        <h1 class="mb-4">Plan Details</h1>

        <div class="card mb-4 shadow border-light">
            <div class="card-body">
                <h2 class="card-title">{{ $plan->name }}</h2>
                <p class="card-text">{{ $plan->description }}</p>
                <p class="card-text"><strong>Price:</strong> ${{ number_format($plan->price, 2) }}</p>
                <p class="card-text"><strong>Type:</strong> {{ $plan->planType->name }}</p>

                @if ($plan->plan_type_id == $fiberOpticType->id)
                    @if ($plan->tvPlans->count() > 0)
                        <div class="mt-4 pt-3 border-top">
                            <h3>TV Plan Details</h3>
                            <p><strong>Name:</strong> {{ $plan->tvPlans->first()->name }}</p>
                            <p><strong>Description:</strong> {{ $plan->tvPlans->first()->description }}</p>
                            <p><strong>Price:</strong> ${{ number_format($plan->tvPlans->first()->price, 2) }}</p>

                            @if ($plan->tvPlans->first()->packages->count() > 0)
                                <h4 class="mt-4">Packages</h4>
                                <ul class="list-group">
                                    @foreach ($plan->tvPlans->first()->packages as $package)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>{{ $package->name }}</strong>
                                            <span
                                                class="badge bg-secondary">${{ number_format($package->price, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No packages available for this TV plan.</p>
                            @endif
                        </div>
                    @else
                        <p class="text-muted">No TV plans available for this plan.</p>
                    @endif
                @endif

                <!-- Order Button -->
                <button @click="toggleModal" class="btn btn-primary mt-4">
                    Order
                </button>
            </div>
        </div>

        <!-- Modal Overlay -->
        <x-modal>
            <!-- Modal Form -->
            <form action="{{ route('plans.storeSelection', $plan->id) }}" method="POST"
                class="bg-light p-4 rounded border z-50">
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
                    <label for="plan" class="form-label">Selected Plan</label>
                    <input type="text" id="plan" name="plan" value="{{ $plan->name }}"
                        class="form-control" readonly>
                </div>

                <!-- TV Plan Selection -->
                @if ($plan->plan_type_id == $fiberOpticType->id && $plan->tvPlans->count() > 0)
                    <div class="mb-3">
                        <label for="tvPlan" class="form-label">Select TV Plan</label>
                        <select id="tvPlan" name="tv_plan_id" class="form-select" x-model="selectedTvPlan"
                            @change="updatePackages">
                            <option value="">None</option>
                            @foreach ($plan->tvPlans as $tvPlan)
                                <option value="{{ $tvPlan->id }}">{{ $tvPlan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Package Selection -->
                <div class="mb-3">
                    <label class="form-label">Select Packages</label>
                    @if ($plan->tvPlans->count() > 0)
                        @php
                            $firstTvPlan = $plan->tvPlans->first();
                        @endphp
                        @if ($firstTvPlan->packages->count() > 0)
                            @foreach ($firstTvPlan->packages as $package)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="packages[]"
                                        value="{{ $package->id }}" id="package{{ $package->id }}"
                                        :disabled="!selectedTvPlan">
                                    <label class="form-check-label" for="package{{ $package->id }}">
                                        {{ $package->name }} - ${{ number_format($package->price, 2) }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No packages available for the selected TV plan.</p>
                        @endif
                    @else
                        <p class="text-muted">No TV plans available for this plan.</p>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Save Selection</button>
            </form>
        </x-modal>

        <a href="{{ route('plans.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.planFormData = @json($packages);
        });
    </script>
</x-main-layout>
