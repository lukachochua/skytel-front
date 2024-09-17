<x-main-layout>
    <div class="container custom-header-margin" x-data="teamIndex()">
        <h1 class="display-4 mb-5 text-center text-primary fw-bold">@lang('team.about_us')</h1>

        <section class="mb-5 bg-light p-4 rounded shadow-sm ">
            <h2 class="text-secondary mb-4 fs-2">@lang('team.aim')</h2>
            <p class="lead mb-4 text-muted">
                {{ __('team.mission') }}
            </p>
        </section>

        <section class="mb-5">
            <h2 class="text-secondary mb-4 fs-2">@lang('team.our_team')</h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($teamMembers as $member)
                    <div class="col">
                        <div @click="toggleModal({{ json_encode([
                            'name' => $member->name,
                            'position' => $member->position,
                            'description' => $member->description,
                            'photo' => asset('storage/' . $member->photo),
                        ]) }})"
                            class="card team-member-card h-100 cursor-pointer">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ asset('storage/' . $member->photo) }}" class="card-img-top"
                                    alt="{{ $member->name }}" style="height: 300px; object-fit: cover;">
                                <div class="team-member-info">
                                    <h5 class="card-title mb-1">{{ $member->name }}</h5>
                                    <p class="card-text mb-0 small">{{ $member->position }}</p>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text flex-grow-1 text-muted">{{ Str::limit($member->description, 100) }}
                                </p>
                                <button class="btn btn-outline-primary mt-2">Learn More</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Modal -->

        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-2000" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 bg-gray-500 bg-opacity-50 mt-2 flex items-center justify-center z-50">
            <div @click.away="closeModal"
                class="bg-white p-6 rounded shadow-lg relative w-50 h-auto max-w-screen-lg max-h-screen-lg d-flex flex-column position-relative">
                <button type="button" @click="closeModal"
                    class="btn btn-close position-absolute top-2 end-0 btn-dark rounded-circle p-2" aria-label="Close">
                </button>
                <div class="flex-grow-1 overflow-auto">
                    <template x-if="selectedMember">
                        <div class="m-4">
                            <img :src="selectedMember.photo" :alt="selectedMember.name"
                                class="img-fluid rounded-start mb-4"
                                style="height: 500px; object-fit: cover; width: 100%;">
                            <h1 class="text-primary fw-bold mb-2" x-text="selectedMember.name"></h1>
                            <h4 class="text-secondary mb-4" x-text="selectedMember.position"></h4>
                            <p x-text="selectedMember.description"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
