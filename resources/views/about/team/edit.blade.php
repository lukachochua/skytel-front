@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Team Member: {{ $team->name }}</h1>

        <form action="{{ route('team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $team->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" name="position" id="position" class="form-control"
                    value="{{ old('position', $team->position) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $team->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
                @if ($team->photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $team->photo) }}" alt="{{ $team->name }}"
                            width="150">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-success">Update Team Member</button>
        </form>
    </div>
@endsection
