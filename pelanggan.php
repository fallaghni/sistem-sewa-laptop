<?php
session_start();

if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'koneksi.php';

if (!function_exists('query_db')) {
    function query_db($query) {
        global $koneksi;
        $result = mysqli_query($koneksi, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

if (!function_exists('cari_pelanggan')) {
    function cari_pelanggan($keyword) {
        $query = "SELECT * FROM pelanggan WHERE 
                  nama_pelanggan LIKE '%$keyword%' OR 
                  alamat LIKE '%$keyword%' OR 
                  telepon LIKE '%$keyword%' OR 
                  no_identitas LIKE '%$keyword%'";
        return query_db($query);
    }
}

// Pagination
$jumlahDataPerHalaman = 5;
$jumlahData = count(query_db("SELECT * FROM pelanggan"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;
if ($halamanAktif < 1) {
    $halamanAktif = 1;
} elseif ($halamanAktif > $jumlahHalaman && $jumlahHalaman > 0) {
    $halamanAktif = $jumlahHalaman;
}
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// Ambil data
$data_pelanggan = query_db("SELECT * FROM pelanggan LIMIT $awalData, $jumlahDataPerHalaman");

if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $data_pelanggan = cari_pelanggan($keyword);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pelanggan - Sistem Sewa Laptop</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link font-weight-bold">
                        Sistem Informasi Penyewaan Laptop
                    </span>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link">
                        <i class="fas fa-user-circle"></i>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger"
                        onclick="return confirm('Apakah yakin mau logout?');">
                        <i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index.php" class="brand-link">
                <i class="fas fa-laptop ml-3 mr-2"></i>
                <span class="brand-text font-weight-light">Sewa Laptop</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pelanggan.php" class="nav-link active">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Data Pelanggan</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Data Pelanggan</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pelanggan</h3>
                            <div class="card-tools">
                                <a href="tambah_pelanggan.php" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Pelanggan
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" class="mb-3">
                                <div class="input-group" style="max-width: 400px;">
                                    <input type="text" name="keyword" class="form-control" placeholder="Cari Pelanggan...">
                                    <div class="input-group-append">
                                        <button type="submit" name="cari" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>No. Identitas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = $awalData + 1; ?>
                                        <?php foreach ($data_pelanggan as $data): ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $data["id_pelanggan"]; ?></td>
                                                <td><?php echo htmlspecialchars($data["nama_pelanggan"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["alamat"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["telepon"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["no_identitas"]); ?></td>
                                                <td>
                                                    <a href="edit_pelanggan.php?id_pelanggan=<?php echo $data["id_pelanggan"] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="hapus_pelanggan.php?id_pelanggan=<?php echo $data["id_pelanggan"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <br><br>

                            <!-- Pagination -->
                            <div class="pagination-wrapper">
                                <div class="pagination justify-content-center">
                                    <!-- Prev -->
                                    <?php if ($halamanAktif > 1): ?>
                                        <a href="?halaman=<?php echo $halamanAktif - 1; ?>" class="btn btn-outline-primary btn-sm mx-1">&larr; Prev</a>
                                    <?php else: ?>
                                        <span class="btn btn-outline-secondary btn-sm mx-1 disabled">&larr; Prev</span>
                                    <?php endif; ?>

                                    <!-- Nomor Halaman -->
                                    <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                        <?php if ($i == $halamanAktif): ?>
                                            <a href="?halaman=<?php echo $i; ?>" class="btn btn-primary btn-sm mx-1 active"><?php echo $i; ?></a>
                                        <?php else: ?>
                                            <a href="?halaman=<?php echo $i; ?>" class="btn btn-outline-primary btn-sm mx-1"><?php echo $i; ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <!-- Next -->
                                    <?php if ($halamanAktif < $jumlahHalaman): ?>
                                        <a href="?halaman=<?php echo $halamanAktif + 1; ?>" class="btn btn-outline-primary btn-sm mx-1">Next &rarr;</a>
                                    <?php else: ?>
                                        <span class="btn btn-outline-secondary btn-sm mx-1 disabled">Next &rarr;</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- jQuery -->
        <script src="assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="assets/dist/js/adminlte.min.js"></script>
    </div>
</body>

</html>