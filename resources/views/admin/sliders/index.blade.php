@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('slider.slider_list'))
@section('content_header_title', __('slider.manage_sliders'))
@section('content_header_subtitle', __('slider.slider_list'))

{{-- Content body: main page content --}}
@section('content_body')
    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('sliders.create') }}" class="btn btn-primary w-auto">
                    <i class="fas fa-plus"></i> @lang('slider.create')
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">@lang('slider.all_sliders')</h3>
                    </div>
                    <div class="card-body p-0">
                        <!-- Table wrapper with scroll and height constraints -->
                        <div class="table-wrapper" style="max-height: 60vh; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">#</th>
                                        <th>@lang('slider.title')</th>
                                        <th>@lang('slider.description')</th>
                                        <th>@lang('slider.image')</th>
                                        <th class="w-2">@lang('slider.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)
                                        <tr>
                                            <td>{{ $slider->order }}</td>
                                            <td>{{ $slider->title }}</td>
                                            <td>{{ $slider->description }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $slider->image) }}"
                                                    alt="{{ $slider->title }}" class="img-thumbnail"
                                                    style="max-width: 100px;">
                                            </td>
                                            <td class="d-flex flex-column flex-sm-row align-items-center">
                                                <a href="{{ route('sliders.edit', $slider->id) }}"
                                                    class="btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2 w-100 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-edit me-1"></i> @lang('slider.edit')
                                                </a>
                                                <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST"
                                                    class="d-inline w-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-trash me-1"></i> @lang('slider.delete')
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- <div class="card-footer d-flex justify-content-between">
                        <div>
                            {{ $sliders->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@stop
