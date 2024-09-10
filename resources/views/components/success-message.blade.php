<div x-data="{ show: true }" x-show="show" @click.away="show = false" x-init="setTimeout(() => show = false, 5000)"
    class="position-fixed top-50 start-50 translate-middle alert alert-success alert-dismissible fade show shadow-lg"
    style="z-index: 1050; max-width: 400px; padding-right: 2rem; padding-left: 1rem; padding-top: 1.5rem; padding-bottom: 1.5rem; background: linear-gradient(135deg, #4caf50, #81c784); border-radius: 1rem; opacity: 0.95; animation: fadeIn 0.5s ease;"
    role="alert">
    <div class="d-flex align-items-center">
        <strong class="me-auto" style="font-size: 1.2rem; color: white;">{{ $slot }}</strong>
        <button type="button" class="ms-2 btn-close btn-close-white" @click="show = false" aria-label="Close"
            style="font-size: 0.7rem;">
        </button>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            transform: translate(-50%, -60%);
            opacity: 0;
        }

        to {
            transform: translate(-50%, -50%);
            opacity: 0.95;
        }
    }
</style>
