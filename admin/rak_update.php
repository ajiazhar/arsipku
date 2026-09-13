<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$id = intval($_POST['id']);
$nama = trim($_POST['nama']);

// PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "UPDATE arsip_rak SET rak_nama=? WHERE rak_id=?");
mysqli_stmt_bind_param($stmt, "si", $nama, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("location:rak.php?msg=rak_edit");
?>