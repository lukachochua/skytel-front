<x-main-layout>
    <div class="container mt-4">
        <h1 class="mb-4 mt-5 text-center display-4 fw-bold text-secondary">
            Plans Overview
        </h1>
        <div class="row">
            @foreach ($plans as $plan)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $plan->name }}</h5>
                            <p class="card-text flex-grow-1">{{ Str::limit($plan->description, 100) }}</p>
                            <p class="card-text"><strong>Price:</strong> ${{ number_format($plan->price, 2) }}</p>
                            <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-primary mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
