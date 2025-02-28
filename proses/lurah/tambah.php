<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_lurah = $_POST['nama_lurah'];
$username = $_POST['username'];
$password = $_POST['password'];

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
$check_query_rw = "SELECT * FROM rw WHERE username = '$username'";
$result_rw = mysqli_query($koneksi, $check_query_rw);
if (mysqli_num_rows($result_rw) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika email sudah terdaftar
    exit();
}


if (strlen($password) < 8) {
    echo "error_password_length"; // Kirim respon "error_password_length" jika panjang password kurang dari 8 karakter
    exit();
}

// Tambahkan logika untuk memeriksa password
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
    echo "error_password_strength"; // Kirim respon "error_password_strength" jika password tidak memenuhi syarat
    exit();
}

// Buat query SQL untuk menambahkan data RT ke dalam database
$query = "INSERT INTO lurah (nama_lurah, username, password) 
          VALUES ('$nama_lurah', '$username', '$password')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
