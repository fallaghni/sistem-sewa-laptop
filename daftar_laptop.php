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

$data_laptop = query_db("SELECT * FROM laptop");

if (isset($_POST["cari"])) {
    $keyword = mysqli_real_escape_string($koneksi, $_POST["keyword"]);
    $data_laptop = query_db("SELECT * FROM laptop WHERE merk_laptop LIKE '%$keyword%' OR spesifikasi LIKE '%$keyword%'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laptop - Sistem Sewa Laptop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar-custom">
        <div class="nav-container">
            <a class="navbar-brand" href="index.php">Sewa Laptop</a>
            <ul class="navbar-nav">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="pelanggan.php">Data Pelanggan</a></li>
                <li><a href="daftar_laptop.php" class="active">Data Laptop</a></li>
                <li><a href="transaksi.php">Data Transaksi</a></li>
                <li><a href="logout.php" class="text-danger">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="main-container" style="max-width: 1000px;">
        <div class="form-card" style="max-width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: var(--primary-color);">Daftar Laptop Tersedia</h3>
                <a href="tambah_laptop.php" class="btn btn-primary" style="width: auto; padding: 10px 20px; text-decoration: none;">+ Tambah Laptop</a>
            </div>

            <form action="" method="POST" style="margin-bottom: 20px; display: flex; gap: 10px;">
                <input type="text" name="keyword" class="form-control" placeholder="Cari merk atau spesifikasi laptop..." style="max-width: 350px;" autocomplete="off">
                <button type="submit" name="cari" class="btn btn-primary" style="width: auto; padding: 10px 20px;">Cari</button>
            </form>

            <div style="overflow-x: auto;">
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; border-color: var(--border-color);">
                    <thead>
                        <tr style="background-color: var(--bg-light); text-align: left;">
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Merk Laptop</th>
                            <th>Spesifikasi</th>
                            <th>Harga Sewa / Hari</th>
                            <th>Stok</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_laptop)) : ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px; color: #7f8c8d;">Belum ada data laptop yang tersedia.</td>
                            </tr>
                        <?php endif; ?>

                        <?php $no = 1; ?>
                        <?php foreach ($data_laptop as $laptop): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <img src="img/<?= htmlspecialchars($laptop["gambar"]); ?>" alt="Laptop" width="70" style="border-radius: 6px; object-fit: cover; height: 50px;">
                            </td>
                            <td><?= htmlspecialchars($laptop["merk_laptop"]); ?></td>
                            <td><?= htmlspecialchars($laptop["spesifikasi"]); ?></td>
                            <td>Rp <?= number_format($laptop["harga_sewa_per_hari"], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($laptop["stok"]); ?> Unit</td>
                            <td style="text-align: center;">
                                <a href="edit_laptop.php?id_laptop=<?= $laptop["id_laptop"]; ?>" class="btn btn-warning btn-sm" style="background: #f39c12; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; display: inline-block; margin-right: 5px;">Edit</a>
                                <a href="hapus_laptop.php?id_laptop=<?= $laptop["id_laptop"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data laptop ini?');" style="background: #e74c3c; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; display: inline-block;">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>