<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sewa_laptop"; 

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Fungsi bantu query database
function query_db($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function registrasi($data)
{
    global $koneksi;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $konfirmasi_password = mysqli_real_escape_string($koneksi, $data["konfirmasi_password"]);

    $result = mysqli_query($koneksi, "SELECT username FROM admin WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar! Gunakan Username lainnya!');
              </script>";
        return false;
    }

    // Konfirmasi Password
    if ($password !== $konfirmasi_password) {
        echo "<script>
                alert('Konfirmasi Password tidak sesuai');
              </script>";
        return false;
    }

    // Enkripsi Password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan ke database
    mysqli_query($koneksi, "INSERT INTO admin VALUES('', '$username', '$password')");
    return mysqli_affected_rows($koneksi);
}
?>