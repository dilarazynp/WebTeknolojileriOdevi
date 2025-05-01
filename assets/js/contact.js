document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const clearButton = document.getElementById('clearButton');
    const phoneInput = document.getElementById('phone');
    
    // Telefon numarası formatı
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 10) value = value.slice(0, 10);
        e.target.value = value;
    });

    // Form temizleme
    clearButton.addEventListener('click', function() {
        form.reset();
        // Tüm hata mesajlarını temizle
        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    });

    // JavaScript validasyonu
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Ad Soyad kontrolü
        const name = document.getElementById('name').value.trim();
        if (!name || !/^[A-Za-zğüşıöçĞÜŞİÖÇ\s]{2,50}$/.test(name)) {
            errors.push('Ad Soyad en az 2, en fazla 50 karakter olmalı ve sadece harf içermelidir.');
            isValid = false;
        }

        // E-posta kontrolü
        const email = document.getElementById('email').value.trim();
        if (!email || !/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/.test(email)) {
            errors.push('Geçerli bir e-posta adresi giriniz.');
            isValid = false;
        }

        // Telefon kontrolü
        const phone = document.getElementById('phone').value.trim();
        if (!phone || !/^\d{10}$/.test(phone)) {
            errors.push('Telefon numarası 10 haneli olmalıdır.');
            isValid = false;
        }

        // Konu kontrolü
        const subject = document.getElementById('subject').value.trim();
        if (!subject || subject.length < 3 || subject.length > 100) {
            errors.push('Konu en az 3, en fazla 100 karakter olmalıdır.');
            isValid = false;
        }

        // Mesaj kontrolü
        const message = document.getElementById('message').value.trim();
        if (!message || message.length < 10 || message.length > 500) {
            errors.push('Mesaj en az 10, en fazla 500 karakter olmalıdır.');
            isValid = false;
        }

        return { isValid, errors };
    }

    // Form gönderimi
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const validation = validateForm();
        
        if (!validation.isValid) {
            alert(validation.errors.join('\n'));
            return;
        }

        // Tarih ekle
        const dateInput = document.createElement('input');
        dateInput.type = 'hidden';
        dateInput.name = 'date';
        dateInput.value = new Date().toLocaleString('tr-TR');
        form.appendChild(dateInput);

        // Formu gönder
        form.submit();
    });

    // Her input alanı için real-time validasyon
    form.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', function() {
            const validation = validateForm();
            if (validation.isValid) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
    });
}); 