<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$id = intval($_GET['id']);

// Ambil data petugas untuk hapus foto - PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "SELECT petugas_foto FROM petugas WHERE petugas_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Hapus foto jika ada
if ($d && $d['petugas_foto'] && file_exists("../gambar/petugas/" . $d['petugas_foto'])) {
	unlink("../gambar/petugas/" . $d['petugas_foto']);
}

// Hapus data petugas - PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "DELETE FROM petugas WHERE petugas_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: petugas.php?msg=petugas_hapus");
exit;

