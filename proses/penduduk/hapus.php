<?php
include '../../../../keamanan/koneksi.php';

// Terima ID rt yang akan dihapus dari formulir HTML
$id_rt = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_rt)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data rt berdasarkan ID
$query_delete_rt = "DELETE FROM rt WHERE id_rt = '$id_rt'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_rt)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
