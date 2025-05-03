<?php
session_start();

// Eğer form yeni gönderiliyorsa veya temizleme isteği varsa session'ı temizle
if (isset($_POST['clear_session']) || !isset($_SESSION['form_submitted'])) {
    session_unset();
    session_destroy();
    session_start();
}

// Form POST ile gönderilmiş ve daha önce işlenmemişse
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['form_submitted'])) {
    // Form işlendi olarak işaretle
    $_SESSION['form_submitted'] = true;
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    // Form verilerini JSON dosyasına kaydet
    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
        'date' => date('Y-m-d H:i:s')
    ];

    $jsonFile = '../form_submissions.json';
    $submissions = [];
    if (file_exists($jsonFile)) {
        $submissions = json_decode(file_get_contents($jsonFile), true) ?? [];
    }
    $submissions[] = $data;
    file_put_contents($jsonFile, json_encode($submissions, JSON_PRETTY_PRINT));

    // Form verilerini session'a kaydet (gösterim için)
    $_SESSION['form_data'] = $data;
} 

// Eğer form daha önce gönderilmişse ve session'da veri varsa
if (isset($_SESSION['form_submitted']) && isset($_SESSION['form_data'])) {
    $name = $_SESSION['form_data']['name'];
    $email = $_SESSION['form_data']['email'];
    $phone = $_SESSION['form_data']['phone'];
    $subject = $_SESSION['form_data']['subject'];
    $message = $_SESSION['form_data']['message'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - Başarılı</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Stil Dosyalarımız -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/contact.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        .success-icon {
            font-size: 4rem;
            color: #198754;
            margin-bottom: 1rem;
        }
        .table-borderless th {
            font-weight: 600;
            color: #6c757d;
        }
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .card-header {
            border-bottom: none;
            padding: 1.5rem;
        }
        .card-body {
            padding: 1.5rem;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" href="../interests.html">İlgi Alanlarım</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../contact.html">İletişim</a></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm ms-2" href="../login.html">Giriş</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle success-icon"></i>
                        <h2 class="mb-3">Mesajınız Başarıyla Gönderildi!</h2>
                        <p class="text-muted">Form detaylarınız başarıyla kaydedildi. En kısa sürede size dönüş yapacağız.</p>
                    </div>
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4 class="mb-0">Form Detayları</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="30%">Ad Soyad:</th>
                                            <td><?php echo htmlspecialchars($name); ?></td>
                                        </tr>
                                        <tr>
                                            <th>E-posta:</th>
                                            <td><?php echo htmlspecialchars($email); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Telefon:</th>
                                            <td><?php echo htmlspecialchars($phone); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Konu:</th>
                                            <td><?php 
                                                switch($subject) {
                                                    case 'bilgi':
                                                        echo 'Bilgi Talebi';
                                                        break;
                                                    case 'sikayet':
                                                        echo 'Şikayet';
                                                        break;
                                                    case 'oneriler':
                                                        echo 'Öneriler';
                                                        break;
                                                    default:
                                                        echo htmlspecialchars($subject);
                                                }
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mesaj:</th>
                                            <td><?php echo nl2br(htmlspecialchars($message)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Gönderim Tarihi:</th>
                                            <td><?php echo date('d.m.Y H:i'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-4">
                                <a href="../contact.html" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>İletişim Sayfasına Dön
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-center text-white py-4">
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
</body>
</html>
<?php
} else {
    // Session'da veri yoksa veya direkt erişilirse contact.html'e yönlendir
    header("Location: ../contact.html");
    exit();
}
?>
