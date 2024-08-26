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
    let lastScrollTop = 0;
    const navbar = document.querySelector('.navbar');
    const scrollThreshold = 50; 

    window.addEventListener('scroll', function () {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
            navbar.classList.add('hidden');
        } else if (scrollTop < lastScrollTop || scrollTop < scrollThreshold) {
            navbar.classList.remove('hidden');
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
});


window.Alpine = Alpine;
Alpine.start();
