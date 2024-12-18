<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_pindah = $_POST['id_pindah'];
$id_penduduk = $_POST['id_penduduk'];
$alamat_asal = $_POST['alamat_asal'];
$alamat_tujuan = $_POST['alamat_tujuan'];
$alasan = $_POST['alasan'];
$tgl_pindah = $_POST['tgl_pindah'];

// Update data penduduk
$query_update = "UPDATE penduduk_pindah 
                 SET id_penduduk = '$id_penduduk', alasan = '$alasan', alamat_asal = '$alamat_asal', alamat_tujuan = '$alamat_tujuan', tgl_pindah = '$tgl_pindah' 
                 WHERE id_pindah = '$id_pindah'";

// Jalankan query update
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
