document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const checkButton = document.getElementById('checkButton');
    const submitButton = document.getElementById('submitButton');
    const resetButton = document.getElementById('resetButton');

    // Form elemanları
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');
    const agreementInput = document.getElementById('agreement');

    // Hata mesajları için elementler
    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const phoneError = document.getElementById('phoneError');
    const subjectError = document.getElementById('subjectError');
    const messageError = document.getElementById('messageError');
    const agreementError = document.getElementById('agreementError');

    // Hata mesajlarını temizle
    function clearErrors() {
        nameError.textContent = '';
        emailError.textContent = '';
        phoneError.textContent = '';
        subjectError.textContent = '';
        messageError.textContent = '';
        agreementError.textContent = '';

        nameInput.classList.remove('is-invalid');
        emailInput.classList.remove('is-invalid');
        phoneInput.classList.remove('is-invalid');
        subjectInput.classList.remove('is-invalid');
        messageInput.classList.remove('is-invalid');
        agreementInput.classList.remove('is-invalid');
    }

    // Form validasyonu
    function validateForm() {
        clearErrors();
        let isValid = true;

        // İsim kontrolü
        if (!nameInput.value.trim()) {
            nameError.textContent = 'Ad Soyad alanı boş bırakılamaz';
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else if (nameInput.value.trim().length < 3) {
            nameError.textContent = 'Ad Soyad en az 3 karakter olmalıdır';
            nameInput.classList.add('is-invalid');
            isValid = false;
        }

        // Email kontrolü
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailInput.value.trim()) {
            emailError.textContent = 'E-posta alanı boş bırakılamaz';
            emailInput.classList.add('is-invalid');
            isValid = false;
        } else if (!emailRegex.test(emailInput.value.trim())) {
            emailError.textContent = 'Geçerli bir e-posta adresi giriniz';
            emailInput.classList.add('is-invalid');
            isValid = false;
        }

        // Telefon kontrolü
        const phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneInput.value.trim()) {
            phoneError.textContent = 'Telefon alanı boş bırakılamaz';
            phoneInput.classList.add('is-invalid');
            isValid = false;
        } else if (!phoneRegex.test(phoneInput.value.trim())) {
            phoneError.textContent = 'Telefon numarası sadece rakamlardan oluşmalıdır (10-11 haneli)';
            phoneInput.classList.add('is-invalid');
            isValid = false;
        }

        // Konu kontrolü
        if (!subjectInput.value) {
            subjectError.textContent = 'Lütfen bir konu seçiniz';
            subjectInput.classList.add('is-invalid');
            isValid = false;
        }

        // Mesaj kontrolü
        if (!messageInput.value.trim()) {
            messageError.textContent = 'Mesaj alanı boş bırakılamaz';
            messageInput.classList.add('is-invalid');
            isValid = false;
        } else if (messageInput.value.trim().length < 10) {
            messageError.textContent = 'Mesaj en az 10 karakter olmalıdır';
            messageInput.classList.add('is-invalid');
            isValid = false;
        }

        // Kişisel veriler izni kontrolü
        if (!agreementInput.checked) {
            agreementError.textContent = 'Devam etmek için kişisel verilerin işlenmesine izin vermelisiniz';
            agreementInput.classList.add('is-invalid');
            isValid = false;
        }

        submitButton.disabled = !isValid;
        return isValid;
    }

    // Form sıfırlama
    function resetForm() {
        form.reset();
        clearErrors();
        submitButton.disabled = true;
    }

    // Event listeners
    checkButton.addEventListener('click', validateForm);
    resetButton.addEventListener('click', resetForm);

    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    // Input değişikliklerinde validasyon
    const inputs = [nameInput, emailInput, phoneInput, subjectInput, messageInput, agreementInput];
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateForm();
            }
        });
    });
}); 