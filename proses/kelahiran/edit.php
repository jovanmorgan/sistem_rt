<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_kelahiran = $_POST['id_kelahiran'];
$id_penduduk = $_POST['id_penduduk'];
$nama_ayah = $_POST['nama_ayah'];
$nama_ibu = $_POST['nama_ibu'];

// Update data penduduk
$query_update = "UPDATE kelahiran 
                 SET id_penduduk = '$id_penduduk', nama_ayah = '$nama_ayah', nama_ibu = '$nama_ibu' 
                 WHERE id_kelahiran = '$id_kelahiran'";

// Jalankan query update
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
