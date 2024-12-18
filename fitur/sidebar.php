<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Fungsi untuk mendapatkan ikon yang sesuai dengan halaman
function getIconForPage($page)
{
    switch ($page) {
        case 'dashboard':
            return 'fas fa-home';
        case 'penduduk':
            return 'fas fa-users';
        case 'penduduk_masuk':
            return 'fas fa-user-plus';
        case 'penduduk_pindah':
            return 'fas fa-truck-moving';
        case 'penduduk_tidak_mampu':
            return 'fas fa-hand-holding-heart';
        case 'bantuan':
            return 'fas fa-hands-helping';
        case 'kelahiran':
            return 'fas fa-child';
        case 'kematian':
            return 'fas fa-skull';
        case 'kk':
            return 'fas fa-file-alt';
        case 'rt':
            return 'fas fa-home';
        case 'rw':
            return 'fas fa-building';
        case 'lurah':
            return 'fas fa-user-tie';
        case 'profile':
            return 'fas fa-user';
        case 'log_out':
            return 'fas fa-sign-out-alt';
        default:
            return 'fas fa-file'; // Ikon default jika halaman tidak dikenal
    }
}
?>

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark2">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="orange">
            <a href="dasboard" class="logo">
                <img src="../../assets/img/kantor_desa/logo.png" alt="navbar brand" class="navbar-brand"
                    height="40px" />
                <h5 class="text-white" style="font-size: 15px; margin-left: 10px; margin-top: 5px">SI KEPENDUDUKAN</h5>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner" data-background-color="orange">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                    <a href="dashboard">
                        <i class="<?php echo getIconForPage('dashboard'); ?>"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-id-card"></i>
                    </span>
                    <h4 class="text-section">Sistem Kependudukan</h4>
                </li>
                <li class="nav-item <?php echo ($current_page == 'kk') ? 'active' : ''; ?>">
                    <a href="kk">
                        <i class="<?php echo getIconForPage('kk'); ?>"></i>
                        <p>Kartu Keluarga</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'penduduk') ? 'active' : ''; ?>">
                    <a href="penduduk">
                        <i class="<?php echo getIconForPage('penduduk'); ?>"></i>
                        <p>Penduduk</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-id-card"></i>
                    </span>
                    <h4 class="text-section">Laporan Data</h4>
                </li>
                <li class="nav-item <?php echo ($current_page == 'penduduk_masuk') ? 'active' : ''; ?>">
                    <a href="penduduk_masuk">
                        <i class="<?php echo getIconForPage('penduduk_masuk'); ?>"></i>
                        <p>Penduduk Masuk</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'penduduk_pindah') ? 'active' : ''; ?>">
                    <a href="penduduk_pindah">
                        <i class="<?php echo getIconForPage('penduduk_pindah'); ?>"></i>
                        <p>Penduduk Pindah</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'penduduk_tidak_mampu') ? 'active' : ''; ?>">
                    <a href="penduduk_tidak_mampu">
                        <i class="<?php echo getIconForPage('penduduk_tidak_mampu'); ?>"></i>
                        <p>Penduduk Tidak Mampu</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'bantuan') ? 'active' : ''; ?>">
                    <a href="bantuan">
                        <i class="<?php echo getIconForPage('bantuan'); ?>"></i>
                        <p>Bantuan</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'kelahiran') ? 'active' : ''; ?>">
                    <a href="kelahiran">
                        <i class="<?php echo getIconForPage('kelahiran'); ?>"></i>
                        <p>Kelahiran</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'kematian') ? 'active' : ''; ?>">
                    <a href="kematian">
                        <i class="<?php echo getIconForPage('kematian'); ?>"></i>
                        <p>Kematian</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Profile</h4>
                </li>
                <li class="nav-item <?php echo ($current_page == 'profile') ? 'active' : ''; ?>">
                    <a href="profile">
                        <i class="<?php echo getIconForPage('profile'); ?>"></i>
                        <p>Profile Saya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="log_out">
                        <i class="<?php echo getIconForPage('log_out'); ?>"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->