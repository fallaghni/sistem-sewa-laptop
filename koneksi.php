<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sewa_laptop"; 

$conn = mysqli_connect($host, $user, $pass, $db);
$koneksi = $conn;

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (!function_exists('query_db')) {
    function query_db($query)
    {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

if (!function_exists('registrasi')) {
    function registrasi($data)
    {
        global $conn;

        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $konfirmasi_password = mysqli_real_escape_string($conn, $data["konfirmasi_password"]);

        $result = mysqli_query($conn, "SELECT username FROM admin WHERE username = '$username'");

        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                    alert('Username sudah terdaftar! Gunakan Username lainnya!');
                  </script>";
            return false;
        }

        if ($password !== $konfirmasi_password) {
            echo "<script>
                    alert('Konfirmasi Password tidak sesuai');
                  </script>";
            return false;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "INSERT INTO admin VALUES('', '$username', '$password')");
        return mysqli_affected_rows($conn);
    }
}
?>