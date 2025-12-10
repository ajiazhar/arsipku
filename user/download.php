<?php
session_start();
include "../koneksi.php";

// Pastikan ID arsip dikirim
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id_arsip = intval($_GET['id']);

// Ambil data arsip
$q = mysqli_query($koneksi, "SELECT * FROM arsip WHERE arsip_id='$id_arsip'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
    die("Data arsip tidak ditemukan.");
}

$file = "../arsip/" . $d['arsip_file'];

if (!file_exists($file)) {
    die("File tidak ditemukan di server.");
}

// ==============================
//  INSERT RIWAYAT DOWNLOAD
// ==============================
if (isset($_SESSION['id'])) {
    $id_user = $_SESSION['id'];  // id user/petugas yang login

    mysqli_query($koneksi, "INSERT INTO riwayat 
        (riwayat_waktu, riwayat_user, riwayat_arsip)
        VALUES (NOW(), '$id_user', '$id_arsip')");
}

// ==============================
//  PROSES DOWNLOAD FILE
// ==============================
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
header("Content-Length: " . filesize($file));

readfile($file);
exit;
?>