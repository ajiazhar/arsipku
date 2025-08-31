<?php
include '../koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$waktu = date('Y-m-d H:i:s');
$petugas = $_SESSION['id'];
$kode = $_POST['kode'];
$nama = $_POST['nama'];

$rand = rand();
$filename = $_FILES['file']['name'];
$jenis = pathinfo($filename, PATHINFO_EXTENSION);

$rak = $_POST['rak'];       // dropdown rak
$akses = $_POST['akses'];     // dropdown akses (pakai surat_akses di DB)
$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];

// Cegah upload file php
if ($jenis == "php") {
	header("location:arsip.php?alert=gagal");
	exit();
} else {
	// Simpan file
	$nama_file = $rand . '_' . $filename;
	move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $nama_file);

	// Insert data ke tabel arsip
	$query = "INSERT INTO arsip 
        (arsip_waktu_upload, arsip_petugas, arsip_rak, surat_akses, arsip_kode, arsip_nama, arsip_jenis, arsip_kategori, arsip_keterangan, arsip_file) 
        VALUES 
        ('$waktu', '$petugas', '$rak', '$akses', '$kode', '$nama', '$jenis', '$kategori', '$keterangan', '$nama_file')";

	mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

	header("location:arsip.php?alert=sukses");
	exit();
}
?>