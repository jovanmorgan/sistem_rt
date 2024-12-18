<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_bantuan = $_POST['id_bantuan'];
$no_kk = $_POST['no_kk'];
$nama_bantuan = $_POST['nama_bantuan'];

// Update data penduduk
$query_update = "UPDATE bantuan 
                 SET no_kk = '$no_kk', nama_bantuan = '$nama_bantuan'
                 WHERE id_bantuan = '$id_bantuan'";

// Jalankan query update
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
