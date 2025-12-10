<?php
include '../koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$waktu = date('Y-m-d H:i:s');
$petugas = $_SESSION['id'];
$kode = $_POST['kode'];
$index = $_POST['index'];
$nama = $_POST['pencipta'];
$bidang = $_POST['bidang'];
$tahun = $_POST['tahun'];
$rak = $_POST['arsip_rak']; // pastikan name="arsip_rak" di form
$jumlah = $_POST['jumlah'];
$akses = $_POST['akses'];
$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];
$deskripsi = $_POST['deskripsi'];
$sampul = $_POST['sampul'];
$box = $_POST['box'];

$rand = rand();
$filename = $_FILES['file']['name'];
$jenis = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// ✅ Cegah upload file berbahaya
if ($jenis === "php" || $jenis === "exe" || $jenis === "js") {
	header("location:arsip.php?alert=gagal");
	exit();
}

// ✅ Upload file
$nama_file = $rand . '_' . basename($filename);
move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $nama_file);

// ✅ Simpan ke database
$query = "
	INSERT INTO arsip 
	(arsip_waktu_upload, arsip_tahun, arsip_petugas, arsip_rak, arsip_jumlah, surat_akses, arsip_kode, arsip_index, arsip_nama, arsip_bidang, arsip_kategori, arsip_keterangan, arsip_deskripsi, arsip_sampul, arsip_box, arsip_file)
	VALUES 
	('$waktu', '$tahun', '$petugas', '$rak', '$jumlah', '$akses', '$kode', '$index', '$nama', '$bidang', '$kategori', '$keterangan', '$deskripsi', '$sampul', '$box', '$nama_file')
";

if (mysqli_query($koneksi, $query)) {
	header("Location: arsip.php?msg=arsip_tambah");
	exit();
} else {
	die("Query Error: " . mysqli_error($koneksi));
}
?>