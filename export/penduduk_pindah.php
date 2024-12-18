<?php
// Ambil data penduduk berdasarkan id_pindah
include '../../../keamanan/koneksi.php';

$id_pindah = isset($_GET['id_pindah']) ? $_GET['id_pindah'] : '';
$query = "
    SELECT pp.id_pindah, p.no_kk, p.nik, p.nama, p.tpt_lahir, p.tgl_lahir, p.jk, p.alamat, p.id_rt, p.agama, pp.id_penduduk,
           rt.nama_rt, p.id_rw, rw.nama_rw, p.pendidikan, p.pekerjaan, p.stts_perkawinan, pp.alasan, pp.tgl_pindah, pp.alamat_asal, pp.alamat_tujuan
    FROM penduduk_pindah pp
    JOIN penduduk p ON pp.id_penduduk = p.id_penduduk
    LEFT JOIN rt ON p.id_rt = rt.id_rt
    LEFT JOIN rw ON p.id_rw = rw.id_rw
    WHERE pp.id_pindah = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $id_pindah);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data dari database
if ($result->num_rows > 0) {
    $dataPenduduk = $result->fetch_assoc();
} else {
    die("Data penduduk tidak ditemukan.");
}

// Ambil data lurah dengan id_lurah = 1
$queryLurah = "SELECT * FROM lurah WHERE id_lurah = 1";
$resultLurah = $koneksi->query($queryLurah);
$dataLurah = $resultLurah->fetch_assoc();

// Ambil konten template surat
$tabelHtml = file_get_contents('penduduk_pindah.html');

// Gantikan placeholder dengan data dari database
$htmlContent = str_replace(
    [
        '[NIK Penduduk]',
        '[Nama Penduduk]',
        '[Tempat Lahir]',
        '[Tanggal Lahir]',
        '[Jenis Kelamin]',
        '[stts_perkawinan]',
        '[Pekerjaan]',
        '[Agama]',
        '[Alamat Lengkap Asal]',
        '[Alamat Lengkap Tujuan]',
        '[Alasan Pindah]',
        '[Tanggal Pindah]',
        '[Kantor_Lurah]',
        '[Nama_Kecamatan]',
        '[Nama_Kabupaten]',
        '[Nomor Surat]',
        '[Tanggal Surat]',
        '[Nama Lurah]',
        '[Username Lurah]',
        '[Nama RT]',
        '[Nama RW]'
    ],
    [
        htmlspecialchars($dataPenduduk['nik']),
        htmlspecialchars($dataPenduduk['nama']),
        htmlspecialchars($dataPenduduk['tpt_lahir']),
        htmlspecialchars($dataPenduduk['tgl_lahir']),
        htmlspecialchars($dataPenduduk['jk']),
        htmlspecialchars($dataPenduduk['stts_perkawinan']),
        htmlspecialchars($dataPenduduk['pekerjaan']),
        htmlspecialchars($dataPenduduk['agama']),
        htmlspecialchars($dataPenduduk['alamat_asal']),
        htmlspecialchars($dataPenduduk['alamat_tujuan']),
        htmlspecialchars($dataPenduduk['alasan']),
        htmlspecialchars($dataPenduduk['tgl_pindah']),
        'Oepura',
        'Kecamatan Maulafa',
        'Kota Kupang',
        '..../..../......',
        date('d M Y'),
        htmlspecialchars($dataLurah['nama_lurah']),
        htmlspecialchars($dataLurah['username']),
        htmlspecialchars($dataPenduduk['nama_rt']),
        htmlspecialchars($dataPenduduk['nama_rw'])
    ],
    $tabelHtml
);

// Buat file HTML sementara di folder sistem
$tmpHtmlFile = tempnam(sys_get_temp_dir(), 'html') . '.html';
file_put_contents($tmpHtmlFile, $htmlContent);

// Nama file output PDF (gunakan direktori sementara untuk menyimpan PDF)
$outputFile = sys_get_temp_dir() . '/hasil_pindah.pdf';

// Jalankan perintah wkhtmltopdf dan tangkap output/error
$command = "C:/xampp/htdocs/sistem_kependudukan/wkhtmltopdf/bin/wkhtmltopdf $tmpHtmlFile $outputFile";
exec($command, $output, $return_var);

// Debugging: cek output wkhtmltopdf
if ($return_var != 0) {
    echo "Gagal menghasilkan PDF. Error: <pre>" . print_r($output, true) . "</pre>";
    unlink($tmpHtmlFile); // Hapus file HTML sementara
    exit;
}

// Hapus file HTML sementara
unlink($tmpHtmlFile);

// Cek apakah file PDF benar-benar ada
if (file_exists($outputFile)) {
    // Kirim PDF ke browser
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="hasil_pindah.pdf"');
    header('Content-Length: ' . filesize($outputFile));
    readfile($outputFile);
} else {
    echo "File PDF tidak ditemukan.";
}
