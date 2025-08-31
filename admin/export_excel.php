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

// Query dasar
$sql = "SELECT a.*, 
               k.kategori_nama, 
               p.petugas_nama, 
               COALESCE(r.rak_nama, 'Belum diatur')   AS rak_nama, 
               COALESCE(s.akses_nama, 'Belum diatur') AS akses_nama
        FROM arsip a
        LEFT JOIN kategori k   ON a.arsip_kategori = k.kategori_id
        LEFT JOIN petugas p    ON a.arsip_petugas  = p.petugas_id
        LEFT JOIN arsip_rak r  ON a.arsip_rak      = r.rak_id
        LEFT JOIN surat_akses s ON a.surat_akses   = s.akses_id
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

$sql .= " ORDER BY a.arsip_id DESC";

$result = mysqli_query($koneksi, $sql);
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Buat Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$sheet->fromArray(
    ['Waktu Upload', 'Kode', 'Nama', 'Jenis', 'Kategori', 'Petugas', 'Rak', 'Surat Akses', 'Keterangan', 'File'],
    NULL,
    'A1'
);

// Isi data
$row = 2;
while ($data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue("A$row", $data['arsip_waktu_upload']);
    $sheet->setCellValue("B$row", $data['arsip_kode']);
    $sheet->setCellValue("C$row", $data['arsip_nama']);
    $sheet->setCellValue("D$row", $data['arsip_jenis']);
    $sheet->setCellValue("E$row", $data['kategori_nama']);
    $sheet->setCellValue("F$row", $data['petugas_nama']);
    $sheet->setCellValue("G$row", $data['rak_nama']);
    $sheet->setCellValue("H$row", $data['akses_nama']);
    $sheet->setCellValue("I$row", $data['arsip_keterangan']);
    $sheet->setCellValue("J$row", $data['arsip_file']);
    $row++;
}

// Export ke file Excel
$writer = new Xlsx($spreadsheet);
$filename = "arsip_export_" . date('Y-m-d_H-i-s') . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
