<?php
include '../koneksi.php';

$nama = $_POST['index_nama'];
mysqli_query($koneksi, "INSERT INTO `index` (index_nama) VALUES ('$nama')");
header("location:indek.php?alert=sukses");
?>