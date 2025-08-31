<?php
include '../koneksi.php';
$id = $_GET['id'];

mysqli_query($koneksi, "delete from arsip_rak where rak_id='$id'");
header("location:rak.php");
?>