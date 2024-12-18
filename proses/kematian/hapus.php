<?php
include '../../../../keamanan/koneksi.php';

// Terima ID kematian yang akan dihapus dari formulir HTML
$id_kematian = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kematian)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data kematian berdasarkan ID
$query_delete_kematian = "DELETE FROM kematian WHERE id_kematian = '$id_kematian'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_kematian)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
