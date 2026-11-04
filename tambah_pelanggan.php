<?php
session_start();

if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'function.php';

if (isset($_POST['submit'])) {
    if (tambah_pelanggan($_POST) > 0) {
        echo "<script>
        alert('Data pelanggan berhasil dimasukkan ke database!');
        document.location.href = 'pelanggan.php';
        </script>";
    } else {
        echo "<script>
        alert('Data pelanggan gagal dimasukkan ke database!');
        document.location.href = 'tambah_pelanggan.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - Sistem Sewa Laptop</title>
    <!-- Menggunakan CSS Murni Sesuai Tema -->
    <link rel="stylesheet" href="style.css">
</head>

<body>


    <nav class="navbar-custom">
        <div class="nav-container">
            <a class="navbar-brand" href="pelanggan.php">&larr; Kembali ke Data Pelanggan</a>
            <span style="color: var(--white); font-weight: 600;">Sistem Sewa Laptop</span>
        </div>
    </nav>


    <div class="main-container" style="max-width: 600px;">
        <div class="form-card">
            <h3 style="margin-bottom: 25px; color: var(--primary-color);">Form Tambah Pelanggan</h3>

            <form action="" method="POST">

                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama lengkap pelanggan" required>
                </div>

            
                <div class="form-group">
                    <label for="telepon">Nomor Telepon / HP</label>
                    <input type="text" name="telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                </div>


                <div class="form-group">
                    <label for="no_identitas">Nomor Identitas (KTP / SIM)</label>
                    <input type="text" name="no_identitas" class="form-control" placeholder="Masukkan nomor identitas" required>
                </div>


                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat sesuai identitas" required></textarea>
                </div>


                <div class="button-group" style="display: flex; gap: 10px; margin-top: 25px;">
                    <button type="submit" name="submit" class="btn btn-primary" style="flex: 1;">Simpan Data</button>
                    <a href="pelanggan.php" class="btn btn-outline-secondary" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>