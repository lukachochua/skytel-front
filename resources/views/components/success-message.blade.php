<div x-data="{ show: true }"
     x-show="show"
     @click.away="show = false"
     x-init="setTimeout(() => show = false, 5000)"
     class="position-fixed top-0 start-50 translate-middle-x mt-3 alert alert-success alert-dismissible fade show shadow-lg rounded"
     style="z-index: 1050; max-width: 500px; padding-right: 3rem; padding-left: 1rem;" role="alert">
    <div class="d-flex align-items-center">
        <strong class="me-auto">{{ $slot }}</strong>
        <button type="button" class="ms-2" @click="show = false" aria-label="Close">
            <i class="fa fa-window-close" aria-hidden="true"></i>
        </button>
    </div>
</div>