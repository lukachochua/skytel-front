<x-main-layout>
    <h1 class="mb-4">Plans Overview</h1>

    <div class="row container">
        @foreach ($plans as $plan)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-light">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->name }}</h5>
                        <p class="card-text">{{ Str::limit($plan->description, 100) }}</p>
                        <p class="card-text"><strong>Price:</strong> ${{ number_format($plan->price, 2) }}</p>
                        <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-main-layout>
