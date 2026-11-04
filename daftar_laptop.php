<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

// Menyesuaikan pemanggilan file koneksi/function yang benar
require 'koneksi.php';

// Pastikan fungsi tambah_laptop sudah ada di koneksi.php atau function.php yang Anda pakai
if (isset($_POST['submit'])) {
    if (tambah_laptop($_POST) > 0) {
        echo "<script>
                alert('Data laptop berhasil ditambahkan!');
                document.location.href = 'daftar_laptop.php';
              </script>";
    } else {
        echo "<script>
                alert('Data laptop gagal ditambahkan!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Laptop - Sistem Sewa Laptop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar-custom">
        <div class="nav-container">
            <!-- Tautan kembali diarahkan dengan benar ke daftar_laptop.php -->
            <a class="navbar-brand" href="daftar_laptop.php">&larr; Kembali ke Data Laptop</a>
            <span style="color: var(--white); font-weight: 600;">Sistem Sewa Laptop</span>
        </div>
    </nav>

    <div class="main-container" style="max-width: 600px;">
        <div class="form-card">
            <h3 style="margin-bottom: 25px; color: var(--primary-color);">Form Tambah Laptop Baru</h3>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="merk_laptop">Merk & Tipe Laptop</label>
                    <input type="text" name="merk_laptop" class="form-control" placeholder="Contoh: Asus ROG / Lenovo" required>
                </div>

                <div class="form-group">
                    <label for="spesifikasi">Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Contoh: Core i5, RAM 8GB" required></textarea>
                </div>

                <div class="form-group">
                    <label for="harga_sewa_per_hari">Harga Sewa per Hari (Rp)</label>
                    <input type="number" name="harga_sewa_per_hari" class="form-control" placeholder="Contoh: 75000" required>
                </div>

                <div class="form-group">
                    <label for="stok">Jumlah Stok Unit</label>
                    <input type="number" name="stok" class="form-control" placeholder="Contoh: 5" required>
                </div>

                <div class="form-group">
                    <label for="gambar">Foto Laptop</label>
                    <input type="file" name="gambar" class="form-control" required style="padding: 7px;">
                </div>

                <div class="button-group" style="display: flex; gap: 10px; margin-top: 25px;">
                    <button type="submit" name="submit" class="btn btn-primary" style="flex: 1;">Simpan Laptop</button>
                    <!-- Tombol Batal diarahkan langsung ke daftar_laptop.php -->
                    <a href="daftar_laptop.php" class="btn btn-outline-secondary" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>