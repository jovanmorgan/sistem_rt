<?php
include '../../../../keamanan/koneksi.php';

// Terima ID kk yang akan dihapus dari formulir HTML
$id_kk = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kk)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data kk berdasarkan ID
$query_delete_kk = "DELETE FROM kk WHERE id_kk = '$id_kk'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_kk)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
