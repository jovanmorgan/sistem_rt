<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_penduduk = $_POST['id_penduduk'];
$alasan = $_POST['alasan'];
$alamat_asal = $_POST['alamat_asal'];
$alamat_tujuan = $_POST['alamat_tujuan'];
$tgl_pindah = $_POST['tgl_pindah'];

// Buat query SQL untuk menambahkan data penduduk ke dalam database
$query = "INSERT INTO penduduk_pindah (id_penduduk, alasan, alamat_asal, alamat_tujuan, tgl_pindah) 
          VALUES ('$id_penduduk', '$alasan', '$alamat_asal', '$alamat_tujuan', '$tgl_pindah')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
