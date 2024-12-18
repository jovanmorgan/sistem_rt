<?php
include '../../../../keamanan/koneksi.php';

// Terima ID bantuan yang akan dihapus dari formulir HTML
$id_bantuan = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_bantuan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data bantuan berdasarkan ID
$query_delete_bantuan = "DELETE FROM bantuan WHERE id_bantuan = '$id_bantuan'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_bantuan)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
