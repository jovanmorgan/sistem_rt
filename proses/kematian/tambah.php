<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_penduduk = $_POST['id_penduduk'];
$tpt_kematian = $_POST['tpt_kematian'];
$tgl_kematian = $_POST['tgl_kematian'];
$tpt_kubur = $_POST['tpt_kubur'];
$tgl_kubur = $_POST['tgl_kubur'];

// Buat query SQL untuk menambahkan data penduduk ke dalam database
$query = "INSERT INTO kematian (id_penduduk, tpt_kematian, tgl_kematian, tpt_kubur, tgl_kubur) 
          VALUES ('$id_penduduk', '$tpt_kematian', '$tgl_kematian', '$tpt_kubur', '$tgl_kubur')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
