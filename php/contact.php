<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    // Form verilerini bir dosyaya kaydet
    $data = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
        'date' => date('Y-m-d H:i:s')
    );
    
    // JSON dosyasının yolu
    $jsonFile = '../form_submissions.json';
    
    // Mevcut verileri oku
    $submissions = [];
    if (file_exists($jsonFile)) {
        $submissions = json_decode(file_get_contents($jsonFile), true) ?? [];
    }
    
    // Yeni gönderimi ekle
    $submissions[] = $data;
    

    // Verileri JSON dosyasına kaydet
if (file_put_contents($jsonFile, json_encode($submissions, JSON_PRETTY_PRINT))) {
    // SESSION kullanarak mesaj bilgilerini taşıyacağız
    session_start();
    $_SESSION['last_submission'] = $data;
    
    // Redirect
    header("Location: success.php");
    exit();
}

    // Verileri JSON dosyasına kaydet
    if (file_put_contents($jsonFile, json_encode($submissions, JSON_PRETTY_PRINT))) {
        // Başarılı mesajı göster
        echo "<!DOCTYPE html>
        <html lang='tr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Mesaj Gönderildi - ZDK</title>
            
            <!-- Bootstrap CSS -->
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
            
            <!-- Google Fonts -->
            <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
            
            <!-- Font Awesome -->
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>
            
            <!-- Stil Dosyalarımız -->
            <link rel='stylesheet' href='../assets/css/style.css'>
            <link rel='stylesheet' href='../assets/css/contact.css'>
        </head>
        <body>
            <!-- Navbar -->
            <nav class='navbar navbar-expand-lg navbar-light shadow-sm'>
                <div class='container'>
                    <a class='navbar-brand fw-bold' href='../index.html'>ZDK</a>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse' id='navbarNav'>
                        <ul class='navbar-nav ms-auto align-items-center'>
                            <li class='nav-item'><a class='nav-link' href='../index.html'>Anasayfa</a></li>
                            <li class='nav-item'><a class='nav-link' href='../cv.html'>Özgeçmiş</a></li>
                            <li class='nav-item'><a class='nav-link' href='../city.html'>Şehrim</a></li>
                            <li class='nav-item'><a class='nav-link' href='../interests.html'>İlgi Alanlarım</a></li>
                            <li class='nav-item'><a class='nav-link active' href='../contact.html'>İletişim</a></li>
                            <li class='nav-item'><a class='btn btn-light btn-sm ms-2' href='../login.html'>Giriş</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Başlık -->
            <header class='hero-section text-center text-white d-flex align-items-center'>
                <div class='container'>
                    <h1 class='display-4 fw-bold'>Mesajınız Gönderildi</h1>
                    <p class='lead'>İletişim formunuz başarıyla alındı.</p>
                </div>
            </header>

            <!-- Form Gönderim Sonucu -->
            <section class='container py-5'>
                <div class='row'>
                    <div class='col-lg-6 mb-4 mb-lg-0'>
                        <div class='content-card'>
                            <h3 class='mb-4'>İletişim Bilgileri</h3>
                            <div class='info-item mb-4'>
                                <i class='fas fa-envelope text-danger me-2'></i>
                                <div>
                                    <h5>E-posta</h5>
                                    <p>zeynep@example.com</p>
                                </div>
                            </div>
                            <div class='info-item mb-4'>
                                <i class='fas fa-phone text-danger me-2'></i>
                                <div>
                                    <h5>Telefon</h5>
                                    <p>+90 555 123 4567</p>
                                </div>
                            </div>
                            <div class='info-item mb-4'>
                                <i class='fas fa-map-marker-alt text-danger me-2'></i>
                                <div>
                                    <h5>Konum</h5>
                                    <p>Sakarya Üniversitesi, Esentepe Kampüsü</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-6'>
                        <div class='content-card'>
                            <h3 class='mb-4'>Gönderilen Mesaj</h3>
                            <div class='alert alert-success'>
                                <p><strong>Ad Soyad:</strong> " . htmlspecialchars($name) . "</p>
                                <p><strong>E-posta:</strong> " . htmlspecialchars($email) . "</p>
                                <p><strong>Telefon:</strong> " . htmlspecialchars($phone) . "</p>
                                <p><strong>Konu:</strong> " . htmlspecialchars($subject) . "</p>
                                <p><strong>Mesaj:</strong> " . htmlspecialchars($message) . "</p>
                                <p><strong>Tarih:</strong> " . date('d.m.Y H:i') . "</p>
                            </div>
                            <div class='d-flex gap-2'>
                                <a href='../contact.html' class='btn btn-primary'>Yeni Mesaj Gönder</a>
                                <a href='../form_submissions.html' class='btn btn-secondary'>Tüm Mesajları Gör</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class='bg-dark text-center text-white py-4 mt-5'>
                <div class='container'>
                    <div class='social-icons'>
                        <a href='#' target='_blank' class='text-white me-3'><i class='fab fa-github'></i></a>
                        <a href='#' target='_blank' class='text-white me-3'><i class='fab fa-linkedin'></i></a>
                        <a href='#' target='_blank' class='text-white me-3'><i class='fab fa-instagram'></i></a>
                        <a href='#' target='_blank' class='text-white'><i class='fab fa-twitter'></i></a>
                    </div>
                    <small class='mt-3 d-block text-white'>&copy; 2025 ZDK | Tüm Hakları Saklıdır.</small>
                </div>
            </footer>

            <!-- Bootstrap JS -->
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html lang='tr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Hata - ZDK</title>
            
            <!-- Bootstrap CSS -->
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
            
            <!-- Google Fonts -->
            <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
            
            <!-- Font Awesome -->
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>
            
            <!-- Stil Dosyalarımız -->
            <link rel='stylesheet' href='../assets/css/style.css'>
            <link rel='stylesheet' href='../assets/css/contact.css'>
        </head>
        <body>
            <!-- Navbar -->
            <nav class='navbar navbar-expand-lg navbar-light shadow-sm'>
                <div class='container'>
                    <a class='navbar-brand fw-bold' href='../index.html'>ZDK</a>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse' id='navbarNav'>
                        <ul class='navbar-nav ms-auto align-items-center'>
                            <li class='nav-item'><a class='nav-link' href='../index.html'>Anasayfa</a></li>
                            <li class='nav-item'><a class='nav-link' href='../cv.html'>Özgeçmiş</a></li>
                            <li class='nav-item'><a class='nav-link' href='../city.html'>Şehrim</a></li>
                            <li class='nav-item'><a class='nav-link' href='../interests.html'>İlgi Alanlarım</a></li>
                            <li class='nav-item'><a class='nav-link active' href='../contact.html'>İletişim</a></li>
                            <li class='nav-item'><a class='btn btn-light btn-sm ms-2' href='../login.html'>Giriş</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Başlık -->
            <header class='hero-section text-center text-white d-flex align-items-center'>
                <div class='container'>
                    <h1 class='display-4 fw-bold'>Hata Oluştu</h1>
                    <p class='lead'>Mesajınız gönderilirken bir sorun oluştu.</p>
                </div>
            </header>

            <!-- Hata Mesajı -->
            <section class='container py-5'>
                <div class='row justify-content-center'>
                    <div class='col-lg-8'>
                        <div class='content-card'>
                            <div class='alert alert-danger'>
                                <h3>Üzgünüz!</h3>
                                <p>Mesajınız gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.</p>
                                <div class='d-flex gap-2'>
                                    <a href='../contact.html' class='btn btn-primary'>Tekrar Dene</a>
                                    <a href='../index.html' class='btn btn-secondary'>Ana Sayfaya Dön</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class='bg-dark text-center text-white py-4 mt-5'>
                <div class='container'>
                    <div class='social-icons'>
                        <a href='#' target='_blank' class='text-white me-3'><i class='fab fa-github'></i></a>
                        <a href='#' target='_blank' class='text-white me-3'><i class='fab fa-linkedin'></i></a>
                        <a href='#' target='_blank' class='text-white me-3'><i class='fab fa-instagram'></i></a>
                        <a href='#' target='_blank' class='text-white'><i class='fab fa-twitter'></i></a>
                    </div>
                    <small class='mt-3 d-block text-white'>&copy; 2025 ZDK | Tüm Hakları Saklıdır.</small>
                </div>
            </footer>

            <!-- Bootstrap JS -->
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
        </body>
        </html>";
    }
} else {
    header("Location: ../contact.html");
    exit();
}
?> 