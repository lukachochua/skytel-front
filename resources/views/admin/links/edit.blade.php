@extends('layouts.app')

@section('subtitle', __('links.edit'))
@section('content_header_title', __('links.dashboard'))
@section('content_header_subtitle', __('links.edit_link'))

@section('content_body')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ __('links.edit') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('links.update', $link->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="label" class="form-label">@lang('links.label_ka')</label>
                        <input type="text" name="label" id="label" class="form-control"
                            value="{{ $link->getTranslation('label', 'ka') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="label_en" class="form-label">@lang('links.label_en')</label>
                        <input type="text" name="label_en" id="label_en" class="form-control"
                            value="{{ $link->getTranslation('label', 'en') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">@lang('links.url')</label>
                        <input type="url" name="url" id="url" class="form-control" value="{{ $link->url }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">@lang('links.type')</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="navbar" {{ $link->type == 'navbar' ? 'selected' : '' }}>@lang('links.navbar')
                            </option>
                            <option value="footer" {{ $link->type == 'footer' ? 'selected' : '' }}>@lang('links.footer')
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">@lang('links.update')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
