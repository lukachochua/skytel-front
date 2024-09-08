<x-main-layout>
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

        <a href="{{ route('plans.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

</x-main-layout>
