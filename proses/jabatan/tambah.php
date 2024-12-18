<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$jabatan = $_POST['jabatan'];

// Lakukan validasi data
if (empty($jabatan)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO jabatan (jabatan) 
        VALUES ('$jabatan')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
