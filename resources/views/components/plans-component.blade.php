<div class="container-fluid">
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-4 mb-4">
                <div x-data="slideIn" x-init="init()" x-bind:class="{ 'show': show }"
                    class="card slide-in-card border-light shadow-sm">
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
