<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Dashboard</h3>
                            <h6 class="op-7 mb-2">Halaman Dasboard</h6>
                        </div>
                    </div>

                    <?php
                    include '../../keamanan/koneksi.php';

                    // Koneksi ke database sudah disiapkan sebelumnya
                    $query_penduduk_masuk = "
    SELECT p.nama, COUNT(pm.id_masuk) as total_status
    FROM penduduk_masuk pm
    JOIN penduduk p ON pm.id_penduduk = p.id_penduduk
    GROUP BY p.nama
    ORDER BY total_status DESC
    LIMIT 7
";

                    $result_penduduk_masuk = mysqli_query($koneksi, $query_penduduk_masuk);

                    // Variabel untuk menyimpan data grafik
                    $penduduk_nama = [];
                    $total_status = [];

                    while ($row_penduduk = mysqli_fetch_assoc($result_penduduk_masuk)) {
                        $penduduk_nama[] = $row_penduduk['nama'];
                        $total_status[] = $row_penduduk['total_status'];
                    }

                    mysqli_free_result($result_penduduk_masuk);


                    $query_penduduk_pindah = "
    SELECT p.nama, pp.id_pindah, p.nik
    FROM penduduk_pindah pp
    INNER JOIN penduduk p ON pp.id_penduduk = p.id_penduduk
    ORDER BY pp.id_pindah DESC
    LIMIT 7
";
                    $result_penduduk_pindah = mysqli_query($koneksi, $query_penduduk_pindah);

                    // Variabel untuk menyimpan data grafik
                    $penduduk_pindah_nama = [];
                    $penduduk_pindah_nik = [];
                    $penduduk_pindah_id = [];

                    while ($row_penduduk_pindah = mysqli_fetch_assoc($result_penduduk_pindah)) {
                        $penduduk_pindah_nama[] = $row_penduduk_pindah['nama'];
                        $penduduk_pindah_nik[] = $row_penduduk_pindah['nik'];
                        $penduduk_pindah_id[] = $row_penduduk_pindah['id_pindah'];
                    }

                    mysqli_free_result($result_penduduk_pindah);

                    $query_penduduk_tidak_mampu = "
    SELECT ptm.id_ptm, kk.nama_kep_kel, ptm.status
    FROM penduduk_tidak_mampu ptm
    INNER JOIN kk ON ptm.no_kk = kk.no_kk
    ORDER BY ptm.status ASC, ptm.id_ptm DESC
    LIMIT 7
";
                    $result_penduduk_tidak_mampu = mysqli_query($koneksi, $query_penduduk_tidak_mampu);

                    // Variabel untuk menyimpan data grafik
                    $nama_kepala_keluarga = [];
                    $status_ptm = [];
                    $id_ptm = [];

                    while ($row_penduduk_tidak_mampu = mysqli_fetch_assoc($result_penduduk_tidak_mampu)) {
                        $nama_kepala_keluarga[] = $row_penduduk_tidak_mampu['nama_kep_kel'];
                        $status_ptm[] = $row_penduduk_tidak_mampu['status'];
                        $id_ptm[] = $row_penduduk_tidak_mampu['id_ptm'];
                    }

                    mysqli_free_result($result_penduduk_tidak_mampu);

                    $query_bantuan = "
    SELECT bantuan.id_bantuan, kk.nama_kep_kel, bantuan.nama_bantuan
    FROM bantuan
    INNER JOIN kk ON bantuan.no_kk = kk.no_kk
    ORDER BY bantuan.id_bantuan DESC
    LIMIT 7
";
                    $result_bantuan = mysqli_query($koneksi, $query_bantuan);

                    // Variabel untuk menyimpan data grafik
                    $nama_kepala_keluarga_bantuan = [];
                    $nama_bantuan = [];
                    $id_bantuan = [];

                    while ($row_bantuan = mysqli_fetch_assoc($result_bantuan)) {
                        $nama_kepala_keluarga_bantuan[] = $row_bantuan['nama_kep_kel'];
                        $nama_bantuan[] = $row_bantuan['nama_bantuan'];
                        $id_bantuan[] = $row_bantuan['id_bantuan'];
                    }

                    mysqli_free_result($result_bantuan);

                    // Koneksi ke database sudah disiapkan sebelumnya
                    $query_kelahiran = "
    SELECT p.nama, p.tgl_lahir, p.jk
    FROM kelahiran k
    JOIN penduduk p ON k.id_penduduk = p.id_penduduk
    ORDER BY p.tgl_lahir ASC
";

                    $result_kelahiran = mysqli_query($koneksi, $query_kelahiran);

                    // Variabel untuk menyimpan data grafik
                    $nama_kelahiran = [];
                    $tgl_lahir_kelahiran = [];
                    $jenis_kelamin_kelahiran = [];

                    while ($row_kelahiran = mysqli_fetch_assoc($result_kelahiran)) {
                        $nama_kelahiran[] = $row_kelahiran['nama'];
                        $tgl_lahir_kelahiran[] = $row_kelahiran['tgl_lahir'];
                        $jenis_kelamin_kelahiran[] = $row_kelahiran['jk'];
                    }

                    mysqli_free_result($result_kelahiran);


                    $query_kematian = "
    SELECT penduduk.nama, kematian.tgl_kematian
    FROM kematian
    INNER JOIN penduduk ON kematian.id_penduduk = penduduk.id_penduduk
    ORDER BY kematian.tgl_kematian ASC
";
                    $result_kematian = mysqli_query($koneksi, $query_kematian);

                    // Variabel untuk menyimpan data grafik
                    $nama_kematian = [];
                    $tgl_kematian = [];

                    while ($row_kematian = mysqli_fetch_assoc($result_kematian)) {
                        $nama_kematian[] = $row_kematian['nama'];
                        $tgl_kematian[] = $row_kematian['tgl_kematian'];
                    }

                    mysqli_free_result($result_kematian);

                    $tables = [
                        'penduduk' => [
                            'label' => 'Penduduk',
                            'icon' => 'fas fa-users', // Ikon untuk kelompok penduduk
                            'color' => '#FFC107' // Yellow
                        ],
                        'penduduk_masuk' => [
                            'label' => 'Penduduk Masuk',
                            'icon' => 'fas fa-user-plus', // Ikon untuk penduduk yang baru masuk
                            'color' => '#DC3545' // Red
                        ],
                        'penduduk_pindah' => [
                            'label' => 'Penduduk Pindah',
                            'icon' => 'fas fa-truck-moving', // Ikon untuk penduduk yang pindah
                            'color' => '#0D6EFD' // Blue
                        ],
                        'penduduk_tidak_mampu' => [
                            'label' => 'Penduduk Tidak Mampu',
                            'icon' => 'fas fa-hand-holding-heart', // Ikon yang melambangkan bantuan atau status tidak mampu
                            'color' => '#28A745' // Green
                        ],
                        'bantuan' => [
                            'label' => 'Bantuan',
                            'icon' => 'fas fa-hands-helping', // Ikon yang menunjukkan bantuan
                            'color' => '#198754' // Green
                        ],
                        'kelahiran' => [
                            'label' => 'Kelahiran',
                            'icon' => 'fas fa-child', // Ikon untuk kelahiran bayi
                            'color' => '#17A2B8' // Teal
                        ],
                        'kematian' => [
                            'label' => 'Kematian',
                            'icon' => 'fas fa-skull', // Ikon yang sesuai untuk kematian
                            'color' => '#6C757D' // Gray
                        ],
                        'kk' => [
                            'label' => 'Kartu Keluarga',
                            'icon' => 'fas fa-file-alt', // Ikon untuk dokumen kartu keluarga
                            'color' => '#38df5f' // Gray
                        ],
                        'rt' => [
                            'label' => 'Rukun Tetangga',
                            'icon' => 'fas fa-home', // Ikon yang mewakili lingkungan RT
                            'color' => '#5390ed' // Gray
                        ],
                        'rw' => [
                            'label' => 'Rukun Warga',
                            'icon' => 'fas fa-building', // Ikon untuk lingkungan RW
                            'color' => '#c622d8' // Gray
                        ],
                        'lurah' => [
                            'label' => 'Lurah',
                            'icon' => 'fas fa-user-tie', // Ikon untuk pemimpin wilayah seperti lurah
                            'color' => '#ffaa0c' // Gray
                        ]
                    ];

                    $counts = [];

                    foreach ($tables as $table => $details) {
                        $query = "SELECT COUNT(*) as count FROM $table";
                        $result = mysqli_query($koneksi, $query);
                        $row = mysqli_fetch_assoc($result);
                        $counts[$table] = $row['count'];
                        mysqli_free_result($result);
                    }

                    mysqli_close($koneksi);
                    ?>
                    <?php include 'fitur/nama_halaman.php'; ?>

                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title" style="font-size: 30px;">Selamat Datang</h5>
                                        <p>
                                            Silakan lihat informsi yang kami sajikan pada website ini, Berikut adalah
                                            informasi data pada Halaman
                                            <?= $page_title ?>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section">
                        <div class="row">

                            <div class="row">
                                <?php foreach ($tables as $table => $details): ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="card card-stats card-round">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-icon">
                                                        <div class="icon-big text-center icon-secondary bubble-shadow-small"
                                                            style="background-color: <?= $details['color']; ?>;">
                                                            <i class="<?= $details['icon']; ?>"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col col-stats ms-3 ms-sm-0">
                                                        <div class="numbers">
                                                            <p class="card-category"><?= $details['label']; ?></p>
                                                            <h4 class="card-title"><?= $counts[$table]; ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Grafik Penduduk Masuk -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Diagram Penduduk Masuk Berdasarkan Status
                                        </h5>
                                        <!-- Pie Chart -->
                                        <canvas id="pendudukPieChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#pendudukPieChart"), {
                                                    type: "pie", // Ubah menjadi 'pie'
                                                    data: {
                                                        labels: <?= json_encode($penduduk_nama); ?>, // Nama-nama penduduk
                                                        datasets: [{
                                                            label: "Total Status",
                                                            data: <?= json_encode($total_status); ?>, // Total status berdasarkan nama penduduk
                                                            backgroundColor: [
                                                                "rgba(255, 99, 132, 0.2)",
                                                                "rgba(255, 159, 64, 0.2)",
                                                                "rgba(255, 205, 86, 0.2)",
                                                                "rgba(75, 192, 192, 0.2)",
                                                                "rgba(54, 162, 235, 0.2)",
                                                                "rgba(153, 102, 255, 0.2)",
                                                                "rgba(201, 203, 207, 0.2)",
                                                            ],
                                                            borderColor: [
                                                                "rgb(255, 99, 132)",
                                                                "rgb(255, 159, 64)",
                                                                "rgb(255, 205, 86)",
                                                                "rgb(75, 192, 192)",
                                                                "rgb(54, 162, 235)",
                                                                "rgb(153, 102, 255)",
                                                                "rgb(201, 203, 207)",
                                                            ],
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        responsive: true, // Agar grafik responsif
                                                    },
                                                });
                                            });
                                        </script>
                                        <!-- End Pie Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik Penduduk Pindah -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Diagram Penduduk Pindah</h5>
                                        <!-- Pie Chart -->
                                        <canvas id="pendudukPindahPieChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#pendudukPindahPieChart"), {
                                                    type: "pie", // Ubah menjadi 'pie'
                                                    data: {
                                                        labels: <?= json_encode($penduduk_pindah_nama); ?>, // Nama-nama penduduk yang pindah
                                                        datasets: [{
                                                            label: "NIK Penduduk",
                                                            data: <?= json_encode($penduduk_pindah_nik); ?>, // NIK Penduduk
                                                            backgroundColor: [
                                                                "rgba(75, 192, 192, 0.2)",
                                                                "rgba(54, 162, 235, 0.2)",
                                                                "rgba(153, 102, 255, 0.2)",
                                                                "rgba(255, 99, 132, 0.2)",
                                                                "rgba(255, 159, 64, 0.2)",
                                                                "rgba(255, 205, 86, 0.2)",
                                                                "rgba(201, 203, 207, 0.2)",
                                                            ],
                                                            borderColor: [
                                                                "rgb(75, 192, 192)",
                                                                "rgb(54, 162, 235)",
                                                                "rgb(153, 102, 255)",
                                                                "rgb(255, 99, 132)",
                                                                "rgb(255, 159, 64)",
                                                                "rgb(255, 205, 86)",
                                                                "rgb(201, 203, 207)",
                                                            ],
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        responsive: true, // Agar grafik responsif
                                                    },
                                                });
                                            });
                                        </script>
                                        <!-- End Pie Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik Penduduk Tidak Mampu -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Status Penduduk Tidak Mampu</h5>
                                        <!-- Bar Chart -->
                                        <canvas id="pendudukTidakMampuBarChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#pendudukTidakMampuBarChart"), {
                                                    type: "bar",
                                                    data: {
                                                        labels: <?= json_encode($nama_kepala_keluarga); ?>, // Nama kepala keluarga
                                                        datasets: [{
                                                            label: "Status Penduduk Tidak Mampu",
                                                            data: <?= json_encode($status_ptm); ?>, // Status PTM (disetujui atau belum)
                                                            backgroundColor: function(context) {
                                                                // Warna batang berdasarkan status
                                                                let status = context.raw;
                                                                return status === 'Disetujui' ?
                                                                    'rgba(75, 192, 192, 0.2)' :
                                                                    'rgba(255, 99, 132, 0.2)';
                                                            },
                                                            borderColor: function(context) {
                                                                let status = context.raw;
                                                                return status === 'Disetujui' ?
                                                                    'rgb(75, 192, 192)' :
                                                                    'rgb(255, 99, 132)';
                                                            },
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                            },
                                                        },
                                                    },
                                                });
                                            });
                                        </script>
                                        <!-- End Bar Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik Bantuan -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Jenis Bantuan untuk Penduduk</h5>
                                        <!-- Bar Chart -->
                                        <canvas id="bantuanBarChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#bantuanBarChart"), {
                                                    type: "bar",
                                                    data: {
                                                        labels: <?= json_encode($nama_kepala_keluarga_bantuan); ?>, // Nama kepala keluarga
                                                        datasets: [{
                                                            label: "Nama Bantuan",
                                                            data: <?= json_encode($nama_bantuan); ?>, // Nama bantuan
                                                            backgroundColor: [
                                                                "rgba(54, 162, 235, 0.2)",
                                                                "rgba(255, 159, 64, 0.2)",
                                                                "rgba(75, 192, 192, 0.2)",
                                                                "rgba(153, 102, 255, 0.2)",
                                                                "rgba(255, 205, 86, 0.2)",
                                                                "rgba(201, 203, 207, 0.2)",
                                                                "rgba(255, 99, 132, 0.2)",
                                                            ],
                                                            borderColor: [
                                                                "rgb(54, 162, 235)",
                                                                "rgb(255, 159, 64)",
                                                                "rgb(75, 192, 192)",
                                                                "rgb(153, 102, 255)",
                                                                "rgb(255, 205, 86)",
                                                                "rgb(201, 203, 207)",
                                                                "rgb(255, 99, 132)",
                                                            ],
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                            },
                                                        },
                                                    },
                                                });
                                            });
                                        </script>
                                        <!-- End Bar Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik Kelahiran Berdasarkan Tanggal Lahir -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Kelahiran Berdasarkan Tanggal Lahir</h5>
                                        <!-- Bar Chart -->
                                        <canvas id="kelahiranBarChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#kelahiranBarChart"), {
                                                    type: "line", // Bisa diubah ke 'bar' untuk grafik batang
                                                    data: {
                                                        labels: <?= json_encode($tgl_lahir_kelahiran); ?>, // Tanggal lahir sebagai sumbu-x
                                                        datasets: [{
                                                            label: "Jumlah Kelahiran",
                                                            data: <?= json_encode($nama_kelahiran); ?>, // Nama kelahiran di sumbu-y
                                                            backgroundColor: "rgba(75, 192, 192, 0.2)",
                                                            borderColor: "rgba(75, 192, 192, 1)",
                                                            borderWidth: 1,
                                                            fill: false, // Untuk grafik garis, jangan diisi
                                                            tension: 0.1 // Tambahkan sedikit kelengkungan pada grafik garis
                                                        }],
                                                    },
                                                    options: {
                                                        scales: {
                                                            x: {
                                                                type: "time", // Mengatur sumbu x menjadi tipe waktu
                                                                time: {
                                                                    unit: "day" // Unit waktu bisa harian, bulanan, dll.
                                                                },
                                                                title: {
                                                                    display: true,
                                                                    text: "Tanggal Lahir"
                                                                }
                                                            },
                                                            y: {
                                                                beginAtZero: true,
                                                                title: {
                                                                    display: true,
                                                                    text: "Jumlah Kelahiran"
                                                                }
                                                            }
                                                        },
                                                        plugins: {
                                                            legend: {
                                                                display: true,
                                                                position: 'top'
                                                            }
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- End Bar Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik Kematian Berdasarkan Tanggal Kematian -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Kematian Berdasarkan Tanggal Kematian</h5>
                                        <!-- Bar Chart -->
                                        <canvas id="kematianChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#kematianChart"), {
                                                    type: "bar", // Bisa diubah ke 'line' untuk grafik garis
                                                    data: {
                                                        labels: <?= json_encode($tgl_kematian); ?>, // Tanggal kematian sebagai sumbu-x
                                                        datasets: [{
                                                            label: "Jumlah Kematian",
                                                            data: <?= json_encode($nama_kematian); ?>, // Nama-nama penduduk di sumbu-y
                                                            backgroundColor: "rgba(255, 99, 132, 0.2)",
                                                            borderColor: "rgba(255, 99, 132, 1)",
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        scales: {
                                                            x: {
                                                                type: "time", // Mengatur sumbu-x menjadi tipe waktu
                                                                time: {
                                                                    unit: "day" // Unit waktu harian
                                                                },
                                                                title: {
                                                                    display: true,
                                                                    text: "Tanggal Kematian"
                                                                }
                                                            },
                                                            y: {
                                                                beginAtZero: true,
                                                                title: {
                                                                    display: true,
                                                                    text: "Jumlah Kematian"
                                                                }
                                                            }
                                                        },
                                                        plugins: {
                                                            legend: {
                                                                display: true,
                                                                position: 'top'
                                                            }
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- End Bar Chart -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                </div>
            </div>

            <?php include 'fitur/footer.php'; ?>
        </div>

    </div>
    <?php include 'fitur/js.php'; ?>
</body>

</html>