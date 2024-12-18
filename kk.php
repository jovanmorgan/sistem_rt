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
                        // Ambil data kk dari database
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mendapatkan data kk dengan pencarian dan pagination
                        $query = "
    SELECT kk.*, rt.nama_rt, rw.nama_rw 
    FROM kk 
    LEFT JOIN rt ON kk.id_rt = rt.id_rt 
    LEFT JOIN rw ON kk.id_rw = rw.id_rw 
    WHERE kk.no_kk LIKE ? 
    LIMIT ?, ?
";

                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("sii", $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "
    SELECT COUNT(*) as total 
    FROM kk 
    WHERE no_kk LIKE ?
";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("s", $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data kk -->
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
                                                            <th style="white-space: nowrap;">NO KK</th>
                                                            <th style="white-space: nowrap;">Nama Kepala Keluarga</th>
                                                            <th style="white-space: nowrap;">NIK</th>
                                                            <th style="white-space: nowrap;">Alamat</th>
                                                            <th style="white-space: nowrap;">RT</th>
                                                            <th style="white-space: nowrap;">RW</th>
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
                                                            </td> <!-- Menampilkan nama kepala keluarga -->
                                                            <td><?php echo htmlspecialchars($row['nik']); ?></td>
                                                            <!-- Menampilkan NIK -->
                                                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                                            <!-- Menampilkan alamat -->
                                                            <td><?php echo htmlspecialchars($row['nama_rt']); ?></td>
                                                            <!-- Menampilkan nama RT -->
                                                            <td><?php echo htmlspecialchars($row['nama_rw']); ?></td>
                                                            <!-- Menampilkan nama RW -->
                                                            <td>
                                                                <button class="btn btn-warning btn-sm m-1"
                                                                    onclick="openEditModal('<?php echo $row['id_kk']; ?>', '<?php echo $row['no_kk']; ?>', '<?php echo htmlspecialchars($row['nama_kep_kel']); ?>', '<?php echo htmlspecialchars($row['nik']); ?>', '<?php echo htmlspecialchars($row['alamat']); ?>', '<?php echo $row['id_rt']; ?>', '<?php echo $row['id_rw']; ?>')">Edit</button>
                                                                <button class="btn btn-danger btn-sm m-1"
                                                                    onclick="hapus('<?php echo $row['id_kk']; ?>')">Hapus</button>
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

            <!-- bagian pop up edit dan tambah -->

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
                                enctype="multipart/form-data">
                                <!-- Nomor KK -->
                                <div class="mb-3">
                                    <label for="no_kk" class="form-label">Nomor KK</label>
                                    <input type="text" id="no_kk" maxlength="16"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="no_kk"
                                        class="form-control" required>
                                </div>

                                <!-- Nama Kepala Keluarga -->
                                <div class="mb-3">
                                    <label for="nama_kep_kel" class="form-label">Nama Kepala Keluarga</label>
                                    <input type="text" id="nama_kep_kel" name="nama_kep_kel" class="form-control"
                                        required>
                                </div>

                                <!-- NIK -->
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" maxlength="16"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="nik" name="nik"
                                        class="form-control" required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <!-- ID RT -->
                                <div class="mb-3">
                                    <label for="id_rt" class="form-label">RT</label>
                                    <select id="id_rt" name="id_rt" class="form-select" required>
                                        <option value="" disabled selected>Pilih RT</option>
                                        <?php
                                        // Ambil data RT dari database
                                        $query_rt = "SELECT id_rt, nama_rt FROM rt"; // Ganti dengan query yang sesuai
                                        $result_rt = mysqli_query($koneksi, $query_rt);
                                        while ($row_rt = mysqli_fetch_assoc($result_rt)) {
                                            echo '<option value="' . $row_rt['id_rt'] . '">' . $row_rt['nama_rt'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- ID RW -->
                                <div class="mb-3">
                                    <label for="id_rw" class="form-label">RW</label>
                                    <select id="id_rw" name="id_rw" class="form-select" required>
                                        <option value="" disabled selected>Pilih RW</option>
                                        <?php
                                        // Ambil data RW dari database
                                        $query_rw = "SELECT id_rw, nama_rw FROM rw"; // Ganti dengan query yang sesuai
                                        $result_rw = mysqli_query($koneksi, $query_rw);
                                        while ($row_rw = mysqli_fetch_assoc($result_rw)) {
                                            echo '<option value="' . $row_rw['id_rw'] . '">' . $row_rw['nama_rw'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Wrapper for the submit button to align it to the right -->
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
                                enctype="multipart/form-data">
                                <input type="hidden" id="edit_id" name="id_kk">

                                <!-- Nomor KK -->
                                <div class="mb-3">
                                    <label for="edit_no_kk" class="form-label">Nomor KK</label>
                                    <input type="text" maxlength="16"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="edit_no_kk"
                                        name="no_kk" class="form-control" required>
                                </div>

                                <!-- Nama Kepala Keluarga -->
                                <div class="mb-3">
                                    <label for="edit_nama_kep_kel" class="form-label">Nama Kepala Keluarga</label>
                                    <input type="text" id="edit_nama_kep_kel" name="nama_kep_kel" class="form-control"
                                        required>
                                </div>

                                <!-- NIK -->
                                <div class="mb-3">
                                    <label for="edit_nik" class="form-label">NIK</label>
                                    <input type="text" maxlength="16"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="edit_nik" name="nik"
                                        class="form-control" required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="edit_alamat" class="form-label">Alamat</label>
                                    <textarea id="edit_alamat" name="alamat" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <!-- ID RT -->
                                <div class="mb-3">
                                    <label for="edit_id_rt" class="form-label">RT</label>
                                    <select id="edit_id_rt" name="id_rt" class="form-select" required>
                                        <option value="" disabled selected>Pilih RT</option>
                                        <?php
                                        // Ambil data RT dari database
                                        $query_rt = "SELECT id_rt, nama_rt FROM rt"; // Ganti dengan query yang sesuai
                                        $result_rt = mysqli_query($koneksi, $query_rt);
                                        while ($row_rt = mysqli_fetch_assoc($result_rt)) {
                                            echo '<option value="' . $row_rt['id_rt'] . '">' . $row_rt['nama_rt'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- ID RW -->
                                <div class="mb-3">
                                    <label for="edit_id_rw" class="form-label">RW</label>
                                    <select id="edit_id_rw" name="id_rw" class="form-select" required>
                                        <option value="" disabled selected>Pilih RW</option>
                                        <?php
                                        // Ambil data RW dari database
                                        $query_rw = "SELECT id_rw, nama_rw FROM rw"; // Ganti dengan query yang sesuai
                                        $result_rw = mysqli_query($koneksi, $query_rw);
                                        while ($row_rw = mysqli_fetch_assoc($result_rw)) {
                                            echo '<option value="' . $row_rw['id_rw'] . '">' . $row_rw['nama_rw'] . '</option>';
                                        }
                                        ?>
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
    function openEditModal(id, kk, nama_kep_kel, nik, alamat, id_rt, id_rw) {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_no_kk').value = kk;
        document.getElementById('edit_nama_kep_kel').value = nama_kep_kel;
        document.getElementById('edit_nik').value = nik;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_id_rt').value = id_rt;
        document.getElementById('edit_id_rw').value = id_rw;

        editModal.show();
    }
    </script>

    <?php include 'fitur/js.php'; ?>
</body>

</html>