<?php
include '../../../../keamanan/koneksi.php';

// Terima ID penduduk_masuk yang akan dihapus dari formulir HTML
$id_masuk = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_masuk)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data penduduk_masuk berdasarkan ID
$query_delete_penduduk_masuk = "DELETE FROM penduduk_masuk WHERE id_masuk = '$id_masuk'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_penduduk_masuk)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
