<!-- resources/views/welcome.blade.php -->

<x-main-layout>
    <x-slider :sliders="$sliders" />
    <x-news-component :latestNews="$latestNews" />

    <div class="container-fluid mt-4">
        <h1 class="mb-4">Our Amazing Plans</h1>
        <div class="row">
            @foreach ($plans as $plan)
                <div class="col-12 col-md-4 mb-4">
                    <x-plan-component :plan="$plan" :tvPlan="$plan->tvPlans->first()" />
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
