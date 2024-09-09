<div x-show="showModal" @click="closeModal" x-transition.opacity x-cloak
    class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">

    <!-- Modal Content -->
    <div @click.stop class="bg-white p-6 rounded shadow-lg w-full max-w-lg modal-content relative">

        <!-- Close Button -->
        <button type="button" @click="closeModal" class="btn-close custom-close-btn" aria-label="Close"></button>

        <!-- Modal Content Here -->
        {{ $slot }}
    </div>
</div>
