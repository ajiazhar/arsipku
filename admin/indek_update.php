<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$id = intval($_POST['id']);
$nama = trim($_POST['index_nama']);

// PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "UPDATE `index` SET index_nama=? WHERE index_id=?");
mysqli_stmt_bind_param($stmt, "si", $nama, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: indek.php?msg=index_edit");
?>