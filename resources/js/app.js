import Alpine from 'alpinejs';
import '../../node_modules/swiper/swiper.min.css';
import '../../node_modules/swiper/swiper-bundle.min.css';
import { Swiper } from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';


// Dynamic two page form logic 
document.addEventListener('alpine:init', () => {
    Alpine.data('dynamicForm', () => ({
        showEnglishFields: false,

        switchToEnglish() {
            if (this.validateFields()) {
                this.showEnglishFields = true;
                const form = this.$el.closest('form');
                if (form) {
                    form.querySelector('#georgian-fields').style.display = 'none';
                    form.querySelector('#english-fields').style.display = 'block';
                    form.querySelector('#next-button').style.display = 'none';
                    form.querySelector('#submit-button').classList.remove('d-none');
                }
            } else {
                alert('Please fill out all required Georgian fields.');
            }
        },

        validateFields() {
            const georgianFields = document.querySelector('#georgian-fields');
            if (georgianFields) {
                const inputFields = georgianFields.querySelectorAll('input, textarea');
                let isEmpty = false;

                inputFields.forEach((field) => {
                    if (field.value.trim() === '') {
                        isEmpty = true;
                        return;
                    }
                });

                if (isEmpty) {
                    return false;
                }
            }
            return true;
        },
    }));
});

// JS method for the Swiper Slider
document.addEventListener('DOMContentLoaded', function () {
    const progressCircle = document.querySelector(".autoplay-progress svg");
    const progressContent = document.querySelector(".autoplay-progress span");
    const swiper = new Swiper('.modern-tech-slider', {
        modules: [Navigation, Pagination, Autoplay, EffectFade],
        effect: 'fade',
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        speed: 800,
        fadeEffect: {
            crossFade: true
        },
        on: {
            autoplayTimeLeft(s, time, progress) {
                progressCircle.style.setProperty("--progress", 1 - progress);
                progressContent.textContent = `${Math.ceil(time / 1000)}`;
            }
        }
    });
});

// DropDown on hover
document.addEventListener("DOMContentLoaded", function () {
    if (window.innerWidth >= 992) { // lg and up
        const dropdowns = document.querySelectorAll('.navbar .dropdown');

        dropdowns.forEach(function (dropdown) {
            dropdown.addEventListener('mouseover', function () {
                const dropdownMenu = this.querySelector('.dropdown-menu');
                const dropdownToggle = this.querySelector('.dropdown-toggle');

                dropdownMenu.classList.add('show');
                dropdownToggle.classList.add('show');
                dropdown.setAttribute('aria-expanded', 'true');
            });

            dropdown.addEventListener('mouseleave', function () {
                const dropdownMenu = this.querySelector('.dropdown-menu');
                const dropdownToggle = this.querySelector('.dropdown-toggle');

                dropdownMenu.classList.remove('show');
                dropdownToggle.classList.remove('show');
                dropdown.setAttribute('aria-expanded', 'false');
            });
        });
    }
});

// Navbar Fade Out/In
document.addEventListener('DOMContentLoaded', function () {
    var lastScrollTop = 0;
    var navbar = document.querySelector('.navbar');
    var scrollDelta = 5;

    window.addEventListener('scroll', function () {
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (Math.abs(lastScrollTop - scrollTop) <= scrollDelta) {
            return;
        }

        if (scrollTop > lastScrollTop && scrollTop > navbar.clientHeight) {
            navbar.classList.add('hidden');
        } else {
            navbar.classList.remove('hidden');
        }

        lastScrollTop = scrollTop;
    });
});

// News Component
document.addEventListener('alpine:init', () => {
    Alpine.data('newsScroller', () => ({
        scrollPosition: 0,
        itemWidth: 0,
        containerWidth: 0,
        scrollWidth: 0,
        visibleItems: 5,
        atStart: true,
        atEnd: false,
        isDragging: false,
        startX: 0,

        init() {
            this.calculateDimensions();
            window.addEventListener('resize', () => this.calculateDimensions());
        },

        calculateDimensions() {
            this.$nextTick(() => {
                const wrapper = this.$el.querySelector('.news-wrapper');
                const item = this.$el.querySelector('.news-item');
                const scroll = this.$el.querySelector('.news-scroll');
                if (wrapper && item && scroll) {
                    this.containerWidth = wrapper.offsetWidth;
                    this.itemWidth = item.offsetWidth;
                    this.scrollWidth = scroll.scrollWidth;
                    this.visibleItems = Math.floor(this.containerWidth / this.itemWidth);
                    this.checkBounds();
                }
            });
        },

        scrollLeft() {
            if (this.scrollPosition > 0) {
                this.scrollPosition = Math.max(0, this.scrollPosition - this.itemWidth);
                this.updateScrollPosition();
            }
        },

        scrollRight() {
            const maxScroll = this.scrollWidth - this.containerWidth;
            if (this.scrollPosition < maxScroll) {
                this.scrollPosition = Math.min(maxScroll, this.scrollPosition + this.itemWidth);
                this.updateScrollPosition();
            }
        },

        updateScrollPosition() {
            this.$refs.newsScroll.style.transform = `translateX(-${this.scrollPosition}px)`;
            this.checkBounds();
        },

        checkBounds() {
            this.atStart = this.scrollPosition <= 0;
            this.atEnd = this.scrollPosition >= this.scrollWidth - this.containerWidth;
        },

        startDrag(e) {
            this.isDragging = true;
            this.startX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
        },

        drag(e) {
            if (!this.isDragging) return;
            const x = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
            const delta = this.startX - x;
            const maxScroll = this.scrollWidth - this.containerWidth;
            this.scrollPosition = Math.max(0, Math.min(this.scrollPosition + delta, maxScroll));
            this.startX = x;
            this.updateScrollPosition();
        },

        endDrag() {
            this.isDragging = false;
        }
    }));
});

// Optional fields for the Plans creation
document.addEventListener('DOMContentLoaded', function () {
    var typeSelect = document.getElementById('plan_type_id');
    var fiberOpticTypeId = typeSelect.getAttribute('data-fiber-optic-id');
    var tvPlanFields = document.getElementById('tv-plan-fields');
    var packagesContainer = document.getElementById('packages-container');
    var addPackageButton = document.getElementById('add-package');
    var packageCount = 1;

    // Initialize display based on current type
    if (typeSelect.value === fiberOpticTypeId) {
        tvPlanFields.style.display = 'block';
    }

    typeSelect.addEventListener('change', function () {
        if (this.value === fiberOpticTypeId) {
            tvPlanFields.style.display = 'block';
        } else {
            tvPlanFields.style.display = 'none';
        }
    });

    addPackageButton.addEventListener('click', function () {
        var packageForm = document.createElement('div');
        packageForm.classList.add('form-group', 'package-form');
        packageForm.setAttribute('data-index', packageCount);

        packageForm.innerHTML = `
            <label for="packages[${packageCount}][name]">Package Name</label>
            <input type="text" id="packages[${packageCount}][name]" name="packages[${packageCount}][name]" class="form-control">
            <label for="packages[${packageCount}][name_en]">Package Name (EN)</label>
            <input type="text" id=""packages[${packageCount}][name_en]" name="packages[${packageCount}][name_en]" class="form-control">
            <label for="packages[${packageCount}][price]">Package Price</label>
            <input type="number" id="packages[${packageCount}][price]" name="packages[${packageCount}][price]" class="form-control">
            <button type="button" class="btn btn-danger remove-package">Remove Package</button>
        `;

        packagesContainer.appendChild(packageForm);
        packageCount++;
    });

    packagesContainer.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-package')) {
            event.target.closest('.package-form').remove();
        }
    });
});

// Plan Component Animation function
document.addEventListener('alpine:init', () => {
    Alpine.data('animateOnScroll', () => ({
        isVisible: false,
        init() {
            this.observeIntersection();
        },
        observeIntersection() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.isVisible = true;
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            });

            observer.observe(this.$el);
        }
    }));
});


// Plan Form
Alpine.data('planForm', () => ({
    selectedTvPlan: '',
    packages: window.planFormData || [],
    showModal: false, 

    updatePackages() {
    },

    toggleModal() {
        this.showModal = !this.showModal; 
    },

    closeModal() {
        this.showModal = false; 
    }
}));


// Team Member Modal
Alpine.data('teamIndex', () => ({
    selectedMember: null, 
    showModal: false, 

    toggleModal(member = null) {
        this.selectedMember = member;
        this.showModal = true; 
    },

    closeModal() {
        this.showModal = false; 
        this.selectedMember = null; 
    }
}));


window.Alpine = Alpine;
Alpine.start();
