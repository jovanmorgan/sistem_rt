<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_ptm = $_POST['id_ptm'];
$no_kk = $_POST['no_kk'];
$status = $_POST['status'];

// Update data penduduk
$query_update = "UPDATE penduduk_tidak_mampu 
                 SET no_kk = '$no_kk', status = '$status'
                 WHERE id_ptm = '$id_ptm'";

// Jalankan query update
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
