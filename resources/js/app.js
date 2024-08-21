import Alpine from 'alpinejs';

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

window.Alpine = Alpine;
Alpine.start();
