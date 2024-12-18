<?php
include '../../../../keamanan/koneksi.php';

// Terima ID penduduk_pindah yang akan dihapus dari formulir HTML
$id_pindah = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pindah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data penduduk_pindah berdasarkan ID
$query_delete_penduduk_pindah = "DELETE FROM penduduk_pindah WHERE id_pindah = '$id_pindah'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_penduduk_pindah)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
