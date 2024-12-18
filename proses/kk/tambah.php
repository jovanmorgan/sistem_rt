<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$no_kk = $_POST['no_kk'];
$nama_kep_kel = $_POST['nama_kep_kel'];
$nik = $_POST['nik'];
$alamat = $_POST['alamat'];
$id_rt = $_POST['id_rt'];
$id_rw = $_POST['id_rw'];

// Lakukan validasi data
if (empty($no_kk) || empty($nama_kep_kel) || empty($nik) || empty($alamat) || empty($id_rt) || empty($id_rw)) {
    echo "data_tidak_lengkap";
    exit();
}

// Validasi no_kk harus 16 digit
if (strlen($no_kk) !== 16) {
    echo "no_kk_harus_16"; // Beri tahu jika no_kk tidak valid
    exit();
}

// Cek apakah no_kk sudah ada
$query_check = "SELECT * FROM kk WHERE no_kk = '$no_kk'";
$result_check = mysqli_query($koneksi, $query_check);
if (mysqli_num_rows($result_check) > 0) {
    echo "no_kk_sudah_ada"; // Beri tahu jika no_kk sudah ada
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO kk (no_kk, nama_kep_kel, nik, alamat, id_rt, id_rw) 
          VALUES ('$no_kk', '$nama_kep_kel', '$nik', '$alamat', '$id_rt', '$id_rw')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
