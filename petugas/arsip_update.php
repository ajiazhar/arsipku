<?php
include '../koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$id = $_POST['id'];
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$rak = isset($_POST['rak']) ? $_POST['rak'] : NULL;
$akses = isset($_POST['akses']) ? $_POST['akses'] : NULL;
$keterangan = $_POST['keterangan'];

$rand = rand();
$filename = $_FILES['file']['name'];

if ($filename == "") {

	mysqli_query($koneksi, "
        UPDATE arsip SET 
            arsip_kode='$kode', 
            arsip_nama='$nama', 
            arsip_kategori='$kategori', 
            arsip_rak=" . ($rak ? "'$rak'" : "NULL") . ", 
            surat_akses=" . ($akses ? "'$akses'" : "NULL") . ", 
            arsip_keterangan='$keterangan' 
        WHERE arsip_id='$id'
    ") or die(mysqli_error($koneksi));

	header("location:arsip.php");

} else {

	$jenis = pathinfo($filename, PATHINFO_EXTENSION);

	if ($jenis == "php") {
		header("location:arsip.php?alert=gagal");
	} else {

		// hapus file lama
		$lama = mysqli_query($koneksi, "SELECT * FROM arsip WHERE arsip_id='$id'");
		$l = mysqli_fetch_assoc($lama);
		$nama_file_lama = $l['arsip_file'];
		if (file_exists("../arsip/" . $nama_file_lama)) {
			unlink("../arsip/" . $nama_file_lama);
		}

		// upload file baru
		$nama_file = $rand . '_' . $filename;
		move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $nama_file);

		mysqli_query($koneksi, "
            UPDATE arsip SET 
                arsip_kode='$kode', 
                arsip_nama='$nama', 
                arsip_jenis='$jenis', 
                arsip_kategori='$kategori', 
                arsip_rak=" . ($rak ? "'$rak'" : "NULL") . ", 
                surat_akses=" . ($akses ? "'$akses'" : "NULL") . ", 
                arsip_keterangan='$keterangan', 
                arsip_file='$nama_file' 
            WHERE arsip_id='$id'
        ") or die(mysqli_error($koneksi));

		header("location:arsip.php?alert=sukses");
	}
}
