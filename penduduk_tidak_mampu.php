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

                        // Query untuk mendapatkan data penduduk_tidak_mampu dengan pencarian dan pagination
                        $query = "
    SELECT ptm.id_ptm, kk.no_kk, kk.nama_kep_kel, 
           GROUP_CONCAT(p.nama SEPARATOR ', ') AS nama_penduduk, 
           ptm.status 
    FROM penduduk_tidak_mampu ptm
    JOIN kk ON ptm.no_kk = kk.no_kk
    JOIN penduduk p ON ptm.no_kk = p.no_kk
    WHERE p.nama LIKE ? 
    GROUP BY ptm.id_ptm, kk.no_kk, kk.nama_kep_kel, ptm.status 
    LIMIT ?, ?";

                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("sii", $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "
    SELECT COUNT(*) as total 
    FROM penduduk_tidak_mampu ptm
    JOIN kk ON ptm.no_kk = kk.no_kk
    JOIN penduduk p ON ptm.no_kk = p.no_kk
    WHERE p.nama LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("s", $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data penduduk_tidak_mampu -->
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
                                                                <th style="white-space: nowrap;">No KK</th>
                                                                <th style="white-space: nowrap;">Nama Kepala Keluarga</th>
                                                                <th style="white-space: nowrap;">Nama Angota</th>
                                                                <th style="white-space: nowrap;">Status</th>
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
                                                                    <td><?php echo htmlspecialchars($row['no_kk']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nama_kep_kel']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['nama_penduduk']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm m-1"
                                                                            onclick="openEditModal('<?php echo $row['id_ptm']; ?>', '<?php echo addslashes($row['no_kk']); ?>', '<?php echo addslashes($row['status']); ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm m-1"
                                                                            onclick="hapus('<?php echo $row['id_ptm']; ?>')">Hapus</button>
                                                                        <form action="export/penduduk_tidak_mampu" method="GET"
                                                                            style="display: inline-block;">
                                                                            <input type="hidden" name="id_ptm"
                                                                                value="<?php echo $row['id_ptm']; ?>">
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
                                    <label for="no_kk" class="form-label">Kartu Keluarga</label>
                                    <select id="no_kk" name="no_kk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Kartu Keluarga</option>
                                        <?php
                                        $query_kk = "SELECT no_kk, nama_kep_kel FROM kk";
                                        $result_kk = mysqli_query($koneksi, $query_kk);
                                        while ($row_kk = mysqli_fetch_assoc($result_kk)) {
                                            echo '<option value="' . $row_kk['no_kk'] . '">' . $row_kk['nama_kep_kel'] . ' (' . $row_kk['no_kk'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- bagian status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Disetujui">Setujui</option>
                                        <option value="Tidak Disetujui">Tidak Setujui</option>
                                    </select>
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
                                <input type="hidden" id="edit_id" name="id_ptm">

                                <div class="mb-3">
                                    <label for="edit_no_kk" class="form-label">Kartu Keluarga</label>
                                    <select id="edit_no_kk" name="no_kk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Kartu Keluarga</option>
                                        <?php
                                        $query_kk = "SELECT no_kk, nama_kep_kel FROM kk";
                                        $result_kk = mysqli_query($koneksi, $query_kk);
                                        while ($row_kk = mysqli_fetch_assoc($result_kk)) {
                                            echo '<option value="' . $row_kk['no_kk'] . '">' . $row_kk['nama_kep_kel'] . ' (' . $row_kk['no_kk'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- bagian status -->
                                <div class="mb-3">
                                    <label for="edit_status" class="form-label">Status</label>
                                    <select id="edit_status" name="status" class="form-select" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Disetujui">Setujui</option>
                                        <option value="Tidak Disetujui">Tidak Setujui</option>
                                    </select>
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
        function openEditModal(id_ptm, no_kk, status) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id_ptm;
            document.getElementById('edit_no_kk').value = no_kk;
            document.getElementById('edit_status').value = status;
            editModal.show();
        }
    </script>

    <?php include 'fitur/js.php'; ?>
</body>

</html>