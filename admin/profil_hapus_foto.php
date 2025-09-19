<?php
include '../koneksi.php';
session_start();

$id = $_GET['id'];

// ambil data admin
$data = mysqli_query($koneksi, "SELECT admin_foto FROM admin WHERE admin_id='$id'");
$a = mysqli_fetch_assoc($data);

if ($a) {
    // hapus file lama jika bukan default
    if (!empty($a['admin_foto']) && $a['admin_foto'] != '') {
        $oldPath = "../gambar/admin/" . $a['admin_foto'];
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // update db -> pakai 
    mysqli_query($koneksi, "UPDATE admin SET admin_foto='' WHERE admin_id='$id'");
}

header("Location: profil.php?alert=hapus_sukses");
exit;
