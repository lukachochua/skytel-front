<x-main-layout>
    <div class="container mt-4">
        <h1>Change Language</h1>

        <div class="btn-group" role="group" aria-label="Language Selection">
            <a href="{{ route('change-locale', ['locale' => 'en']) }}" class="btn btn-primary">English</a>
            <a href="{{ route('change-locale', ['locale' => 'ka']) }}" class="btn btn-secondary">Georgian</a>
            <h1>@lang('dashboard.dashboard')</h1>
        </div>
    </div>
</x-main-layout>
