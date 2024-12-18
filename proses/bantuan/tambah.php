<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$no_kk = $_POST['no_kk'];
$nama_bantuan = $_POST['nama_bantuan'];

// Buat query SQL untuk menambahkan data penduduk ke dalam database
$query = "INSERT INTO bantuan (no_kk, nama_bantuan) 
          VALUES ('$no_kk', '$nama_bantuan')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
