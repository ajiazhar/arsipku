<?php
include '../koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$keterangan = $_POST['keterangan']; // ambil dari form edit

// update data surat akses
mysqli_query(
    $koneksi,
    "UPDATE surat_akses 
     SET akses_nama='$nama', akses_keterangan='$keterangan' 
     WHERE akses_id='$id'"
);

header("Location: surat.php");
exit;
