<?php
// Koneksi ke database
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari formulir stok keluar
    $produk_keluar = $_POST['produk_keluar'];
    $jumlah_keluar = $_POST['jumlah_keluar'];

    // Lakukan validasi data (pastikan data sesuai dengan kebutuhan Anda)

    // Proses stok keluar
    $sql = "UPDATE stok SET jumlah = jumlah - $jumlah_keluar WHERE nama_produk = '$produk_keluar'";
    $result = $koneksi->query($sql);

    if ($result) {
        // Jika berhasil mengurangi stok, bisa tambahkan pesan atau arahkan kembali ke halaman yang diinginkan
        header('Location: dashboard.php');
        exit();
    } else {
        // Jika gagal, tampilkan pesan error atau arahkan kembali dengan pesan yang sesuai
        echo "Gagal mengurangi stok keluar.";
    }
}
?>
