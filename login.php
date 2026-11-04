<?php
session_start();

require 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");

    // Cek username
    if (mysqli_num_rows($result) === 1) {
        // Cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['session_login'] = true;
            $_SESSION['username'] = $username;

            header('Location: index.php');
            exit;
        } else {
            echo "<script>
                alert('Password yang kamu masukkan salah!');
                </script>";
        }
    } else {
        echo "<script>
            alert('Username yang kamu masukkan salah atau tidak ditemukan!');
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Sewa Laptop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-register">

    <div class="container">
        <div class="form-card">
            <h3>Login Sewa Laptop</h3>

            <form action="" method="post">
                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <!-- Button Group -->
                <div class="button-group">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                    <a href="registrasi.php" class="btn btn-outline-secondary">Belum punya akun? Registrasi</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>