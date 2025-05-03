document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value;
    const agreement = document.getElementById('agreement').checked;
    
    let isValid = true;
    
    // İsim kontrolü
    if (name.length < 3) {
        document.getElementById('nameError').textContent = 'İsim en az 3 karakter olmalıdır.';
        document.getElementById('name').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('name').classList.remove('is-invalid');
    }
    
    // E-posta kontrolü
    if (!email.includes('@') || !email.includes('.')) {
        document.getElementById('emailError').textContent = 'Geçerli bir e-posta adresi giriniz.';
        document.getElementById('email').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('email').classList.remove('is-invalid');
    }
    
    // Telefon kontrolü
    if (!/^\d{10,11}$/.test(phone)) {
        document.getElementById('phoneError').textContent = 'Telefon numarası 10-11 rakamdan oluşmalıdır.';
        document.getElementById('phone').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('phone').classList.remove('is-invalid');
    }
    
    // Konu kontrolü
    if (!subject) {
        document.getElementById('subjectError').textContent = 'Lütfen bir konu seçiniz.';
        document.getElementById('subject').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('subject').classList.remove('is-invalid');
    }
    
    // Mesaj kontrolü
    if (message.length < 10) {
        document.getElementById('messageError').textContent = 'Mesaj en az 10 karakter olmalıdır.';
        document.getElementById('message').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('message').classList.remove('is-invalid');
    }
    
    // Sözleşme kontrolü
    if (!agreement) {
        document.getElementById('agreementError').textContent = 'Lütfen sözleşmeyi kabul ediniz.';
        document.getElementById('agreement').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('agreement').classList.remove('is-invalid');
    }
    
    if (isValid) {
        this.submit();
    }
});

function resetForm() {
    const form = document.getElementById('contactForm');
    form.reset();
    
    // Tüm hata mesajlarını ve invalid class'larını temizle
    const inputs = document.querySelectorAll('.form-control, .form-select, .form-check-input');
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    const errorElements = document.querySelectorAll('.invalid-feedback');
    errorElements.forEach(element => {
        element.textContent = '';
    });
} 