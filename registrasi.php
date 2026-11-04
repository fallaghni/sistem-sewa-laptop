<?php
// Menyesuaikan pemanggilan file koneksi/function
require 'koneksi.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Admin baru berhasil ditambahkan!');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan admin!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Sewa Laptop</title>
    <!-- Menggunakan Bootstrap 5.3 agar konsisten dengan halaman login & dashboard -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4 fw-bold">Registrasi Admin</h3>

                        <form action="" method="post">
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" class="form-control" placeholder="Masukkan kembali password" required>
                            </div>

                            <!-- Button Group -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" name="register" class="btn btn-dark btn-lg">Registrasi</button>
                                <a href="login.php" class="btn btn-outline-secondary">Sudah punya akun? Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>