const { createApp } = Vue;

const app = createApp({
    data() {
        return {
            formData: {
                name: '',
                email: '',
                phone: '',
                gender: '',
                subject: '',
                message: '',
                agreement: false
            },
            errors: {
                name: '',
                email: '',
                phone: '',
                gender: '',
                subject: '',
                message: '',
                agreement: ''
            }
        }
    },
    methods: {
        validateForm() {
            this.clearErrors();
            let isValid = true;

            // İsim kontrolü
            if (!this.formData.name.trim()) {
                this.errors.name = 'Ad Soyad alanı boş bırakılamaz';
                this.showError('name');
                isValid = false;
            } else if (this.formData.name.trim().length < 3) {
                this.errors.name = 'Ad Soyad en az 3 karakter olmalıdır';
                this.showError('name');
                isValid = false;
            }

            // Email kontrolü
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.formData.email.trim()) {
                this.errors.email = 'E-posta alanı boş bırakılamaz';
                this.showError('email');
                isValid = false;
            } else if (!emailRegex.test(this.formData.email.trim())) {
                this.errors.email = 'Geçerli bir e-posta adresi giriniz';
                this.showError('email');
                isValid = false;
            }

            // Telefon kontrolü
            const phoneRegex = /^[0-9]{10,11}$/;
            if (!this.formData.phone.trim()) {
                this.errors.phone = 'Telefon alanı boş bırakılamaz';
                this.showError('phone');
                isValid = false;
            } else if (!phoneRegex.test(this.formData.phone.trim())) {
                this.errors.phone = 'Telefon numarası sadece rakamlardan oluşmalıdır (10-11 haneli)';
                this.showError('phone');
                isValid = false;
            }

            // Cinsiyet kontrolü
            if (!this.formData.gender) {
                this.errors.gender = 'Lütfen cinsiyet seçiniz';
                this.showError('gender');
                isValid = false;
            }

            // Konu kontrolü
            if (!this.formData.subject) {
                this.errors.subject = 'Lütfen bir konu seçiniz';
                this.showError('subject');
                isValid = false;
            }

            // Mesaj kontrolü
            if (!this.formData.message.trim()) {
                this.errors.message = 'Mesaj alanı boş bırakılamaz';
                this.showError('message');
                isValid = false;
            } else if (this.formData.message.trim().length < 10) {
                this.errors.message = 'Mesaj en az 10 karakter olmalıdır';
                this.showError('message');
                isValid = false;
            }

            // Kişisel veriler izni kontrolü
            if (!this.formData.agreement) {
                this.errors.agreement = 'Devam etmek için kişisel verilerin işlenmesine izin vermelisiniz';
                this.showError('agreement');
                isValid = false;
            }

            return isValid;
        },
        showError(field) {
            const element = document.getElementById(field);
            if (element) {
                element.classList.add('is-invalid');
                const errorElement = document.getElementById(field + 'Error');
                if (errorElement) {
                    errorElement.textContent = this.errors[field];
                }
            }
        },
        clearErrors() {
            // Tüm hata mesajlarını temizle
            Object.keys(this.errors).forEach(key => {
                this.errors[key] = '';
                const element = document.getElementById(key);
                if (element) {
                    element.classList.remove('is-invalid');
                }
                const errorElement = document.getElementById(key + 'Error');
                if (errorElement) {
                    errorElement.textContent = '';
                }
            });
        },
        handleVueValidation() {
            // Form verilerini al
            this.formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                gender: document.querySelector('input[name="gender"]:checked')?.value || '',
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value,
                agreement: document.getElementById('agreement').checked
            };

            const isValid = this.validateForm();
            if (isValid) {
                alert('Vue.js ile form doğrulaması başarılı!');
            }
        }
    }
});

// Vue uygulamasını başlat
app.mount('#contactForm');

// Vue validation butonuna event listener ekle
document.addEventListener('DOMContentLoaded', function() {
    const vueCheckButton = document.getElementById('vueCheckButton');
    if (vueCheckButton) {
        vueCheckButton.addEventListener('click', function() {
            app._instance.proxy.handleVueValidation();
        });
    }
}); 