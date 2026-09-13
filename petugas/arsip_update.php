<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../index.php?alert=belum_login");
    exit();
}

include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');

$id = intval($_POST['id'] ?? 0);
$kode = trim($_POST['kode'] ?? '');
$nama = trim($_POST['pencipta'] ?? '');
$bidang = trim($_POST['bidang'] ?? '');
$tahun = trim($_POST['tahun'] ?? '');
$sampul = trim($_POST['sampul'] ?? '');
$box = trim($_POST['box'] ?? '');
$jumlah = trim($_POST['jumlah'] ?? '');
$index = trim($_POST['arsip_index'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$rak = trim($_POST['rak'] ?? '');
$akses = trim($_POST['akses'] ?? '');
$keterangan = trim($_POST['keterangan'] ?? '');

$rand = rand(1000, 9999);
$filename = $_FILES['file']['name'] ?? '';

if (empty($filename)) {
    // Update data arsip tanpa mengubah berkas - PREPARED STATEMENT
    $sql = "UPDATE arsip SET 
        arsip_kode=?, arsip_nama=?, arsip_bidang=?, arsip_tahun=?, 
        arsip_sampul=?, arsip_box=?, arsip_jumlah=?, arsip_index=?, 
        arsip_deskripsi=?, arsip_kategori=?, arsip_rak=?, surat_akses=?, arsip_keterangan=?
    WHERE arsip_id=?";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssi",
        $kode, $nama, $bidang, $tahun,
        $sampul, $box, $jumlah, $index,
        $deskripsi, $kategori, $rak, $akses, $keterangan, $id
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: arsip.php?msg=arsip_edit");
    exit();

} else {
    $filesize = $_FILES['file']['size'] ?? 0;
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed_ext = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'jpg', 'jpeg', 'png'];

    // ✅ Whitelist ketat & batas ukuran 25 MB
    if (!in_array($ext, $allowed_ext) || $filesize > 25 * 1024 * 1024 || $_FILES['file']['error'] !== 0) {
        header("Location: arsip.php?alert=gagal");
        exit();
    }

    // Ambil info berkas lama untuk dihapus
    $stmt_old = mysqli_prepare($koneksi, "SELECT arsip_file FROM arsip WHERE arsip_id=?");
    mysqli_stmt_bind_param($stmt_old, "i", $id);
    mysqli_stmt_execute($stmt_old);
    $res_old = mysqli_stmt_get_result($stmt_old);
    $l = mysqli_fetch_assoc($res_old);
    mysqli_stmt_close($stmt_old);

    if ($l && !empty($l['arsip_file']) && file_exists("../arsip/" . $l['arsip_file'])) {
        unlink("../arsip/" . $l['arsip_file']);
    }

    // Bersihkan nama berkas baru
    $clean_basename = preg_replace("/[^a-zA-Z0-9\-_]/", "", pathinfo($filename, PATHINFO_FILENAME));
    if (empty($clean_basename)) {
        $clean_basename = "arsip";
    }
    $nama_file = $rand . '_' . time() . '_' . $clean_basename . '.' . $ext;

    if (!move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $nama_file)) {
        header("Location: arsip.php?alert=gagal");
        exit();
    }

    // Update data + berkas baru - PREPARED STATEMENT
    $sql = "UPDATE arsip SET 
        arsip_kode=?, arsip_nama=?, arsip_bidang=?, arsip_tahun=?, 
        arsip_sampul=?, arsip_box=?, arsip_jumlah=?, arsip_index=?, 
        arsip_deskripsi=?, arsip_kategori=?, arsip_rak=?, surat_akses=?, 
        arsip_keterangan=?, arsip_file=?
    WHERE arsip_id=?";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssssssi",
        $kode, $nama, $bidang, $tahun,
        $sampul, $box, $jumlah, $index,
        $deskripsi, $kategori, $rak, $akses,
        $keterangan, $nama_file, $id
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: arsip.php?msg=arsip_edit");
    exit();
}
?>