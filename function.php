<?php
//konek ke database
$conn = mysqli_connect("localhost", "root", "", "db_sewa_laptop");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

//ambil data umum / universal
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

function hapus_pelanggan($id_pelanggan)
{
    global $conn;

    $cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_pelanggan = $id_pelanggan");

    if (mysqli_num_rows($cek) > 0) {
        return "memiliki_transaksi";
    }

    $query = "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan";

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
   FUNGSI - FUNGSI LAPTOP
   ========================================== */

function upload_gambar()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>alert('Pilih gambar laptop terlebih dahulu!');</script>";
        return false;
    }

    // Cek ekstensi file yang diperbolehkan
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "<script>alert('Yang anda upload bukan file gambar (jpg/jpeg/png/webp)!');</script>";
        return false;
    }

    // Cek ukuran file (maksimal 2MB)
    if ($ukuranFile > 2000000) {
        echo "<script>alert('Ukuran gambar terlalu besar (Maksimal 2MB)!');</script>";
        return false;
    }

    // Generate nama file baru yang unik untuk menghindari duplikasi
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

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

    // Jalankan fungsi upload gambar
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

    // Cek apakah user pilih gambar baru atau tidak
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

    // Ambil data gambar lama untuk dihapus dari folder img/
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

    // DIPERBAIKI: Menghapus backslash yang keliru pada query pencarian
    $query = "SELECT * FROM laptop WHERE merk_laptop LIKE '%$keyword%' OR spesifikasi LIKE '%$keyword%'";
    return query_db($query);
}


/* ==========================================
   FUNGSI - FUNGSI TRANSAKSI
   ========================================== */

function tambah_transaksi($data)
{
    global $conn;

    $id_pelanggan = $data['id_pelanggan'];
    $id_laptop = $data['id_laptop'];
    $tanggal_sewa = $data['tanggal_sewa'];
    $tanggal_kembali = $data['tanggal_kembali'];
    $total_biaya = $data['total_biaya'];
    $status_sewa = $data['status_sewa'];

    $query = "INSERT INTO transaksi(id_pelanggan, id_laptop, tanggal_sewa, tanggal_kembali, total_biaya, status_sewa)
              VALUES ('$id_pelanggan', '$id_laptop', '$tanggal_sewa', '$tanggal_kembali', '$total_biaya', '$status_sewa')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_transaksi($data)
{
    global $conn;
    
    $id_transaksi = $data['id_transaksi'];
    $id_pelanggan = $data['id_pelanggan'];
    $id_laptop = $data['id_laptop'];
    $tanggal_sewa = $data['tanggal_sewa'];
    $tanggal_kembali = $data['tanggal_kembali'];
    $total_biaya = $data['total_biaya'];
    $status_sewa = $data['status_sewa'];

    $query = "UPDATE transaksi SET 
    id_pelanggan = '$id_pelanggan',
    id_laptop = '$id_laptop',
    tanggal_sewa = '$tanggal_sewa',
    tanggal_kembali = '$tanggal_kembali',
    total_biaya = '$total_biaya',
    status_sewa = '$status_sewa'
    WHERE id_transaksi = $id_transaksi";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_transaksi($id_transaksi)
{
    global $conn;
    $query = "DELETE FROM transaksi WHERE id_transaksi = $id_transaksi";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari_transaksi($keyword)
{
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT transaksi.id_transaksi, pelanggan.nama_pelanggan, laptop.merk_laptop, 
            transaksi.tanggal_sewa, transaksi.tanggal_kembali, transaksi.total_biaya, transaksi.status_sewa 
            FROM transaksi 
            INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan 
            INNER JOIN laptop ON laptop.id_laptop = transaksi.id_laptop 
            WHERE pelanggan.nama_pelanggan LIKE '%$keyword%' OR 
            laptop.merk_laptop LIKE '%$keyword%' OR 
            transaksi.status_sewa LIKE '%$keyword%'";

    return query_db($query);
}


/* ==========================================
   FUNGSI REGISTRASI ADMIN
   ========================================== */

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

    // DIPERBAIKI: Melengkapi proses enkripsi dan query simpan registrasi yang sebelumnya terpotong
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO admin VALUES('', '$username', '$password')");
    return mysqli_affected_rows($conn);
}
?>