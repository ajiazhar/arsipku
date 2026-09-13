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
$keterangan = trim($_POST['keterangan']);

// PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "UPDATE kategori SET kategori_nama=?, kategori_keterangan=? WHERE kategori_id=?");
mysqli_stmt_bind_param($stmt, "ssi", $nama, $keterangan, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: kategori.php?msg=kategori_edit");

