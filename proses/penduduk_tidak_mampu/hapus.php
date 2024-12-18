<?php
include '../../../../keamanan/koneksi.php';

// Terima ID penduduk_tidak_mampu yang akan dihapus dari formulir HTML
$id_ptm = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_ptm)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data penduduk_tidak_mampu berdasarkan ID
$query_delete_penduduk_tidak_mampu = "DELETE FROM penduduk_tidak_mampu WHERE id_ptm = '$id_ptm'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_penduduk_tidak_mampu)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
