<?php
include '../koneksi.php';
session_start();

$id = $_GET['id'];

// ambil data user
$data = mysqli_query($koneksi, "SELECT user_foto FROM user WHERE user_id='$id'");
$a = mysqli_fetch_assoc($data);

if ($a) {
    // hapus file lama jika bukan default
    if (!empty($a['user_foto']) && $a['user_foto'] != '') {
        $oldPath = "../gambar/user/" . $a['user_foto'];
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // update db -> pakai 
    mysqli_query($koneksi, "UPDATE user SET user_foto='' WHERE user_id='$id'");
}

header("Location: profil.php?alert=hapus_sukses");
exit;
