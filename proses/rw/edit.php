<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_rw = $_POST['id_rw']; // Pastikan 'id_rw' sudah dikirim melalui form
$nik = $_POST['nik'];
$nama_rw = $_POST['nama_rw'];
$username = $_POST['username'];
$password = $_POST['password'];
$alamat = $_POST['alamat'];

// Lakukan validasi data
if (empty($nik) || empty($username) || empty($password) || empty($nama_rw) || empty($alamat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Validasi nik harus 16 digit
if (strlen($nik) !== 16) {
    echo "nik_harus_16"; // Beri tahu jika nik tidak valid
    exit();
}


// Cek apakah nik sudah ada
$query_check = "SELECT * FROM rw WHERE nik = '$nik' AND id_rw != '$id_rw'";
$result_check = mysqli_query($koneksi, $query_check);
if (mysqli_num_rows($result_check) > 0) {
    echo "nik_sudah_ada"; // Beri tahu jika nik sudah ada
    exit();
}

// Cek apakah username sudah ada di database
$check_query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah username sudah ada di database
$check_query_lurah = "SELECT * FROM lurah WHERE username = '$username'";
$result_lurah = mysqli_query($koneksi, $check_query_lurah);
if (mysqli_num_rows($result_lurah) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}

// Cek apakah username sudah ada di database
$check_query_rt = "SELECT * FROM rt WHERE username = '$username'";
$result_rt = mysqli_query($koneksi, $check_query_rt);
if (mysqli_num_rows($result_rt) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}
// Cek apakah username sudah ada di database
$check_query_rw = "SELECT * FROM rw WHERE username = '$username' AND id_rw != '$id_rw'";
$result_rw = mysqli_query($koneksi, $check_query_rw);
if (mysqli_num_rows($result_rw) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}



if (strlen($password) < 8) {
    echo "error_password_length"; // Kirim respon jika panjang password kurang dari 8 karakter
    exit();
}

// Tambahkan logika untuk memeriksa password
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
    echo "error_password_strength"; // Kirim respon jika password tidak memenuhi syarat
    exit();
}

// Buat query SQL untuk mengedit data rw yang sudah ada berdasarkan id_rw
$query = "UPDATE rw 
            SET nik = '$nik', 
                username = '$username',
                password = '$password'
          WHERE id_rw = '$id_rw'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
