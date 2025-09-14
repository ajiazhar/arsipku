<?php
include '../koneksi.php';
require '../assets/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

session_start();

// Ambil data dari form
$kode = $_POST['arsip_kode'];
$nama = $_POST['arsip_nama'];
$kategori = $_POST['arsip_kategori'];
$petugas = $_SESSION['id'];   // ✅ otomatis dari session login
$rak = $_POST['arsip_rak'];
$akses = $_POST['surat_akses'];
$keterangan = $_POST['arsip_keterangan'];
$tahun = $_POST['tahun_arsip'];
$deskripsi = $_POST['arsip_deskripsi'];
$box = $_POST['arsip_box'];
$jumlah = $_POST['arsip_jumlah'];
$sampul = $_POST['arsip_sampul'];
$index = $_POST['arsip_index'];
$isi = $_POST['isi'];

// Buat PDF dari isi dokumen
$dompdf = new Dompdf();
$html = "<h2>{$nama}</h2>" . $isi;
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Nama file PDF
$nama_file = $kode . ".pdf";
$path_simpan = "../arsip/" . $nama_file;

// Simpan PDF ke folder
file_put_contents($path_simpan, $dompdf->output());

// Simpan data ke database
$sql = "INSERT INTO arsip 
(arsip_kode, arsip_nama, arsip_kategori, arsip_petugas, arsip_rak, surat_akses, arsip_keterangan, arsip_sampul, arsip_box, arsip_jumlah, arsip_file, arsip_jenis, arsip_waktu_upload, arsip_tahun, arsip_deskripsi, arsip_index) 
VALUES 
('$kode', '$nama', '$kategori', '$petugas', '$rak', '$akses', '$keterangan', '$sampul', '$box', '$jumlah', '$nama_file', 'pdf', NOW(), '$tahun', '$deskripsi', '$index')";


if (!mysqli_query($koneksi, $sql)) {
    die("Query error: " . mysqli_error($koneksi));
}

// Redirect setelah sukses
header("Location: arsip.php?alert=sukses");
exit();
?>