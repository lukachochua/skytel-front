<x-main-layout>
    <div class="container">
        <h1>Plan Details</h1>
        <div class="card">
            <div class="card-body">
                <h2>{{ $plan->name }}</h2>
                <p>{{ $plan->description }}</p>
                <p>Price: {{ $plan->price }}</p>
                <p>Type: {{ $plan->planType->name }}</p>

                @if ($plan->plan_type_id == 2)
                    @if ($plan->tvPlans->isNotEmpty())
                        <h3>TV Plan Details</h3>
                        <p>TV Plan Name: {{ $tvPlan->name }}</p>
                        <p>TV Plan Description: {{ $tvPlan->description }}</p>
                        <p>TV Plan Price: {{ $tvPlan->price }}</p>
                        @if ($tvPlan->packages->isNotEmpty())
                            <h4>Packages</h4>
                            <ul>
                                @foreach ($tvPlan->packages as $package)
                                    <li>{{ $package->name }} - {{ $package->price }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @else
                        <p>No TV Plan details available.</p>
                    @endif
                @else
                    <p>No additional details available for this plan type.</p>
                @endif

                <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('plans.index') }}" class="btn btn-secondary">Back to Plans</a>
            </div>
        </div>
    </div>
</x-main-layout>
