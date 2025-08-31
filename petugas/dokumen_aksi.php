<?php
include '../koneksi.php';
require '../assets/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
session_start();

$kode = $_POST['arsip_kode'];
$nama = $_POST['arsip_nama'];
$kategori = $_POST['arsip_kategori'];
$petugas = $_SESSION['id'];   // ✅ otomatis terisi dari session login
$rak = $_POST['arsip_rak'];
$akses = $_POST['surat_akses'];
$keterangan = $_POST['arsip_keterangan'];
$isi = $_POST['isi'];

// Buat PDF
$dompdf = new Dompdf();
$html = "<h2>{$nama}</h2>" . $isi;
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Nama file PDF
$nama_file = $kode . ".pdf";
$path_simpan = "../arsip/" . $nama_file;
file_put_contents($path_simpan, $dompdf->output());

// Simpan ke database
$sql = "INSERT INTO arsip 
    (arsip_kode, arsip_nama, arsip_kategori, arsip_petugas, arsip_rak, surat_akses, arsip_keterangan, arsip_file, arsip_jenis, arsip_waktu_upload) 
    VALUES 
    ('$kode', '$nama', '$kategori', '$petugas', '$rak', '$akses', '$keterangan', '$nama_file', 'pdf', NOW())";

if (!mysqli_query($koneksi, $sql)) {
    die("Query error: " . mysqli_error($koneksi));
}

header("Location: arsip.php?alert=sukses");
?>