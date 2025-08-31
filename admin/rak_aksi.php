<?php
include '../koneksi.php';
$rak = $_POST['nama'];

mysqli_query($koneksi, "insert into arsip_rak values (NULL,'$rak')");
header("location:rak.php");