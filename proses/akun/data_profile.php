<?php
// Lakukan koneksi ke database
include '../../../../keamanan/koneksi.php';

// Cek apakah terdapat data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $id_rt = $_POST['id_rt'];
    $nama_rt = $_POST['nama_rt'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // Lakukan validasi data
    if (empty($nama_rt) || empty($password)) {
        echo "data tidak lengkap";
        exit();
    }
    // Cek apakah username sudah ada di database
    $check_query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($koneksi, $check_query);
    if (mysqli_num_rows($result) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }
    // Cek apakah username sudah ada di database
    $check_query_rt = "SELECT * FROM rt WHERE username = '$username' AND id_rt != '$id_rt'";
    $result_rt = mysqli_query($koneksi, $check_query_rt);
    if (mysqli_num_rows($result_rt) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }
    // Cek apakah username sudah ada di database
    $check_query_rw = "SELECT * FROM rw WHERE username = '$username'";
    $result_rw = mysqli_query($koneksi, $check_query_rw);
    if (mysqli_num_rows($result_rw) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }
    // Cek apakah username sudah ada di database
    $check_query_lurah = "SELECT * FROM lurah WHERE username = '$username'";
    $result_lurah = mysqli_query($koneksi, $check_query_lurah);
    if (mysqli_num_rows($result_lurah) > 0) {
        echo "error_username_exists"; // Kirim respon "error_username_exists" jika email sudah terdaftar
        exit();
    }
    // Query SQL untuk update data foto profile
    $query = "UPDATE rt SET password='$password', nama_rt='$nama_rt', username='$username' WHERE id_rt='$id_rt'";

    // Lakukan proses update data foto profile di database
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "success";
        exit();
    } else {
        // Jika terjadi kesalahan saat melakukan proses update, tampilkan pesan kesalahan
        echo "Gagal melakukan proses update data foto profile: " . mysqli_error($koneksi);
    }
} else {
    // Jika metode request bukan POST, berikan respons yang sesuai
    echo "Invalid request method";
    exit();
}

// Tutup koneksi ke database
mysqli_close($koneksi);
