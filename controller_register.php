<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input
    // Misalnya, cek apakah username atau email sudah digunakan sebelumnya
    $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $koneksi->query($checkQuery);

    if ($result->num_rows > 0) {
        echo '<script>alert("Username atau email sudah digunakan.");</script>';
        // Redirect kembali ke halaman register jika ada kesalahan
        echo '<script>window.location.href = "register.php";</script>';
        exit();
    } else {
        // Jika username dan email belum digunakan, simpan ke database
        $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($koneksi->query($insertQuery) === TRUE) {
            echo '<script>alert("Registrasi berhasil. Silakan login.");</script>';
            // Redirect ke halaman login jika registrasi berhasil
            header("Location: login.php");
            exit();
        } else {
            echo '<script>alert("Registrasi gagal. Silakan coba lagi.");</script>';
            // Redirect kembali ke halaman register jika ada kesalahan
            echo '<script>window.location.href = "register.php";</script>';
            exit();
        }
    }
}
?>
