@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Plans</h1>
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
                @foreach ($plans as $plan)
                    <tr>
                        <td>{{ $plan->name }}</td>
                        <td>{{ $plan->description }}</td>
                        <td>{{ $plan->price }}</td>
                        <td>{{ $plan->type }}</td>
                        <td>
                            <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('home.plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('home.plans.destroy', $plan->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $plans->links() }}
    </div>
@endsection
