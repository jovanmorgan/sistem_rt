<?php
include '../../../../keamanan/koneksi.php';

// Terima ID kelahiran yang akan dihapus dari formulir HTML
$id_kelahiran = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kelahiran)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data kelahiran berdasarkan ID
$query_delete_kelahiran = "DELETE FROM kelahiran WHERE id_kelahiran = '$id_kelahiran'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_kelahiran)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
