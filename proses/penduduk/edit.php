<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_penduduk = $_POST['id_penduduk']; // ID Penduduk yang diedit
$no_kk = $_POST['no_kk'];
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$tpt_lahir = $_POST['tpt_lahir'];
$tgl_lahir = $_POST['tgl_lahir'];
$jk = $_POST['jk'];
$alamat = $_POST['alamat'];
$id_rt = $_POST['id_rt'];
$id_rw = $_POST['id_rw'];
$kel_des = $_POST['kel_des'];
$kec = $_POST['kec'];
$kewarganegaraan = $_POST['kewarganegaraan'];
$agama = $_POST['agama'];
$stts_perkawinan = $_POST['stts_perkawinan'];
$pendidikan = $_POST['pendidikan'];
$pekerjaan = $_POST['pekerjaan'];
$status = $_POST['status'];

// Validasi nik harus 16 digit
if (strlen($nik) !== 16) {
    echo "nik_harus_16"; // Beri tahu jika nik tidak valid
    exit();
}

// Cek apakah nik sudah ada di database lain, kecuali untuk penduduk yang sedang diedit
$query_check = "SELECT * FROM penduduk WHERE nik = '$nik' AND id_penduduk != '$id_penduduk'";
$result_check = mysqli_query($koneksi, $query_check);
if (mysqli_num_rows($result_check) > 0) {
    echo "nik_sudah_ada"; // Beri tahu jika NIK sudah ada pada penduduk lain
    exit();
}

// Update data penduduk
$query_update = "UPDATE penduduk 
                 SET no_kk = '$no_kk', nik = '$nik', nama = '$nama', tpt_lahir = '$tpt_lahir', tgl_lahir = '$tgl_lahir', jk = '$jk', alamat = '$alamat', id_rt = '$id_rt', id_rw = '$id_rw', kel_des = '$kel_des', kec = '$kec', kewarganegaraan = '$kewarganegaraan', agama = '$agama', stts_perkawinan = '$stts_perkawinan', pendidikan = '$pendidikan', pekerjaan = '$pekerjaan', status = '$status' 
                 WHERE id_penduduk = '$id_penduduk'";

// Jalankan query update
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
