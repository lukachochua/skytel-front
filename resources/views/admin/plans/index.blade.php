@extends('layouts.app')

@section('title', 'Plans')

@section('content_header')
    <h1>@lang('plans.plans')</h1> <!-- Title for Plans -->
@stop

@section('content')
    {{-- Content body: main page content --}}
    <div class="container">
        {{-- Success message --}}
        @if (session('success'))
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        @endif

        {{-- Add New Plan Button --}}
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('plans.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> @lang('plans.add_new')
                </a>
            </div>
        </div>

        {{-- Plans Table --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">@lang('plans.all_plans')</h3>
            </div>
            <div class="card-body p-0">
                <!-- Table wrapper with scroll and height constraints -->
                <div class="table-wrapper" style="max-height: 60vh; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="w-1">#</th>
                                <th>@lang('plans.name')</th>
                                <th>@lang('plans.type')</th>
                                <th>@lang('plans.options')</th>
                                <th>@lang('plans.status')</th>
                                <th class="w-2">@lang('plans.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($planTypes as $planType)
                                <tr>
                                    <td colspan="6" class="bg-light">
                                        <strong>{{ ucfirst($planType->name) }}</strong> {{-- Plan Type Name --}}
                                    </td>
                                </tr>
                                @foreach ($planType->plans as $plan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('plans.show', $plan->id) }}" class="text-primary">
                                                {{ $plan->name }}
                                            </a>
                                        </td>
                                        <td>{{ ucfirst($plan->planType->name) }}</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                @foreach ($plan->planOptions as $option)
                                                    <li>
                                                        <strong>{{ ucfirst($option->option_name) }}</strong> -
                                                        @lang('plans.price'): {{ $option->price }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if ($plan->planType->name === 'tv')
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <strong>@lang('plans.tv_service'):</strong>
                                                        {{ $plan->tvService->name }}
                                                    </li>
                                                    @foreach ($plan->tvService->tvServiceOptions as $tvOption)
                                                        <li>
                                                            <strong>{{ ucfirst($tvOption->option_name) }}</strong> -
                                                            @lang('plans.setanta'):
                                                            {{ $tvOption->setanta ? __('plans.yes') : __('plans.no') }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($plan->status) }}</td>
                                        <td class="d-flex flex-column flex-sm-row align-items-center">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
