<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require_once 'koneksi.php';
require_once 'function.php';

if (isset($_POST['submit'])) {
    if (tambah_laptop($_POST) > 0) {
        echo "<script>
                alert('Data laptop berhasil ditambahkan!');
                document.location.href = 'daftar_laptop.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambahkan!');
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
            <a class="navbar-brand" href="daftar_laptop.php">&larr; Kembali ke Data Laptop</a>
            <span style="color: var(--white); font-weight: 600;">Sistem Sewa Laptop</span>
        </div>
    </nav>

    <div class="main-container" style="max-width: 600px;">
        <div class="form-card">
            <h3 style="margin-bottom: 25px; color: var(--primary-color);">Form Tambah Data Laptop</h3>

            <form action="" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="merk_laptop">Merk Laptop</label>
                    <input type="text" name="merk_laptop" class="form-control" placeholder="Contoh: Asus ROG / Lenovo Legion" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="spesifikasi">Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Contoh: Core i7, RAM 16GB, SSD 512GB" required></textarea>
                </div>

                <div class="form-group">
                    <label for="harga_sewa_per_hari">Harga Sewa / Hari (Rp)</label>
                    <input type="number" name="harga_sewa_per_hari" class="form-control" placeholder="Contoh: 75000" required>
                </div>

                <div class="form-group">
                    <label for="stok">Stok Unit</label>
                    <input type="number" name="stok" class="form-control" placeholder="Contoh: 5" required>
                </div>

                <div class="form-group">
                    <label for="gambar">Foto / Gambar Laptop</label>
                    <input type="file" name="gambar" class="form-control" required style="padding: 8px;">
                    <small style="color: #7f8c8d; font-size: 12px;">Format yang diperbolehkan: JPG, JPEG, PNG, WEBP (Maks. 2MB)</small>
                </div>

                <div class="button-group" style="display: flex; gap: 10px; margin-top: 25px;">
                    <button type="submit" name="submit" class="btn btn-primary" style="flex: 1;">Tambah Laptop</button>
                    <a href="daftar_laptop.php" class="btn btn-outline-secondary" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>