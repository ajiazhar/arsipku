<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$id = intval($_GET['id']);

// Ambil data arsip untuk hapus file - PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "SELECT arsip_file FROM arsip WHERE arsip_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$l = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Hapus file jika ada
if ($l && $l['arsip_file'] && file_exists("../arsip/" . $l['arsip_file'])) {
    unlink("../arsip/" . $l['arsip_file']);
}

// Hapus data arsip - PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "DELETE FROM arsip WHERE arsip_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: arsip.php?msg=arsip_hapus");
