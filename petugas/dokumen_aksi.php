<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../index.php?alert=belum_login");
    exit();
}

include '../koneksi.php';
require '../assets/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Ambil data dari form
$kode = trim($_POST['arsip_kode'] ?? '');
$nama = trim($_POST['arsip_nama'] ?? '');      // pencipta
$bidang = trim($_POST['arsip_bidang'] ?? '');
$kategori = trim($_POST['arsip_kategori'] ?? '');
$petugas = intval($_SESSION['id']);            // otomatis dari session login
$rak = trim($_POST['arsip_rak'] ?? '');
$akses = trim($_POST['surat_akses'] ?? '');
$keterangan = trim($_POST['arsip_keterangan'] ?? '');
$tahun = trim($_POST['tahun_arsip'] ?? '');
$deskripsi = trim($_POST['arsip_deskripsi'] ?? '');
$box = trim($_POST['arsip_box'] ?? '');
$jumlah = trim($_POST['arsip_jumlah'] ?? '');
$sampul = trim($_POST['arsip_sampul'] ?? '');
$index = trim($_POST['arsip_index'] ?? '');
$isi = $_POST['isi'] ?? '';

// Validasi minimal
if (empty($kode) || empty($nama) || empty($tahun) || empty($isi)) {
    header("Location: arsip_tambah.php?alert=gagal");
    exit();
}

// Buat PDF dari isi dokumen
$dompdf = new Dompdf();
$html = "<h2 style='text-align:center;'>" . htmlspecialchars($nama) . "</h2>"
    . "<p><strong>Bidang:</strong> " . htmlspecialchars($bidang) . "</p>"
    . "<hr>"
    . $isi;

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Nama file PDF bersih & unik
$clean_kode = preg_replace("/[^a-zA-Z0-9_-]/", "", $kode);
$nama_file = $clean_kode . "_" . time() . "_" . rand(100, 999) . ".pdf";
$path_simpan = "../arsip/" . $nama_file;

// Simpan PDF ke folder arsip
if (!file_put_contents($path_simpan, $dompdf->output())) {
    header("Location: arsip_tambah.php?alert=gagal");
    exit();
}

// Simpan data ke database dengan Prepared Statement
$sql = "INSERT INTO arsip (
    arsip_kode, arsip_nama, arsip_bidang, arsip_kategori, arsip_petugas, 
    arsip_rak, surat_akses, arsip_keterangan, arsip_sampul, arsip_box, 
    arsip_jumlah, arsip_file, arsip_waktu_upload, arsip_tahun, arsip_deskripsi, arsip_index
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param(
    $stmt, 
    "ssssissssssssss", 
    $kode, $nama, $bidang, $kategori, $petugas, 
    $rak, $akses, $keterangan, $sampul, $box, 
    $jumlah, $nama_file, $tahun, $deskripsi, $index
);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Redirect setelah sukses
header("Location: arsip.php?msg=arsip_tambah");
exit();
?>
