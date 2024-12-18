<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_jabatan = $_POST['id_jabatan'];
$jabatan = $_POST['jabatan'];

// Lakukan validasi data
if (empty($id_jabatan) || empty($jabatan)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk mengupdate data
$query_update = "UPDATE jabatan SET jabatan = '$jabatan' WHERE id_jabatan = '$id_jabatan'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
