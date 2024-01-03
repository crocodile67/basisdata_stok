<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        // Jika berhasil login
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        // Jika login gagal, tampilkan pesan peringatan
        $alert = "Invalid username or password!";
    }
    // Logout jika tombol logout ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
}
?>