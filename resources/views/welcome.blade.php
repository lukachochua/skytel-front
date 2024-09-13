<x-main-layout>
    <x-slider :sliders="$sliders" />
    <x-news-component :latestNews="$latestNews" />

    <div class="container-fluid mt-4">
        <h1 class="mb-4 text-center display-4 fw-bold text-primary bg-light py-3 rounded shadow-sm">
            {{ __('plans.our_plans') }}
        </h1>
        <div class="row">
            @foreach ($plans as $plan)
                <div class="col-12 col-md-4 mb-4">
                    <x-plan-component :plan="$plan" :tvPlan="$plan->tvPlans->first()" />
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
