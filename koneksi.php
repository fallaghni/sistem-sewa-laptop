<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sewa_laptop"; 

// Mendefinisikan kedua variabel agar kompatibel di semua file
$conn = mysqli_connect($host, $user, $pass, $db);
$koneksi = $conn;

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Fungsi query universal
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
?>