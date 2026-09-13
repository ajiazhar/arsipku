<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Ambil data arsip - PREPARED STATEMENT
    $stmt = mysqli_prepare($koneksi, "SELECT arsip_file FROM arsip WHERE arsip_id=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $l = mysqli_fetch_assoc($result);
        $nama_file_lama = $l['arsip_file'];
        mysqli_stmt_close($stmt);

        // Hapus file fisik jika ada
        if (!empty($nama_file_lama) && file_exists("../arsip/" . $nama_file_lama)) {
            unlink("../arsip/" . $nama_file_lama);
        }

        // Hapus data dari DB - PREPARED STATEMENT
        $stmt = mysqli_prepare($koneksi, "DELETE FROM arsip WHERE arsip_id=? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: arsip.php?msg=arsip_hapus");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        header("location:arsip.php?alert=tidak_ditemukan");
        exit();
    }
} else {
    header("location:arsip.php?alert=invalid_id");
    exit();
}
?>