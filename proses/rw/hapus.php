<?php
include '../../../../keamanan/koneksi.php';

// Terima ID rw yang akan dihapus dari formulir HTML
$id_rw = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_rw)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data rw berdasarkan ID
$query_delete_rw = "DELETE FROM rw WHERE id_rw = '$id_rw'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_rw)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
