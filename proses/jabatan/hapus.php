<?php
include '../../../../keamanan/koneksi.php';

// Terima ID jabatan yang akan dihapus dari formulir HTML
$id_jabatan = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_jabatan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data jabatan berdasarkan ID
$query_delete_jabatan = "DELETE FROM jabatan WHERE id_jabatan = '$id_jabatan'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_jabatan)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
