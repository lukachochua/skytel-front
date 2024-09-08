@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Edit Plan') }}</h1>

        <form action="{{ route('plans.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Plan Name and Description --}}
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Plan Name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $plan->name) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $plan->description) }}</textarea>
            </div>

            {{-- Plan Type --}}
            <div class="mb-3">
                <label for="plan_type_id" class="form-label">{{ __('Plan Type') }}</label>
                <select name="plan_type_id" id="plan_type_id" class="form-select"
                    x-on:change="fiberOptic = ($event.target.value == {{ $fiberOpticTypeId }})">
                    @foreach ($planTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ old('plan_type_id', $plan->plan_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TV Plan Fields (only for Fiber Optic) --}}
            <div x-data="{ fiberOptic: {{ $plan->plan_type_id == $fiberOpticTypeId ? 'true' : 'false' }} }">
                <div x-show="fiberOptic" class="mt-3">
                    <h4>{{ __('TV Plan') }}</h4>

                    <div class="mb-3">
                        <label for="tv_plan_name" class="form-label">{{ __('TV Plan Name') }}</label>
                        <input type="text" name="tv_plan_name" id="tv_plan_name" class="form-control"
                            value="{{ old('tv_plan_name', $plan->tvPlans->first()->name ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tv_plan_description" class="form-label">{{ __('TV Plan Description') }}</label>
                        <textarea name="tv_plan_description" id="tv_plan_description" class="form-control">{{ old('tv_plan_description', $plan->tvPlans->first()->description ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tv_plan_price" class="form-label">{{ __('TV Plan Price') }}</label>
                        <input type="text" name="tv_plan_price" id="tv_plan_price" class="form-control"
                            value="{{ old('tv_plan_price', $plan->tvPlans->first()->price ?? '') }}">
                    </div>

                    {{-- Package Fields --}}
                    <h5>{{ __('Packages') }}</h5>
                    <div id="packages">
                        @foreach (old('packages', $plan->tvPlans->first()->packages ?? []) as $index => $package)
                            <div class="mb-3">
                                <label class="form-label">{{ __('Package Name') }}</label>
                                <input type="text" name="packages[{{ $index }}][name]" class="form-control"
                                    value="{{ $package['name'] }}">
                                <label class="form-label">{{ __('Package Price') }}</label>
                                <input type="text" name="packages[{{ $index }}][price]" class="form-control"
                                    value="{{ $package['price'] }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
        </form>
    </div>
@endsection
