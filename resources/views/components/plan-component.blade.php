<div x-data="fadeInOnScroll()" x-show="show" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    class="plan-card border-light shadow-lg mt-2 mb-5 p-4 rounded h-100 ">

    <div class="plan-card-body">
        <h5 class="plan-card-title">{{ $plan->name }}</h5>
        <p class="plan-card-description">{{ $plan->description }}</p>
        <p class="plan-card-price">${{ number_format($plan->price, 2) }}</p>
        @if ($tvPlan)
            <p class="plan-card-tv-plan">TV Plan: {{ $tvPlan->name }}</p>
        @endif
        <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-primary">Learn More</a>
    </div>
</div>
