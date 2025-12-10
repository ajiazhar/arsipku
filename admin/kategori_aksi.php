<?php
include '../koneksi.php';
$nama = $_POST['nama'];
$keterangan = $_POST['keterangan'];

mysqli_query($koneksi, "insert into kategori values (NULL,'$nama','$keterangan')");
header("Location: kategori.php?msg=kategori_tambah");
