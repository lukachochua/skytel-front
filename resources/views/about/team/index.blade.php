@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('team.team_list'))
@section('content_header_title', __('team.dashboard'))
@section('content_header_subtitle', __('team.team_list'))

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
                <a href="{{ route('team.create') }}" class="btn btn-primary w-auto">
                    <i class="fas fa-plus"></i> @lang('team.create')
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">@lang('team.all_team_members')</h3>
                    </div>
                    <div class="card-body p-0">
                        <!-- Table wrapper with scroll and height constraints -->
                        <div class="table-wrapper" style="max-height: 60vh; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-1">#</th>
                                        <th>@lang('team.name')</th>
                                        <th>@lang('team.position')</th>
                                        <th>@lang('team.photo')</th>
                                        <th>@lang('team.description')</th>
                                        <th class="w-2">@lang('team.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teamMembers as $teamMember)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $teamMember->name }}</td>
                                            <td>{{ $teamMember->position }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $teamMember->photo) }}"
                                                    alt="{{ $teamMember->name }}" width="100" class="img-thumbnail">
                                            </td>
                                            <td>{{ Str::limit($teamMember->description, 100) }}</td>
                                            <td class="d-flex flex-column flex-sm-row align-items-center">
                                                <a href="{{ route('team.edit', $teamMember->id) }}"
                                                    class="btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2 w-100 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-edit me-1"></i> @lang('team.edit')
                                                </a>
                                                <form action="{{ route('team.destroy', $teamMember->id) }}" method="POST"
                                                    class="d-inline w-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-trash me-1"></i> @lang('team.delete')
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
                            {{ $teamMembers->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@stop
