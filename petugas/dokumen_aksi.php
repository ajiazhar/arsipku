<?php
include '../koneksi.php';
require '../assets/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

session_start();

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data dari form
$kode = $_POST['arsip_kode'] ?? '';
$nama = $_POST['arsip_nama'] ?? '';      // pencipta
$bidang = $_POST['arsip_bidang'] ?? null;
$kategori = $_POST['arsip_kategori'] ?? '';
$petugas = $_SESSION['id'];                 // otomatis dari session login
$rak = $_POST['arsip_rak'] ?? null;
$akses = $_POST['surat_akses'] ?? null;
$keterangan = $_POST['arsip_keterangan'] ?? '';
$tahun = $_POST['tahun_arsip'] ?? '';
$deskripsi = $_POST['arsip_deskripsi'] ?? '';
$box = $_POST['arsip_box'] ?? '';
$jumlah = $_POST['arsip_jumlah'] ?? '';
$sampul = $_POST['arsip_sampul'] ?? '';
$index = $_POST['arsip_index'] ?? null;
$isi = $_POST['isi'] ?? '';

// Validasi minimal
if (empty($kode) || empty($nama) || empty($tahun) || empty($isi)) {
    die("Error: Data penting tidak boleh kosong.");
}

// Buat PDF dari isi dokumen
$dompdf = new Dompdf();
$html = "<h2 style='text-align:center;'>$nama</h2>"
    . "<p><strong>Bidang:</strong> $bidang</p>"
    . "<hr>"
    . $isi;

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Nama file PDF (pastikan unik)
$nama_file = $kode . "_" . time() . ".pdf";
$path_simpan = "../arsip/" . $nama_file;

// Simpan PDF ke folder
if (!file_put_contents($path_simpan, $dompdf->output())) {
    die("Gagal menyimpan file PDF.");
}

// Simpan data ke database
$sql = "INSERT INTO arsip 
(arsip_kode, arsip_nama, arsip_bidang, arsip_kategori, arsip_petugas, arsip_rak, surat_akses, arsip_keterangan, arsip_sampul, arsip_box, arsip_jumlah, arsip_file, arsip_waktu_upload, arsip_tahun, arsip_deskripsi, arsip_index) 
VALUES 
(
    '$kode',
    '$nama',
    " . ($bidang ? "'$bidang'" : "NULL") . ",
    '$kategori',
    '$petugas',
    '$rak',
    '$akses',
    '$keterangan',
    '$sampul',
    '$box',
    '$jumlah',
    '$nama_file',
    NOW(),
    '$tahun',
    '$deskripsi',
    '$index'
)";


if (!mysqli_query($koneksi, $sql)) {
    die("Query error: " . mysqli_error($koneksi));
}

// Redirect setelah sukses
header("Location: arsip.php?alert=sukses");
exit();
