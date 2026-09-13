<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../index.php?alert=belum_login");
    exit();
}

include "../koneksi.php";

// Pastikan ID arsip dikirim
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id_arsip = intval($_GET['id']);

// Ambil data arsip - PREPARED STATEMENT
$stmt = mysqli_prepare($koneksi, "SELECT arsip_file FROM arsip WHERE arsip_id=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id_arsip);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$d || empty($d['arsip_file'])) {
    die("Data arsip tidak ditemukan.");
}

// Amankan nama file dari path traversal
$safe_filename = basename($d['arsip_file']);
$file = "../arsip/" . $safe_filename;

if (!file_exists($file)) {
    die("File tidak ditemukan di server.");
}

// ==============================
//  INSERT RIWAYAT DOWNLOAD
// ==============================
if (isset($_SESSION['id']) && $_SESSION['role'] === 'user') {
    $id_user = intval($_SESSION['id']);

    $stmt_r = mysqli_prepare($koneksi, "INSERT INTO riwayat (riwayat_waktu, riwayat_user, riwayat_arsip) VALUES (NOW(), ?, ?)");
    mysqli_stmt_bind_param($stmt_r, "ii", $id_user, $id_arsip);
    mysqli_stmt_execute($stmt_r);
    mysqli_stmt_close($stmt_r);
}

// ==============================
//  PROSES DOWNLOAD FILE
// ==============================
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $safe_filename . "\"");
header("Content-Length: " . filesize($file));
header("Cache-Control: private, must-revalidate");
header("Pragma: public");

// Bersihkan output buffer sebelum readfile
if (ob_get_level()) {
    ob_end_clean();
}

readfile($file);
exit;
?>