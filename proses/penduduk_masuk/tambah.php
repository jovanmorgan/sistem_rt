<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_penduduk = $_POST['id_penduduk'];
$alasan = $_POST['alasan'];
$tanggal_masuk = $_POST['tanggal_masuk'];

// Buat query SQL untuk menambahkan data penduduk ke dalam database
$query = "INSERT INTO penduduk_masuk (id_penduduk, alasan, tanggal_masuk) 
          VALUES ('$id_penduduk', '$alasan', '$tanggal_masuk')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
