<?php
include '../koneksi.php';
$id = $_POST['id'];
$nama = $_POST['nama'];

mysqli_query($koneksi, "update arsip_rak set rak_nama='$nama' where rak_id='$id'");
header("location:rak.php");
?>