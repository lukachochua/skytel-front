@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Plan</h1>
        <form action="{{ route('plans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Plan Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="Fiber Optic">Fiber Optic</option>
                    <option value="WiFi/Radio">WiFi/Radio</option>
                    <option value="Corporate">Corporate</option>
                </select>
            </div>
            <div id="tv-plan-fields" class="form-group" style="display: none;">
                <h3>TV Plan Details</h3>
                <div class="form-group">
                    <label for="tv_plan_name">TV Plan Name</label>
                    <input type="text" id="tv_plan_name" name="tv_plan_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tv_plan_description">TV Plan Description</label>
                    <textarea id="tv_plan_description" name="tv_plan_description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="tv_plan_price">TV Plan Price</label>
                    <input type="number" id="tv_plan_price" name="tv_plan_price" class="form-control">
                </div>
                <div id="package-fields">
                    <h4>Packages</h4>
                    <div id="packages-container">
                        <div class="form-group package-form">
                            <label for="packages[0][name]">Package Name</label>
                            <input type="text" id="packages[0][name]" name="packages[0][name]" class="form-control">
                            <label for="packages[0][price]">Package Price</label>
                            <input type="number" id="packages[0][price]" name="packages[0][price]" class="form-control">
                        </div>
                    </div>
                    <button type="button" id="add-package" class="btn btn-secondary">Add Another Package</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Plan</button>
        </form>
    </div>

    <script>
        document.getElementById('type').addEventListener('change', function() {
            var tvPlanFields = document.getElementById('tv-plan-fields');
            if (this.value === 'Fiber Optic') {
                tvPlanFields.style.display = 'block';
            } else {
                tvPlanFields.style.display = 'none';
            }
        });

        document.getElementById('add-package').addEventListener('click', function() {
            var container = document.getElementById('packages-container');
            var index = container.querySelectorAll('.package-form').length;
            var newPackage = `
            <div class="form-group package-form">
                <label for="packages[${index}][name]">Package Name</label>
                <input type="text" id="packages[${index}][name]" name="packages[${index}][name]" class="form-control">
                <label for="packages[${index}][price]">Package Price</label>
                <input type="number" id="packages[${index}][price]" name="packages[${index}][price]" class="form-control">
            </div>
        `;
            container.insertAdjacentHTML('beforeend', newPackage);
        });
    </script>
@endsection
