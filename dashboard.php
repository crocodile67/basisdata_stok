<?php include 'koneksi.php'; ?>

<h2>Dashboard Stok Gudang</h2>
<head>
    <link rel="stylesheet" href="style.css">
</head>

<?php
// Variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Bagian ringkasan stok
$sql = "SELECT SUM(jumlah) AS total_stok, SUM(jumlah * harga) AS total_harga FROM stok";
$result = $koneksi->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $total_stok = $row['total_stok'];
    $total_harga = $row['total_harga'];
} else {
    $total_stok = 0;
    $total_harga = 0;
}

// Query untuk mengambil daftar nama produk yang diurutkan
$sql_nama_produk = "SELECT DISTINCT nama_produk FROM stok ORDER BY nama_produk ASC";
$result_nama_produk = $koneksi->query($sql_nama_produk);
$nama_produk_array = [];
if ($result_nama_produk->num_rows > 0) {
    while ($row = $result_nama_produk->fetch_assoc()) {
        $nama_produk_array[] = $row['nama_produk'];
    }
}
?>

<h3>Ringkasan Stok:</h3>
<p>Total Produk: <?php echo $total_stok; ?></p>
<p>Total Nilai Stok: <?php echo $total_harga; ?></p>

<!-- Form pencarian -->
<form action="" method="GET">
    <label for="search">Cari Nama Produk:</label>
    <input type="text" id="search" name="search" list="nama_produk_list" value="<?php echo $search; ?>">
    <datalist id="nama_produk_list">
        <?php
        foreach ($nama_produk_array as $nama_produk) {
            echo "<option value='$nama_produk'>";
        }
        ?>
    </datalist>
    <input type="submit" value="Cari">
</form>
<!-- Form untuk menambah data stok -->
<form action="controller.php" method="POST" class="add-stock-form">
    <h3>Tambah Data Stok</h3>
    <label for="nama">Nama Produk:</label><br>
    <input type="text" id="nama" name="nama"><br>
    <label for="jumlah">Jumlah:</label><br>
    <input type="number" id="jumlah" name="jumlah"><br>
    <label for="harga">Harga:</label><br>
    <input type="text" id="harga" name="harga" value="">
    <input type="submit" value="Tambah">
</form>
<br>
<br>
<!-- Tampilkan data stok -->
<div class="scrollable-table">
    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Query dengan pencarian
        $sql = "SELECT * FROM stok WHERE nama_produk LIKE '%$search%' ORDER BY nama_produk ASC";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nama_produk'] . "</td>";
                echo "<td>" . $row['jumlah'] . "</td>";
                 // Mengubah format harga menjadi Rupiah tanpa desimal
                 echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                 echo "<td><a class='btn-edit' href='edit.php?id=" . $row['id'] . "'>Edit</a><a class='btn-delete' href='controller.php?action=delete&id=" . $row['id'] . "'>Hapus</a></td>";
                 echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data dalam stok.</td></tr>";
        }
        ?>
    </table>
</div>


<!-- Form untuk stok keluar -->
<form action="controller_stok_keluar.php" method="POST" class="stock-out-form">
    <h3>Stok Keluar</h3>
    <label for="produk_keluar">Nama Produk:</label><br>
    <input type="text" id="produk_keluar" name="produk_keluar" list="nama_produk_list"><br>
    <datalist id="nama_produk_list">
        <?php
        foreach ($nama_produk_array as $nama_produk) {
            echo "<option value='$nama_produk'>";
        }
        ?>
    </datalist><br>
    <label for="jumlah_keluar">Jumlah Keluar:</label><br>
    <input type="text" id="jumlah_keluar" name="jumlah_keluar"><br>
    <input type="submit" value="Keluar">
</form>

<div class="logout-form">
    <form action="controller_logout.php" method="POST">
        <input class="logout-btn" type="submit" name="logout" value="Logout">
    </form>
</div>


<script>
document.getElementById('harga').addEventListener('input', function (e) {
  let harga = e.target.value;
  harga = harga.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  e.target.value = harga;
});

</script>

