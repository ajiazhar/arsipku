<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$nama = trim($_POST['index_nama']);

// PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "INSERT INTO `index` (index_nama) VALUES (?)");
mysqli_stmt_bind_param($stmt, "s", $nama);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: indek.php?msg=index_tambah");
?>