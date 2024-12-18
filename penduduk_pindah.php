<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>
<?php include 'fitur/nama_halaman.php'; ?>
<?php include 'fitur/nama_halaman_proses.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <?php include 'fitur/papan_halaman.php'; ?>

                    <div id="load_data">
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <!-- Search Form -->
                                            <form method="GET" action="">
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari kk atau nomor rekening..." name="search"
                                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                                    <button class="btn btn-outline-secondary"
                                                        type="submit">Cari</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <?php
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mendapatkan data penduduk_pindah dengan pencarian dan pagination
                        $query = "SELECT pp.id_pindah, p.no_kk, p.nik, p.nama, p.tpt_lahir, p.tgl_lahir, p.jk, p.alamat, p.id_rt, p.agama, pp.id_penduduk,
                 rt.nama_rt, p.id_rw, rw.nama_rw, p.pendidikan, p.pekerjaan, p.status, pp.alasan, pp.tgl_pindah, pp.alamat_asal, pp.alamat_tujuan
          FROM penduduk_pindah pp
          JOIN penduduk p ON pp.id_penduduk = p.id_penduduk
          LEFT JOIN rt ON p.id_rt = rt.id_rt
          LEFT JOIN rw ON p.id_rw = rw.id_rw
          WHERE p.nama LIKE ? LIMIT ?, ?";

                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("sii", $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "SELECT COUNT(*) as total FROM penduduk_pindah pp
                JOIN penduduk p ON pp.id_penduduk = p.id_penduduk
                WHERE p.nama LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("s", $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data penduduk_pindah -->
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body" style="overflow-x: hidden;">
                                            <div style="overflow-x: auto;">
                                                <?php if ($result->num_rows > 0): ?>
                                                    <table class="table table-hover text-center mt-3"
                                                        style="border-collapse: separate; border-spacing: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="white-space: nowrap;">Nomor</th>
                                                                <th style="white-space: nowrap;">NIK</th>
                                                                <th style="white-space: nowrap;">Nama</th>
                                                                <th style="white-space: nowrap;">Tempat Lahir</th>
                                                                <th style="white-space: nowrap;">Tanggal Lahir</th>
                                                                <th style="white-space: nowrap;">Jenis Kelamin</th>
                                                                <th style="white-space: nowrap;">Status</th>
                                                                <th style="white-space: nowrap;">Pekerjaan</th>
                                                                <th style="white-space: nowrap;">Agama</th>
                                                                <th style="white-space: nowrap;">Alamat Asal</th>
                                                                <th style="white-space: nowrap;">Alamat Tujuan</th>
                                                                <th style="white-space: nowrap;">Alasan</th>
                                                                <th style="white-space: nowrap;">Tanggal Pindah</th>
                                                                <th style="white-space: nowrap;">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                                            while ($row = $result->fetch_assoc()) :
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $nomor++; ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nik']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['tpt_lahir']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['tgl_lahir']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['jk']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['pekerjaan']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['agama']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['alamat_asal']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['alamat_tujuan']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['alasan']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['tgl_pindah']); ?>
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm m-1"
                                                                            onclick="openEditModal('<?php echo $row['id_pindah']; ?>', '<?php echo $row['id_penduduk']; ?>', '<?php echo addslashes($row['alasan']); ?>', '<?php echo $row['alamat_asal']; ?>', '<?php echo $row['alamat_tujuan']; ?>', '<?php echo $row['tgl_pindah']; ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm m-1"
                                                                            onclick="hapus('<?php echo $row['id_pindah']; ?>')">Hapus</button>
                                                                        <!-- Form untuk kirim ke halaman data_pdf1 -->
                                                                        <form action="export/penduduk_pindah" method="GET"
                                                                            style="display: inline-block;">
                                                                            <input type="hidden" name="id_pindah"
                                                                                value="<?php echo $row['id_pindah']; ?>">
                                                                            <button type="submit"
                                                                                class="btn btn-primary btn-sm m-1">Cetak
                                                                                PDF</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <p class="text-center mt-4">Data tidak ditemukan.</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Pagination Section -->
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <!-- Pagination with icons -->
                                            <nav aria-label="Pagxample" style="margin-top: 2.2rem;">
                                                <ul class="pagination justify-content-center">
                                                    <li class="page-item <?php if ($page <= 1) {
                                                                                echo 'disabled';
                                                                            } ?>">
                                                        <a class="page-link" href="<?php if ($page > 1) {
                                                                                        echo "?page=" . ($page - 1) . "&search=" . $search;
                                                                                    } ?>" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                                        <li class="page-item <?php if ($i == $page) {
                                                                                    echo 'active';
                                                                                } ?>">
                                                            <a class="page-link"
                                                                href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                    <li class="page-item <?php if ($page >= $total_pages) {
                                                                                echo 'disabled';
                                                                            } ?>">
                                                        <a class="page-link" href="<?php if ($page < $total_pages) {
                                                                                        echo "?page=" . ($page + 1) . "&search=" . $search;
                                                                                    } ?>" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            <!-- End Pagination with icons -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahForm" method="POST" action="proses/<?= $page_title_proses ?>/tambah.php"
                                enctype="multipalurah/form-data">

                                <div class="mb-3">
                                    <label for="id_penduduk" class="form-label">Data Penduduk</label>
                                    <select id="id_penduduk" name="id_penduduk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Data Penduduk</option>
                                        <?php
                                        $query_penduduk = "SELECT id_penduduk, nik, nama FROM penduduk";
                                        $result_penduduk = mysqli_query($koneksi, $query_penduduk);
                                        while ($row_penduduk = mysqli_fetch_assoc($result_penduduk)) {
                                            echo '<option value="' . $row_penduduk['id_penduduk'] . '">' . $row_penduduk['nama'] . ' (NIK : ' . $row_penduduk['nik'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="alasan" class="form-label">Alasan</label>
                                    <textarea id="alasan" name="alasan" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat_asal" class="form-label">Alamat Asal</label>
                                    <textarea id="alamat_asal" name="alamat_asal" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat_tujuan" class="form-label">Alamat Tujuan</label>
                                    <textarea id="alamat_tujuan" name="alamat_tujuan" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <!-- Tanggal Masuk -->
                                <div class="mb-3">
                                    <label for="tgl_pindah" class="form-label">Tanggal Masuk</label>
                                    <input type="date" id="tgl_pindah" name="tgl_pindah" class="form-control" required>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="proses/<?= $page_title_proses ?>/edit.php"
                                enctype="multipalurah/form-data">
                                <!-- Hidden ID Masuk -->
                                <input type="hidden" id="edit_id" name="id_pindah">

                                <div class="mb-3">
                                    <label for="edit_id_penduduk" class="form-label">Kartu Keluarga</label>
                                    <select id="edit_id_penduduk" name="id_penduduk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Kartu Keluarga</option>
                                        <?php
                                        $query_penduduk = "SELECT id_penduduk, nik, nama FROM penduduk";
                                        $result_penduduk = mysqli_query($koneksi, $query_penduduk);
                                        while ($row_penduduk = mysqli_fetch_assoc($result_penduduk)) {
                                            echo '<option value="' . $row_penduduk['id_penduduk'] . '">' . $row_penduduk['nama'] . ' (NIK : ' . $row_penduduk['nik'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Alasan -->
                                <div class="mb-3">
                                    <label for="edit_alasan" class="form-label">Alasan</label>
                                    <textarea id="edit_alasan" name="alasan" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_alamat_asal" class="form-label">Alamat Asal</label>
                                    <textarea id="edit_alamat_asal" name="alamat_asal" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_alamat_tujuan" class="form-label">Alamat Tujuan</label>
                                    <textarea id="edit_alamat_tujuan" name="alamat_tujuan" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <!-- Tanggal Masuk -->
                                <div class="mb-3">
                                    <label for="edit_tgl_pindah" class="form-label">Tanggal Masuk</label>
                                    <input type="date" id="edit_tgl_pindah" name="tgl_pindah" class="form-control"
                                        required>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>

    <script>
        function openEditModal(id_pindah, id_penduduk, alasan, alamat_asal, alamat_tujuan, tgl_pindah) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id_pindah;
            document.getElementById('edit_id_penduduk').value = id_penduduk;
            document.getElementById('edit_alasan').value = alasan;
            document.getElementById('edit_alamat_asal').value = alamat_asal;
            document.getElementById('edit_alamat_tujuan').value = alamat_tujuan;
            document.getElementById('edit_tgl_pindah').value = tgl_pindah;
            editModal.show();
        }
    </script>

    <?php include 'fitur/js.php'; ?>
</body>

</html>