<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_masuk = $_POST['id_masuk'];
$id_penduduk = $_POST['id_penduduk'];
$alasan = $_POST['alasan'];
$tanggal_masuk = $_POST['tanggal_masuk'];

// Update data penduduk
$query_update = "UPDATE penduduk_masuk 
                 SET id_penduduk = '$id_penduduk', alasan = '$alasan', tanggal_masuk = '$tanggal_masuk' 
                 WHERE id_masuk = '$id_masuk'";

// Jalankan query update
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
