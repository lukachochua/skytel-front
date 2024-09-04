@extends('layouts.app')
@section('title', 'Edit Plan')

@section('content_header')
    <h1>Edit Plan</h1>
@stop

@section('content')
    <form action="{{ route('plans.update', $plan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $plan->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $plan->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $plan->price }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ $plan->type }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@stop