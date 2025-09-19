<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Ambil filter dari URL
$jenis = $_GET['jenis'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$rak = $_GET['rak'] ?? '';
$akses = $_GET['akses'] ?? '';
$sampul = $_GET['sampul'] ?? '';
$nama = $_GET['pencipta'] ?? '';
$box = $_GET['box'] ?? '';

// Query dasar
$sql = "SELECT a.*, 
               k.kategori_nama, 
               p.petugas_nama, 
               COALESCE(r.rak_nama, 'Belum diatur')   AS rak_nama, 
               COALESCE(s.akses_nama, 'Belum diatur') AS akses_nama
        FROM arsip a
        LEFT JOIN kategori k    ON a.arsip_kategori = k.kategori_id
        LEFT JOIN petugas p     ON a.arsip_petugas  = p.petugas_id
        LEFT JOIN arsip_rak r   ON a.arsip_rak      = r.rak_id
        LEFT JOIN surat_akses s ON a.surat_akses    = s.akses_id
        WHERE 1=1";


// Filter jenis
if ($jenis !== '') {
    $safeJenis = mysqli_real_escape_string($koneksi, $jenis);
    $sql .= " AND a.arsip_jenis = '$safeJenis'";
}

// Filter kategori
if ($kategori !== '') {
    $sql .= " AND a.arsip_kategori = " . intval($kategori);
}

// Filter rak
if ($rak !== '') {
    $sql .= " AND a.arsip_rak = " . intval($rak);
}

// Filter surat akses
if ($akses !== '') {
    $sql .= " AND a.surat_akses = " . intval($akses);
}

// Filter sampul
if ($sampul !== '') {
    $safeSampul = mysqli_real_escape_string($koneksi, $sampul);
    $sql .= " AND a.arsip_sampul LIKE '%$safeSampul%'";
}

if ($nama !== '') {
    $safeNama = mysqli_real_escape_string($koneksi, $nama);
    $sql .= " AND a.arsip_nama LIKE '%$safeNama%'";
}

// Filter box
if ($box !== '') {
    $safeBox = mysqli_real_escape_string($koneksi, $box);
    $sql .= " AND a.arsip_box LIKE '%$safeBox%'";
}

$sql .= " ORDER BY a.arsip_id DESC";

$result = mysqli_query($koneksi, $sql);
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Buat Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ===== Tambahkan judul & info instansi di atas tabel =====
$sheet->setCellValue('C2', 'DAFTAR ARSIP INAKTIF');
$sheet->mergeCells('C2:H2');
$sheet->getStyle('C2')->getFont()->setBold(true);

$sheet->setCellValue('A3', 'PENCIPTA : ' . $nama);
$sheet->setCellValue('A4', 'UNIT PENGOLAH :' . $bidang);

// Header tabel
$sheet->fromArray(
    [
        'NO',
        'KODE KLASIFIKASI',
        'INDEKS',
        'URAIAN INFORMASI ARSIP',
        'KURUN WAKTU',
        'JUMLAH',
        'SAMPUL',
        'BOX',
        'RAK',
        'TINGKAT PERKEMBANGAN',
        'HAK AKSES',
        'KETERANGAN'
    ],
    NULL,
    'A6' // Mulai dari baris 6 (biar bisa nambah judul di atasnya)
);


// Isi data
$row = 7; // mulai dari baris setelah header
while ($data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue("A$row", "=ROW()-6"); // NOMOR ARSIP
    $sheet->setCellValue("B$row", $data['arsip_kode']); // KODE KLASIFIKASI
    $sheet->setCellValue("C$row", $data['arsip_bidang']); // INDEKS
    $sheet->setCellValue("D$row", $data['arsip_deskripsi']); // URAIAN INFORMASI
    $sheet->setCellValue("E$row", $data['arsip_tahun']); // KURUN WAKTU
    $sheet->setCellValue("F$row", $data['arsip_jumlah']); // JUMLAH
    $sheet->setCellValue("G$row", $data['arsip_sampul']); // SAMPUL
    $sheet->setCellValue("H$row", $data['arsip_box']); // BOX
    $sheet->setCellValue("I$row", $data['rak_nama']); // RAK
    $sheet->setCellValue("J$row", $data['kategori_nama']); // TINGKAT PERKEMBANGAN
    $sheet->setCellValue("K$row", $data['akses_nama']); // HAK AKSES
    $sheet->setCellValue("L$row", $data['arsip_keterangan']); // KETERANGAN
    $row++;
}


// Export ke file Excel
$writer = new Xlsx($spreadsheet);
$filename = "arsip_export_" . date('Y-m-d_H-i-s') . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

if (ob_get_length())
    ob_clean();
flush();
$writer->save('php://output');
exit;

