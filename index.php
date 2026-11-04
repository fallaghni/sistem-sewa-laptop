<?php
session_start();

if (!isset($_SESSION['session_login'])) {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Sewa Laptop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar / Menu Navigasi -->
    <nav class="navbar-custom">
        <div class="nav-container">
            <a class="navbar-brand" href="index.php">Sewa Laptop</a>
            <ul class="navbar-nav">
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="pelanggan.php">Data Pelanggan</a></li>
                <li><a href="daftar_laptop.php">Data Laptop</a></li>
                <li><a href="transaksi.php">Data Transaksi</a></li>
                <li><a href="logout.php" class="text-danger">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Konten Utama Dashboard -->
    <div class="main-container">
        <div class="welcome-card">
            <h1>Selamat Datang, Admin!</h1>
            <p>Anda telah masuk ke dalam Sistem Manajemen Penyewaan Laptop. Gunakan menu di atas atau tombol di bawah untuk mengelola data penyewaan.</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="pelanggan.php" class="btn btn-primary">Kelola Data Pelanggan</a>
                <a href="daftar_laptop.php" class="btn btn-warning" style="background-color: #f39c12; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 600;">Kelola Data Laptop</a>
                <a href="transaksi.php" class="btn btn-success" style="background-color: #27ae60; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 600;">Kelola Data Transaksi</a>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>