<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$nama = trim($_POST['nama']);
$keterangan = trim($_POST['keterangan']);

// PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "INSERT INTO surat_akses (akses_nama, akses_keterangan) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $nama, $keterangan);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: surat.php?msg=surat_tambah");
exit;
?>