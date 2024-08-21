@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('news.news_list'))
@section('content_header_title', __('home'))
@section('content_header_subtitle', __('news.news_list'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="container">
        <div>
            <a href="{{ route('news.create') }}" class="btn btn-primary mb-1">
                <i class="fas fa-plus"></i> @lang('news.create')
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('news.all_news')</h3>
            </div>
            <div class="card-body p-0">
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
                                <td class="d-flex">
                                    <a href="{{ route('news.edit', $newsItem->id) }}" class="btn btn-warning btn-sm mr-2">
                                        <i class="fas fa-edit"></i> @lang('news.edit')
                                    </a>
                                    <form action="{{ route('news.destroy', $newsItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> @lang('news.delete')
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $news->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
