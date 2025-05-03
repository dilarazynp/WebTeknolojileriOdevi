<?php
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="assets/images/large.png" alt="ZDK Logo" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.html">Anasayfa</a></li>
                <li class="nav-item"><a class="nav-link" href="resume.html">Özgeçmiş</a></li>
                <li class="nav-item"><a class="nav-link" href="sehrim.html">Şehrim</a></li>
                <li class="nav-item"><a class="nav-link" href="interests.html">İlgi Alanlarım</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">İletişim</a></li>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                    <li class="nav-item">
                        <span class="nav-link">Hoş geldiniz, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-2" href="php/logout.php">Çıkış Yap</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-2<?php echo basename($_SERVER['PHP_SELF']) === 'login.html' ? ' active' : ''; ?>" href="login.html">Giriş</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 