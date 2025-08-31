<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // pastikan id berupa angka

    // hapus data berdasarkan id
    mysqli_query($koneksi, "DELETE FROM surat_akses WHERE akses_id='$id'");
}

header("Location: surat.php");
exit;
