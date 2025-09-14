<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Ambil data arsip
    $lama = mysqli_query($koneksi, "SELECT * FROM arsip WHERE arsip_id='$id'");
    $l = mysqli_fetch_assoc($lama);

    if ($l) {
        $nama_file_lama = $l['arsip_file'];

        // Hapus file fisik jika ada
        if (!empty($nama_file_lama) && file_exists("../arsip/" . $nama_file_lama)) {
            unlink("../arsip/" . $nama_file_lama);
        }

        // Hapus data dari DB
        mysqli_query($koneksi, "DELETE FROM arsip WHERE arsip_id='$id'") or die(mysqli_error($koneksi));

        header("location:arsip.php?alert=hapus_sukses");
        exit();
    } else {
        header("location:arsip.php?alert=tidak_ditemukan");
        exit();
    }
} else {
    header("location:arsip.php?alert=invalid_id");
    exit();
}
?>