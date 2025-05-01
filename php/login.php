<?php
session_start();

include('../includes/db.php'); // Veritabanı bağlantısı

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Veritabanında kontrol et
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        echo "Hoşgeldiniz, " . $username;
        // Başarı durumunda yönlendir
        header('Location: ../index.html');
    } else {
        echo "Yanlış kullanıcı adı veya şifre!";
        // Hata durumunda login sayfasına geri yönlendir
        header('Location: ../login.html');
    }
}
?>
