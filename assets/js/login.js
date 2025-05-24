// Login durumunu kontrol et ve navbar'ı güncelle
function checkLoginState() {
    const isLoggedIn = sessionStorage.getItem('isLoggedIn');
    const userEmail = sessionStorage.getItem('userEmail');
    updateNavbar(isLoggedIn, userEmail);
}

// Navbar'ı güncelle
function updateNavbar(isLoggedIn, userEmail) {
    const loginContainer = document.querySelector('.nav-item:last-child');
    if (!loginContainer) return;

    if (isLoggedIn === 'true') {
        loginContainer.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="nav-link me-2 text-success">
                    <i class="fas fa-user me-1"></i>${userEmail}
                </span>
                <a class="btn btn-danger btn-sm" href="#" onclick="handleLogout(event)">
                    <i class="fas fa-sign-out-alt me-1"></i>Çıkış
                </a>
            </div>
        `;
    } else {
        loginContainer.innerHTML = `
            <a class="btn btn-light btn-sm ms-2" href="login.html">
                <i class="fas fa-sign-in-alt me-1"></i>Giriş
            </a>
        `;
    }
}

// Form gönderimini işle
async function handleSubmit(event) {
    event.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Basit validasyon
    if (!email || !password) {
        showError('Lütfen tüm alanları doldurun.');
        return false;
    }
    
    // E-posta formatı kontrolü
    if (!email.includes('@') || !email.includes('.')) {
        showError('Geçerli bir e-posta adresi girin.');
        return false;
    }
    
    try {
        const response = await fetch('php/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        });

        const data = await response.json();
        
        if (data.success) {
            // Login başarılı
            sessionStorage.setItem('isLoggedIn', 'true');
            sessionStorage.setItem('userEmail', email);
            window.location.href = 'php/login.php'; // Başarılı sayfasına yönlendir
        } else {
            showError(data.message || 'E-posta veya şifre hatalı!');
        }
    } catch (error) {
        showError('Bir hata oluştu. Lütfen tekrar deneyin.');
        console.error('Login error:', error);
    }
    
    return false;
}

// Çıkış işlemini handle et
async function handleLogout(event) {
    event.preventDefault();
    try {
        // Sayfanın konumuna göre logout.php yolunu belirle
        const isInPhpDir = window.location.pathname.includes('/php/');
        const logoutPath = isInPhpDir ? 'logout.php' : 'php/logout.php';
        
        const response = await fetch(logoutPath);
        if (response.ok) {
            sessionStorage.removeItem('isLoggedIn');
            sessionStorage.removeItem('userEmail');
            // Sayfanın konumuna göre yönlendirme yolunu belirle
            const redirectPath = isInPhpDir ? '../index.html' : 'index.html';
            window.location.href = redirectPath;
        }
    } catch (error) {
        console.error('Logout error:', error);
        // Hata olsa bile client-side logout işlemini yap
        sessionStorage.removeItem('isLoggedIn');
        sessionStorage.removeItem('userEmail');
        const redirectPath = window.location.pathname.includes('/php/') ? '../index.html' : 'index.html';
        window.location.href = redirectPath;
    }
}

// Hata mesajını göster
function showError(message) {
    const errorDiv = document.getElementById('loginError');
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }
}

// Sayfa yüklendiğinde login durumunu kontrol et
document.addEventListener('DOMContentLoaded', checkLoginState);