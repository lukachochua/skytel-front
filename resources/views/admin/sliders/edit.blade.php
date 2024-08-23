@extends('layouts.app')

@section('content')
    <form action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($slider))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $slider->title ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $slider->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if(isset($slider) && $slider->image)
                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-success">{{ isset($slider) ? 'Update' : 'Create' }} Slider</button>
    </form>
@endsection