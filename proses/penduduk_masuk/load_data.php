 <div id="load_data">
     <section class="section">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-body text-center">
                         <!-- Search Form -->
                         <form method="GET" action="">
                             <div class="input-group mt-3">
                                 <input type="text" class="form-control" placeholder="Cari kk atau nomor rekening..."
                                     name="search"
                                     value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                 <button class="btn btn-outline-secondary" type="submit">Cari</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <?php
        include '../../../../keamanan/koneksi.php';

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Query untuk mendapatkan data penduduk_masuk dengan pencarian dan pagination
        $query = "SELECT pm.id_masuk, p.no_kk, p.nik, p.nama, p.tpt_lahir, p.tgl_lahir, p.jk, p.alamat, p.id_rt, p.agama, pm.id_penduduk,
                 rt.nama_rt, p.id_rw, rw.nama_rw, p.pendidikan, p.pekerjaan, p.status, pm.alasan, pm.tanggal_masuk
          FROM penduduk_masuk pm
          JOIN penduduk p ON pm.id_penduduk = p.id_penduduk
          LEFT JOIN rt ON p.id_rt = rt.id_rt
          LEFT JOIN rw ON p.id_rw = rw.id_rw
          WHERE p.nama LIKE ? LIMIT ?, ?";

        $stmt = $koneksi->prepare($query);
        $search_param = '%' . $search . '%';
        $stmt->bind_param("sii", $search_param, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Hitung total halaman
        $total_query = "SELECT COUNT(*) as total FROM penduduk_masuk pm
                JOIN penduduk p ON pm.id_penduduk = p.id_penduduk
                WHERE p.nama LIKE ?";
        $stmt_total = $koneksi->prepare($total_query);
        $stmt_total->bind_param("s", $search_param);
        $stmt_total->execute();
        $total_result = $stmt_total->get_result();
        $total_row = $total_result->fetch_assoc();
        $total_pages = ceil($total_row['total'] / $limit);
        ?>

     <!-- Tabel Data penduduk_masuk -->
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
                                             <th style="white-space: nowrap;">Alasan</th>
                                             <th style="white-space: nowrap;">Tanggal Masuk</th>
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
                                                 <td><?php echo htmlspecialchars($row['alasan']); ?></td>
                                                 <td><?php echo htmlspecialchars($row['tanggal_masuk']); ?>
                                                 </td>
                                                 <td>
                                                     <button class="btn btn-warning btn-sm m-1"
                                                         onclick="openEditModal('<?php echo $row['id_masuk']; ?>', '<?php echo $row['id_penduduk']; ?>', '<?php echo addslashes($row['alasan']); ?>', '<?php echo $row['tanggal_masuk']; ?>')">Edit</button>
                                                     <button class="btn btn-danger btn-sm m-1"
                                                         onclick="hapus('<?php echo $row['id_masuk']; ?>')">Hapus</button>

                                                     <!-- Form untuk kirim ke halaman data_pdf1 -->
                                                     <form action="export/penduduk_masuk" method="GET"
                                                         style="display: inline-block;">
                                                         <input type="hidden" name="id_masuk"
                                                             value="<?php echo $row['id_masuk']; ?>">
                                                         <button type="submit" class="btn btn-primary btn-sm m-1">Cetak
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