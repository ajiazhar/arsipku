<?php
include '../koneksi.php';
session_start();

$id = $_GET['id'];

// ambil data petugas
$data = mysqli_query($koneksi, "SELECT petugas_foto FROM petugas WHERE petugas_id='$id'");
$a = mysqli_fetch_assoc($data);

if ($a) {
    // hapus file lama jika bukan default
    if (!empty($a['petugas_foto']) && $a['petugas_foto'] != '') {
        $oldPath = "../gambar/petugas/" . $a['petugas_foto'];
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // update db -> pakai 
    mysqli_query($koneksi, "UPDATE petugas SET petugas_foto='' WHERE petugas_id='$id'");
}

header("Location: profil.php?alert=hapus_sukses");
exit;
