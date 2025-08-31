<?php
include '../koneksi.php';

$nama = $_POST['nama'];
$keterangan = $_POST['keterangan'];

mysqli_query($koneksi, "INSERT INTO surat_akses (akses_nama, akses_keterangan) VALUES ('$nama', '$keterangan')");

header("Location: surat.php");
