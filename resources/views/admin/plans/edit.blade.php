@extends('adminlte::page')

@section('title', 'Edit Plan')

@section('content_header')
    <h1>Edit Plan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('plans.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $plan->name }}" required>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="fiber_optic" {{ $plan->type === 'fiber_optic' ? 'selected' : '' }}>Fiber Optic</option>
                        <option value="wireless" {{ $plan->type === 'wireless' ? 'selected' : '' }}>Wireless</option>
                        <option value="tv" {{ $plan->type === 'tv' ? 'selected' : '' }}>TV</option>
                        <option value="corporate" {{ $plan->type === 'corporate' ? 'selected' : '' }}>Corporate</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" {{ $plan->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $plan->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ $plan->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="setanta">Setanta</label>
                    <input type="checkbox" name="setanta" id="setanta" {{ $plan->setanta ? 'checked' : '' }}>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop