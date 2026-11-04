<?php
session_start();

if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'function.php';

$id_pelanggan = $_GET['id_pelanggan'];
$pelanggan = query_db("SELECT * FROM pelanggan WHERE id_pelanggan = $id_pelanggan")[0];

if (isset($_POST['submit'])) {
    if (edit_pelanggan($_POST) >= 0) {
        echo "<script>
                alert('Data pelanggan berhasil diubah!');
                document.location.href = 'pelanggan.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan - Sistem Sewa Laptop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Navbar Custom -->
    <nav class="navbar-custom">
        <div class="nav-container">
            <a class="navbar-brand" href="pelanggan.php">&larr; Kembali ke Data Pelanggan</a>
            <span style="color: var(--white); font-weight: 600;">Sistem Sewa Laptop</span>
        </div>
    </nav>

    <!-- Konten Utama Form -->
    <div class="main-container" style="max-width: 600px;">
        <div class="form-card">
            <h3 style="margin-bottom: 25px; color: var(--primary-color);">Form Edit Data Pelanggan</h3>

            <form action="" method="post">
                <!-- ID Pelanggan Tersembunyi -->
                <input type="hidden" name="id_pelanggan" value="<?= $pelanggan['id_pelanggan']; ?>">

                <!-- Nama Pelanggan -->
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" value="<?= htmlspecialchars($pelanggan["nama_pelanggan"]); ?>" required>
                </div>

                <!-- Nomor Telepon (Menyesuaikan database) -->
                <div class="form-group">
                    <label for="telepon">Nomor Telepon / HP</label>
                    <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($pelanggan["telepon"]); ?>" required>
                </div>

                <!-- Nomor Identitas (KTP / SIM) -->
                <div class="form-group">
                    <label for="no_identitas">Nomor Identitas (KTP / SIM)</label>
                    <input type="text" name="no_identitas" class="form-control" value="<?= htmlspecialchars($pelanggan["no_identitas"]); ?>" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($pelanggan["alamat"]); ?></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="button-group" style="display: flex; gap: 10px; margin-top: 25px;">
                    <button type="submit" name="submit" class="btn btn-primary" style="flex: 1;">Simpan Perubahan</button>
                    <a href="pelanggan.php" class="btn btn-outline-secondary" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>