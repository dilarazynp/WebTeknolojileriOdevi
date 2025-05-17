<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // XSS koruması
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    
    header('Content-Type: application/json');

    // Boş alan kontrolü
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Tüm alanları doldurun']);
        exit;
    }

    // Email format kontrolü
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Geçerli bir email adresi girin']);
        exit;
    }

    if ($email === 'g221210011@sakarya.edu.tr' && $password === 'g221210011') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = 'g221210011';
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Geçersiz kullanıcı adı veya şifre']);
        exit;
    }
}

// Check if user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Başarılı - ZDK</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Stil Dosyalarımız -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="../index.html">
            <img src="../assets/images/large.png" alt="ZDK Logo" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="../index.html">Ana Sayfa</a></li>
                <li class="nav-item"><a class="nav-link" href="../resume.html">Özgeçmiş</a></li>
                <li class="nav-item"><a class="nav-link" href="../sehrim.html">Şehrim</a></li>
                <li class="nav-item"><a class="nav-link" href="../mirasimiz.html">Mirasımız</a></li>
                <li class="nav-item"><a class="nav-link" href="../ilgi.html">İlgi Alanlarım</a></li>
                <li class="nav-item"><a class="nav-link" href="../contact.html">İletişim</a></li>
                <li class="nav-item"><a class="btn btn-light btn-sm ms-2 active" href="../login.html">Giriş</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Success Message -->
<div class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card text-center">
                    <i class="fas fa-check-circle text-success mb-4" style="font-size: 4rem;"></i>
                    <h2>Hoşgeldiniz!</h2>
                    <p class="lead mb-4">Giriş işlemi başarılı!</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="../index.html" class="btn btn-primary">Ana Sayfaya Git</a>
                        <a href="../sehrim.html" class="btn btn-outline-primary">Şehrimi Keşfet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-center text-white py-4 mt-5">
    <div class="container">
        <div class="social-icons">
            <a href="https://github.com/dilarazynp" target="_blank" class="text-white me-3"><i class="fab fa-github"></i></a>
            <a href="https://www.linkedin.com/in/zeynepdilarakurnaz/" target="_blank" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
            <a href="#" target="_blank" class="text-white me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" target="_blank" class="text-white"><i class="fab fa-twitter"></i></a>
        </div>
        <small class="mt-3 d-block text-white">&copy; 2025 ZDK | Tüm Hakları Saklıdır.</small>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Login State Check -->
<script src="../assets/js/login.js"></script>

</body>
</html>
<?php
} else {
    // If not logged in, redirect to login page
    header('Location: ../login.html');
    exit;
}
?>
