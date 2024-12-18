<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_penduduk = $_POST['id_penduduk'];
$nama_ayah = $_POST['nama_ayah'];
$nama_ibu = $_POST['nama_ibu'];

// Buat query SQL untuk menambahkan data penduduk ke dalam database
$query = "INSERT INTO kelahiran (id_penduduk, nama_ayah, nama_ibu) 
          VALUES ('$id_penduduk', '$nama_ayah', '$nama_ibu')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
