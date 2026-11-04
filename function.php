<?php
require_once 'koneksi.php';

/* ==========================================
   FUNGSI - FUNGSI PELANGGAN
   ========================================== */

function tambah_pelanggan($data)
{
    global $conn;

    $nama_pelanggan = htmlspecialchars($data['nama_pelanggan']);
    $alamat = htmlspecialchars($data['alamat']);
    $telepon = htmlspecialchars($data['telepon']);
    $no_identitas = htmlspecialchars($data['no_identitas']);

    $query = "INSERT INTO pelanggan(nama_pelanggan, alamat, telepon, no_identitas)
              VALUES ('$nama_pelanggan', '$alamat', '$telepon', '$no_identitas')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_pelanggan($data)
{
    global $conn;

    $id_pelanggan = $data['id_pelanggan'];
    $nama_pelanggan = htmlspecialchars($data['nama_pelanggan']);
    $alamat = htmlspecialchars($data['alamat']);
    $telepon = htmlspecialchars($data['telepon']);
    $no_identitas = htmlspecialchars($data['no_identitas']);

    $query = "UPDATE pelanggan SET 
    nama_pelanggan = '$nama_pelanggan',
    alamat = '$alamat',
    telepon = '$telepon',
    no_identitas = '$no_identitas'
    WHERE id_pelanggan = $id_pelanggan";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari_pelanggan($keyword)
{
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT * FROM pelanggan WHERE nama_pelanggan LIKE '%$keyword%' OR
            alamat LIKE '%$keyword%' OR
            telepon LIKE '%$keyword%' OR
            no_identitas LIKE '%$keyword%'";

    return query_db($query);
}


/* ==========================================
   FUNGSI - FUNGSI LAPTOP (DENGAN UPLOAD GAMBAR)
   ========================================== */

function upload_gambar()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Pilih gambar laptop terlebih dahulu!');</script>";
        return false;
    }

    $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "<script>alert('Yang anda upload bukan file gambar (jpg/jpeg/png/webp)!');</script>";
        return false;
    }

    if ($ukuranFile > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar (Maksimal 2MB)!');</script>";
        return false;
    }

    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function tambah_laptop($data)
{
    global $conn;

    $merk_laptop = htmlspecialchars($data['merk_laptop']);
    $spesifikasi = htmlspecialchars($data['spesifikasi']);
    $harga_sewa = htmlspecialchars($data['harga_sewa_per_hari']);
    $stok = htmlspecialchars($data['stok']);

    $gambar = upload_gambar();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO laptop (merk_laptop, spesifikasi, harga_sewa_per_hari, stok, gambar) 
              VALUES ('$merk_laptop', '$spesifikasi', '$harga_sewa', '$stok', '$gambar')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_laptop($data)
{
    global $conn;

    $id_laptop = $data['id_laptop'];
    $merk_laptop = htmlspecialchars($data['merk_laptop']);
    $spesifikasi = htmlspecialchars($data['spesifikasi']);
    $harga_sewa = htmlspecialchars($data['harga_sewa_per_hari']);
    $stok = htmlspecialchars($data['stok']);
    $gambarLama = htmlspecialchars($data['gambarLama']);

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload_gambar();
        if (!$gambar) {
            return false;
        }
    }

    $query = "UPDATE laptop SET 
              merk_laptop = '$merk_laptop',
              spesifikasi = '$spesifikasi',
              harga_sewa_per_hari = '$harga_sewa',
              stok = '$stok',
              gambar = '$gambar'
              WHERE id_laptop = $id_laptop";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_laptop($id_laptop)
{
    global $conn;

    $cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_laptop = $id_laptop");
    if (mysqli_num_rows($cek) > 0) {
        return "memiliki_transaksi";
    }

    $laptop = query_db("SELECT * FROM laptop WHERE id_laptop = $id_laptop")[0];
    if (file_exists('img/' . $laptop['gambar'])) {
        unlink('img/' . $laptop['gambar']);
    }

    $query = "DELETE FROM laptop WHERE id_laptop = $id_laptop";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari_laptop($keyword)
{
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT * FROM laptop WHERE merk_laptop LIKE '%$keyword%' OR spesifikasi LIKE '%$keyword%'";
    return query_db($query);
}
?>