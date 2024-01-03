<?php
session_start();

// Hapus semua data sesi
$_SESSION = array();

// Hapus sesi
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit;
?>
