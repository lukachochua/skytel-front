@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Plan Details</h1>
        <div class="card">
            <div class="card-body">
                <h2>{{ $plan->name }}</h2>
                <p>{{ $plan->description }}</p>
                <p>Price: {{ $plan->price }}</p>
                <p>Type: {{ $plan->type }}</p>
                @if ($plan->type === 'Fiber Optic')
                    @if ($plan->tvPlans->isNotEmpty())
                        @php $tvPlan = $plan->tvPlans->first(); @endphp
                        <h3>TV Plan Details</h3>
                        <p>TV Plan Name: {{ $tvPlan->name }}</p>
                        <p>TV Plan Description: {{ $tvPlan->description }}</p>
                        <p>TV Plan Price: {{ $tvPlan->price }}</p>
                        @if ($tvPlan->packages->isNotEmpty())
                            <h4>Packages</h4>
                            <ul>
                                @foreach ($tvPlan->packages as $package)
                                    <li>{{ $package->name }} - {{ $package->price }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                @endif
                <a href="{{ route('home.plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('home.plans.index') }}" class="btn btn-secondary">Back to Plans</a>
            </div>
        </div>
    </div>
@endsection
