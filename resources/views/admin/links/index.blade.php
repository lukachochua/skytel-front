@extends('layouts.app')

@section('subtitle', __('links.manage'))
@section('content_header_title', __('links.dashboard'))
@section('content_header_subtitle', __('links.manage'))

@section('content_body')
    <div class="container">
        @if (session('success'))
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('links.manage') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Navbar Links Section -->
                    <div class="col-md-6">
                        <h3>{{ __('links.navbar') }}</h3>
                        <ul class="list-group">
                            @foreach ($navbarLinks as $link)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $link->label }} - <a href="{{ route($link->route_name) }}"
                                            target="_blank">{{ route($link->route_name) }}</a></span>
                                    <div>
                                        <a href="{{ route('links.edit', $link->id) }}"
                                            class="btn btn-sm btn-warning">@lang('links.edit')</a>
                                        <form action="{{ route('links.destroy', $link->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">@lang('links.delete')</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Footer Links Section -->
                    <div class="col-md-6">
                        <h3>{{ __('links.footer') }}</h3>
                        <ul class="list-group">
                            @foreach ($footerLinks as $link)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $link->label }} - <a href="{{ route($link->route_name) }}"
                                            target="_blank">{{ route($link->route_name) }}</a></span>
                                    <div>
                                        <a href="{{ route('links.edit', $link->id) }}"
                                            class="btn btn-sm btn-warning">@lang('links.edit')</a>
                                        <form action="{{ route('links.destroy', $link->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">@lang('links.delete')</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Create New Link Section -->
                <div class="mt-4">
                    <form action="{{ route('links.store') }}" method="POST">
                        @csrf
                        <h3>{{ __('links.create_new') }}</h3>

                        <div class="mb-3">
                            <label for="label" class="form-label">@lang('links.label_ka')</label>
                            <input type="text" name="label" id="label" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="label_en" class="form-label">@lang('links.label_en')</label>
                            <input type="text" name="label_en" id="label_en" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="route_name" class="form-label">@lang('links.route_name')</label>
                            <input type="text" name="route_name" id="route_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">@lang('links.type')</label>
                            <select name="type" id="type" class="form-select">
                                <option value="navbar">@lang('links.navbar')</option>
                                <option value="footer">@lang('links.footer')</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">@lang('links.create')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
