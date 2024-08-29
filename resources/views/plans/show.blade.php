<x-main-layout>
    <div class="container" style="margin-top: 80px;">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title">{{ $plan->name }}</h1>
            </div>
            <div class="card-body">
                <p><strong>Type:</strong> {{ ucfirst($plan->type) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($plan->status) }}</p>
                <p>{{ $plan->description }}</p>
                @if ($plan->setanta)
                    <div class="alert alert-info" role="alert">
                        <strong>Includes Setanta Sports</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h2 class="card-title">Plan Options</h2>
            </div>
            <div class="card-body">
                @forelse ($plan->planOptions as $planOption)
                    <div class="mb-3 border p-3 rounded">
                        <h3>{{ $planOption->name }}</h3>
                        <p><strong>Price:</strong> ${{ number_format($planOption->price / 100, 2) }}</p>
                        <p><strong>Description:</strong> {{ $planOption->description }}</p>
                    </div>
                @empty
                    <p>No options available for this plan.</p>
                @endforelse
            </div>
        </div>

        <a href="{{ route('plans.index') }}" class="btn btn-secondary mt-3">Back to Plans</a>
    </div>
</x-main-layout>
