@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('plans.dashboard'))
@section('content_header_title', __('plans.manage_plans'))
@section('content_header_subtitle', __('plans.plan_list'))

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
                <a href="{{ route('plans.create') }}" class="btn btn-primary w-auto">
                    <i class="fas fa-plus"></i> @lang('plans.create')
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white">@lang('plans.all_plans')</h3>
                    </div>
                    <div class="card-body p-0">
                        <!-- Table wrapper with scroll and height constraints -->
                        <div class="table-wrapper" style="max-height: 60vh; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('plans.name')</th>
                                        <th>@lang('plans.description')</th>
                                        <th>@lang('plans.price')</th>
                                        <th>@lang('plans.type')</th>
                                        <th>@lang('plans.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plans as $plan)
                                        <tr>
                                            <td>{{ $plan->name }}</td>
                                            <td>{{ $plan->description }}</td>
                                            <td>{{ $plan->price }}</td>
                                            <td>{{ $plan->type }}</td>
                                            <td class="d-flex flex-column flex-sm-row align-items-center">
                                                <a href="{{ route('plans.show', $plan->id) }}"
                                                    class="btn btn-info btn-sm mb-2 mb-sm-0 me-sm-2 w-100 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-eye me-1"></i> @lang('plans.view')
                                                </a>
                                                <a href="{{ route('plans.edit', $plan->id) }}"
                                                    class="btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2 w-100 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-edit me-1"></i> @lang('plans.edit')
                                                </a>
                                                <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                                                    class="d-inline w-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-trash me-1"></i> @lang('plans.delete')
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
