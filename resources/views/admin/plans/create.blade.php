@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Plan</h1>
        <form action="{{ route('plans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Plan Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Plan Name (EN)</label>
                <input type="text" id="name_en" name="name_en"
                    class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
                @error('name_en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description_en">Description (EN)</label>
                <textarea id="description_en" name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                    required>{{ old('description_en') }}</textarea>
                @error('description_en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price"
                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="plan_type_id">Type</label>

                <select id="plan_type_id" name="plan_type_id"
                    class="form-control @error('plan_type_id') is-invalid @enderror" required
                    data-fiber-optic-id="{{ $fiberOpticTypeId }}">
                    <option value="">Select Plan Type</option>
                    @foreach ($planTypes as $planType)
                        <option value="{{ $planType->id }}" {{ old('plan_type_id') == $planType->id ? 'selected' : '' }}>
                            {{ $planType->name }}
                        </option>
                    @endforeach
                </select>

                @error('plan_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- TV Plan Fields, displayed only for "Fiber Optic" type -->
            <div id="tv-plan-fields" class="form-group" style="display: none;">
                <h3>TV Plan Details</h3>
                <div class="form-group">
                    <label for="tv_plan_name">TV Plan Name</label>
                    <input type="text" id="tv_plan_name" name="tv_plan_name"
                        class="form-control @error('tv_plan_name') is-invalid @enderror" value="{{ old('tv_plan_name') }}">
                    @error('tv_plan_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tv_plan_name">TV Plan Name (EN)</label>
                    <input type="text" id="tv_plan_name_en" name="tv_plan_name_en"
                        class="form-control @error('tv_plan_name_en') is-invalid @enderror"
                        value="{{ old('tv_plan_name_en') }}">
                    @error('tv_plan_name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tv_plan_description">TV Plan Description</label>
                    <textarea id="tv_plan_description" name="tv_plan_description"
                        class="form-control @error('tv_plan_description') is-invalid @enderror">{{ old('tv_plan_description') }}</textarea>
                    @error('tv_plan_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tv_plan_description">TV Plan Description (EN)_en</label>
                    <textarea id="tv_plan_description_en" name="tv_plan_description_en"
                        class="form-control @error('tv_plan_description_en') is-invalid @enderror">{{ old('tv_plan_description_en') }}</textarea>
                    @error('tv_plan_description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tv_plan_price">TV Plan Price</label>
                    <input type="number" id="tv_plan_price" name="tv_plan_price"
                        class="form-control @error('tv_plan_price') is-invalid @enderror"
                        value="{{ old('tv_plan_price') }}">
                    @error('tv_plan_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Package Fields -->
                <div id="package-fields">
                    <h4>Packages</h4>
                    <div id="packages-container">
                        <div class="form-group package-form">
                            <label for="packages[0][name]">Package Name</label>
                            <input type="text" id="packages[0][name]" name="packages[0][name]"
                                class="form-control @error('packages.*.name') is-invalid @enderror">
                            @error('packages.*.name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="packages[0][name_en]">Package Name (EN)</label>
                            <input type="text" id="packages[0][name_en]" name="packages[0][name_en]"
                                class="form-control @error('packages.*.name_en') is-invalid @enderror">
                            @error('packages.*.name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="packages[0][price]">Package Price</label>
                            <input type="number" id="packages[0][price]" name="packages[0][price]"
                                class="form-control @error('packages.*.price') is-invalid @enderror">
                            @error('packages.*.price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Plan</button>
        </form>
    </div>
@endsection
