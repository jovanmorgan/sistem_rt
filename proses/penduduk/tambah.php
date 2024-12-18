<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
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

// Cek apakah nik sudah ada
$query_check = "SELECT * FROM penduduk WHERE nik = '$nik'";
$result_check = mysqli_query($koneksi, $query_check);
if (mysqli_num_rows($result_check) > 0) {
    echo "nik_sudah_ada"; // Beri tahu jika nik sudah ada
    exit();
}

// Cek apakah nik sudah ada di database
$check_query_rt = "SELECT * FROM rt WHERE nik = '$nik'";
$result_rt = mysqli_query($koneksi, $check_query_rt);
if (mysqli_num_rows($result_rt) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah nik sudah ada di database
$check_query_rw = "SELECT * FROM rw WHERE nik = '$nik'";
$result_rw = mysqli_query($koneksi, $check_query_rw);
if (mysqli_num_rows($result_rw) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

// Buat query SQL untuk menambahkan data penduduk ke dalam database
$query = "INSERT INTO penduduk (no_kk, nik, nama, tpt_lahir, tgl_lahir, jk, alamat, id_rt, id_rw, kel_des, kec, kewarganegaraan, agama, stts_perkawinan, pendidikan, pekerjaan, status) 
          VALUES ('$no_kk', '$nik', '$nama', '$tpt_lahir', '$tgl_lahir', '$jk', '$alamat', '$id_rt', '$id_rw', '$kel_des', '$kec', '$kewarganegaraan', '$agama', '$stts_perkawinan', '$pendidikan', '$pekerjaan', '$status')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
