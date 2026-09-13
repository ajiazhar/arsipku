<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$rak = trim($_POST['nama']);

// PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "INSERT INTO arsip_rak (rak_nama) VALUES (?)");
mysqli_stmt_bind_param($stmt, "s", $rak);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("location:rak.php?msg=rak_tambah");