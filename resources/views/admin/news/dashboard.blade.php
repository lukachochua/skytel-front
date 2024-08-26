@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('news.news_list'))
@section('content_header_title', __('news.dashboard'))
@section('content_header_subtitle', __('news.news_list'))

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
                <a href="{{ route('news.create') }}" class="btn btn-primary w-auto">
                    <i class="fas fa-plus"></i> @lang('news.create')
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">@lang('news.all_news')</h3>
                    </div>
                    <div class="card-body p-0">
                        <!-- Table wrapper with scroll and height constraints -->
                        <div class="table-wrapper" style="max-height: 60vh; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">#</th>
                                        <th>@lang('news.title')</th>
                                        <th class="w-2">@lang('news.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($news as $newsItem)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('news.show', $newsItem->id) }}" class="text-primary">
                                                    {{ $newsItem->title }}
                                                </a>
                                            </td>
                                            <td class="d-flex flex-column flex-sm-row align-items-center">
                                                <a href="{{ route('news.edit', $newsItem->id) }}"
                                                    class="btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2 w-100 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-edit me-1"></i> @lang('news.edit')
                                                </a>
                                                <form action="{{ route('news.destroy', $newsItem->id) }}" method="POST"
                                                    class="d-inline w-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-trash me-1"></i> @lang('news.delete')
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            {{ $news->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
