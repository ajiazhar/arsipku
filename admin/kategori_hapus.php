<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$id = intval($_GET['id']);

// PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "DELETE FROM kategori WHERE kategori_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: kategori.php?msg=kategori_hapus");
