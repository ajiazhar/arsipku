<?php
include '../koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM `index` WHERE index_id='$id'");
header("Location: indek.php?msg=index_hapus");
?>