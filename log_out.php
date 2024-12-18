<?php
session_start();

// Hapus sesi id_rt jika ada
if (isset($_SESSION['id_rt'])) {
    unset($_SESSION['id_rt']);
}

// Redirect pengguna kembali ke halaman login
header("Location: ../../berlangganan/login");
exit;
