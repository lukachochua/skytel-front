@extends('layouts.app')

@section('content')
    <a href="{{ route('sliders.create') }}" class="btn btn-primary mb-3">Create New Slider</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sliders as $slider)
                    <tr>
                        <td>{{ $slider->order }}</td>
                        <td>{{ $slider->title }}</td>
                        <td>{{ $slider->description }}</td>
                        <td><img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" width="100"></td>
                        <td>
                            <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
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
@endsection