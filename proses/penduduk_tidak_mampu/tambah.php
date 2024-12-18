<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$no_kk = $_POST['no_kk'];
$status = $_POST['status'];

// Buat query SQL untuk menambahkan data penduduk ke dalam database
$query = "INSERT INTO penduduk_tidak_mampu (no_kk, status) 
          VALUES ('$no_kk', '$status')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
