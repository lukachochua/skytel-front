@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'News List')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'News List')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="mb-2">
            <a href="{{ route('news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create News
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All News</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Title</th>
                            <th style="width: 200px">Actions</th>
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
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('news.destroy', $newsItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
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
