<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_kematian = $_POST['id_kematian'];
$id_penduduk = $_POST['id_penduduk'];
$tpt_kematian = $_POST['tpt_kematian'];
$tgl_kematian = $_POST['tgl_kematian'];
$tpt_kubur = $_POST['tpt_kubur'];
$tgl_kubur = $_POST['tgl_kubur'];

// Update data penduduk
$query_update = "UPDATE kematian 
                 SET id_penduduk = '$id_penduduk', tpt_kematian = '$tpt_kematian', tgl_kematian = '$tgl_kematian', tpt_kubur = '$tpt_kubur', tgl_kubur = '$tgl_kubur' 
                 WHERE id_kematian = '$id_kematian'";

// Jalankan query update
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
