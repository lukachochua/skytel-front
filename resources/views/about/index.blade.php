<x-main-layout>
    <div class="container mt-5">
        <h1 class="custom-header-margin mb-5 text-center text-primary fw-bold">@lang('team.about_us')</h1>

        <section class="mb-5">
            <h2 class="text-secondary mb-4">@lang('team.aim')</h2>
            <p class="lead mb-4">
                {{ __('team.mission') }}
            </p>
        </section>

        <section class="mb-5">
            <h2 class="text-secondary mb-4">@lang('team.our_team')</h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($teamMembers as $member)
                    <div class="col">
                        <div class="card border-light shadow-lg h-100">
                            <img src="{{ asset('storage/' . $member->photo) }}" class="card-img-top"
                                alt="{{ $member->name }}" style="height: 300px; object-fit: cover; width: 100%;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2 text-center">{{ $member->name }}</h5>
                                <p class="card-text mb-2 text-muted text-center">{{ $member->position }}</p>
                                <p class="card-text flex-grow-1">{{ $member->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-main-layout>
