<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../index.php?alert=belum_login");
    exit();
}

include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');

$waktu = date('Y-m-d H:i:s');
$petugas = intval($_SESSION['id']);
$kode = trim($_POST['kode'] ?? '');
$index = trim($_POST['index'] ?? '');
$nama = trim($_POST['pencipta'] ?? '');
$bidang = trim($_POST['bidang'] ?? '');
$tahun = trim($_POST['tahun'] ?? '');
$rak = trim($_POST['arsip_rak'] ?? '');
$jumlah = trim($_POST['jumlah'] ?? '');
$akses = trim($_POST['akses'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$keterangan = trim($_POST['keterangan'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$sampul = trim($_POST['sampul'] ?? '');
$box = trim($_POST['box'] ?? '');

$rand = rand(1000, 9999);
$allowed_ext = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'jpg', 'jpeg', 'png'];

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
    header("Location: arsip.php?alert=gagal");
    exit();
}

$filename = $_FILES['file']['name'];
$filesize = $_FILES['file']['size'];
$jenis = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// ✅ Whitelist ekstensi ketat & batas ukuran file (maks 25 MB)
if (!in_array($jenis, $allowed_ext) || $filesize > 25 * 1024 * 1024) {
    header("Location: arsip.php?alert=gagal");
    exit();
}

// ✅ Bersihkan dan amankan nama file dari karakter berbahaya
$clean_basename = preg_replace("/[^a-zA-Z0-9\-_]/", "", pathinfo($filename, PATHINFO_FILENAME));
if (empty($clean_basename)) {
    $clean_basename = "arsip";
}
$nama_file = $rand . '_' . time() . '_' . $clean_basename . '.' . $jenis;

if (!move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $nama_file)) {
    header("Location: arsip.php?alert=gagal");
    exit();
}

// ✅ Simpan ke database dengan PREPARED STATEMENT
$sql = "INSERT INTO arsip (
    arsip_waktu_upload, arsip_tahun, arsip_petugas, arsip_rak, arsip_jumlah, 
    surat_akses, arsip_kode, arsip_index, arsip_nama, arsip_bidang, 
    arsip_kategori, arsip_keterangan, arsip_deskripsi, arsip_sampul, arsip_box, arsip_file
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "ssisssssssssssss",
    $waktu, $tahun, $petugas, $rak, $jumlah,
    $akses, $kode, $index, $nama, $bidang,
    $kategori, $keterangan, $deskripsi, $sampul, $box, $nama_file
);
$sukses = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($sukses) {
    header("Location: arsip.php?msg=arsip_tambah");
    exit();
} else {
    // Hapus file yang sudah terlanjur diupload jika query gagal
    if (file_exists('../arsip/' . $nama_file)) {
        unlink('../arsip/' . $nama_file);
    }
    header("Location: arsip.php?alert=gagal");
    exit();
}
?>