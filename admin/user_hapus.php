<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$id = intval($_GET['id']);

// Ambil data user untuk hapus foto - PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "SELECT user_foto FROM user WHERE user_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Hapus foto jika ada
if ($d && $d['user_foto'] && file_exists("../gambar/user/" . $d['user_foto'])) {
	unlink("../gambar/user/" . $d['user_foto']);
}

// Hapus data user - PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "DELETE FROM user WHERE user_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: user.php?msg=user_hapus");
exit;

