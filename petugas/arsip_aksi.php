<?php
include '../koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$waktu = date('Y-m-d H:i:s');
$petugas = $_SESSION['id'];
$kode = $_POST['kode'];
$index = $_POST['index'];
$nama = $_POST['nama'];
$tahun = $_POST['tahun']; // input manual

$rand = rand();
$filename = $_FILES['file']['name'];
$jenis = pathinfo($filename, PATHINFO_EXTENSION);

$rak = $_POST['rak'];
$jumlah = $_POST['jumlah'];
$akses = $_POST['akses'];
$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];
$deskripsi = $_POST['deskripsi'];
$sampul = $_POST['sampul'];
$box = $_POST['box'];

// Cegah upload file php
if ($jenis == "php") {
	header("location:arsip.php?alert=gagal");
	exit();
} else {
	$nama_file = $rand . '_' . $filename;
	move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $nama_file);

	// Insert data ke tabel arsip langsung pakai arsip_tahun
	$query = "INSERT INTO arsip 
        (arsip_waktu_upload, arsip_tahun, arsip_petugas, arsip_rak, arsip_jumlah, surat_akses, arsip_kode, arsip_index, arsip_nama, arsip_kategori, arsip_keterangan, arsip_deskripsi, arsip_sampul, arsip_box, arsip_file) 
        VALUES 
        ('$waktu', '$tahun', '$petugas', '$rak', '$jumlah', '$akses', '$kode', '$index', '$nama', '$kategori', '$keterangan', '$deskripsi', '$sampul', '$box', '$nama_file')";

	mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

	header("location:arsip.php?alert=sukses");
	exit();
}
?>