@extends('adminlte::page')

@section('title', 'Plans')

@section('content_header')
    <h1>Plans</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('plans.create') }}" class="btn btn-primary">Add New Plan</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
                            <td>{{ ucfirst($plan->type) }}</td>
                            <td>{{ ucfirst($plan->status) }}</td>
                            <td>
                                <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
