<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require_once 'koneksi.php';

$id_pelanggan = (int) $_GET['id_pelanggan'];


$cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_pelanggan = $id_pelanggan");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Data tidak dapat dihapus karena pelanggan masih memiliki riwayat transaksi sewa!');
        document.location.href = 'pelanggan.php';
    </script>";
} else {
    $query = "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
    mysqli_query($conn, $query);
    
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
            alert('Data pelanggan berhasil dihapus!');
            document.location.href = 'pelanggan.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = 'pelanggan.php';
        </script>";
    }
}
?>