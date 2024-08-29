<x-main-layout>
    <div class="container">
        <h1>Our Plans</h1>
        <div class="row">
            @foreach ($plans as $plan)

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $plan->name }}</h5>
                            <p class="card-text">{{ $plan->description }}</p>
                            <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
