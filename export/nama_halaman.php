<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page) {
    case 'dashboard':
        $page_title = 'Dashboard';
        break;
    case 'bantuan':
        $page_title = 'Bantuan';
        break;
    case 'kelahiran':
        $page_title = 'Kelahiran';
        break;
    case 'kematian':
        $page_title = 'Kematian';
        break;
    case 'kk':
        $page_title = 'Kartu Keluarga';
        break;
    case 'lurah':
        $page_title = 'Lurah';
        break;
    case 'penduduk_masuk':
        $page_title = 'Penduduk Masuk';
        break;
    case 'penduduk_pindah':
        $page_title = 'Penduduk Pindah';
        break;
    case 'penduduk':
        $page_title = 'Penduduk';
        break;
    case 'penduduk_tidak_mampu':
        $page_title = 'Penduduk Tidak Mampu';
        break;
    case 'rt':
        $page_title = 'Rukun Tetangga';
        break;
    case 'rw':
        $page_title = 'Rukun Warga';
        break;
    case 'log_out':
        $page_title = 'Log Out';
        break;
    default:
        $page_title = 'Admin Sistem Kependudukan';
        break;
}
