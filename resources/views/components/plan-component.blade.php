<div x-data="animateOnScroll()"
    x-bind:class="{
        'opacity-0 translate-y-4': !isVisible,
        'opacity-100 translate-y-0': isVisible
    }"
    class="plan-card border-light shadow-lg mt-2 mb-5 p-4 rounded h-100 d-flex flex-column transition-all duration-700 ease-out">

    <div class="plan-card-body flex-grow-1">
        <h5 class="plan-card-title">{{ $plan->name }}</h5>
        <p class="plan-card-description">{{ $plan->description }}</p>
        <p class="plan-card-price">${{ number_format($plan->price, 2) }}</p>
        @if ($tvPlan)
            <p class="plan-card-tv-plan">TV Plan: {{ $tvPlan->name }}</p>
        @endif
    </div>
    <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-primary mt-auto">Learn More</a>
</div>
