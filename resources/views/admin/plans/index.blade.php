@extends('layouts.app')

@section('title', 'Plans')

@section('content_header')
    <h1>Plans</h1>
@stop

@section('content')
    <a href="{{ route('plans.create') }}" class="btn btn-primary">Add New Plan</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
                <tr>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->description }}</td>
                    <td>{{ $plan->price }}</td>
                    <td>{{ $plan->type }}</td>
                    <td>
                        <a href="{{ route('plans.edit', $plan) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('plans.destroy', $plan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
