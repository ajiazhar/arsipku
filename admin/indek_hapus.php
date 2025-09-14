<?php
include '../koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM `index` WHERE index_id='$id'");
header("location:indek.php?alert=hapus");
?>