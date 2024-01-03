<?php
include 'koneksi.php';

// Menambahkan data stok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama']) && isset($_POST['jumlah']) && isset($_POST['harga'])) {
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
$harga = str_replace(".", "", $harga); // Menghilangkan titik pemisah ribuan
// Lanjutkan proses penyimpanan data ke database


    $sql = "INSERT INTO stok (nama_produk, jumlah, harga) VALUES ('$nama', '$jumlah', '$harga')";
    if ($koneksi->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}


// Menghapus data stok
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM stok WHERE id='$id'";
    if ($koneksi->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}


?>
