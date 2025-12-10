<?php
include '../koneksi.php';

$id = $_POST['id'];
$nama = $_POST['index_nama'];

mysqli_query($koneksi, "UPDATE `index` SET index_nama='$nama' WHERE index_id='$id'");
header("Location: indek.php?msg=index_edit");
?>