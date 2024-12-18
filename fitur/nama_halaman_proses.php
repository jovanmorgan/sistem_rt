<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page_proses = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page_proses) {
    case 'dashboard':
        $page_title_proses = 'dashboard';
        break;
    case 'bantuan':
        $page_title_proses = 'bantuan';
        break;
    case 'kelahiran':
        $page_title_proses = 'kelahiran';
        break;
    case 'kematian':
        $page_title_proses = 'kematian';
        break;
    case 'kk':
        $page_title_proses = 'kk';
        break;
    case 'lurah':
        $page_title_proses = 'lurah';
        break;
    case 'penduduk_masuk':
        $page_title_proses = 'penduduk_masuk';
        break;
    case 'penduduk_pindah':
        $page_title_proses = 'penduduk_pindah';
        break;
    case 'penduduk':
        $page_title_proses = 'penduduk';
        break;
    case 'penduduk_tidak_mampu':
        $page_title_proses = 'penduduk_tidak_mampu';
        break;
    case 'rt':
        $page_title_proses = 'rt';
        break;
    case 'rw':
        $page_title_proses = 'rw';
        break;
    case 'log_out':
        $page_title_proses = 'Log Out';
        break;
    default:
        $page_title_proses_proses = 'Admin SMK 4 Atambua';
        break;
}
