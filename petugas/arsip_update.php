<?php
include '../koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$id = $_POST['id'];
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$tahun = $_POST['tahun'];
$sampul = $_POST['sampul'];
$box = $_POST['box'];
$jumlah = $_POST['jumlah'] ?? NULL;
$index = $_POST['arsip_index'];
$deskripsi = $_POST['deskripsi'];
$kategori = $_POST['kategori'];
$rak = isset($_POST['rak']) ? $_POST['rak'] : NULL;
$akses = isset($_POST['akses']) ? $_POST['akses'] : NULL;
$keterangan = $_POST['keterangan'];

$rand = rand();
$filename = $_FILES['file']['name'];

if ($filename == "") {
    // Update tanpa ganti file
    mysqli_query($koneksi, "
        UPDATE arsip SET 
            arsip_kode='$kode',
            arsip_nama='$nama',
            arsip_tahun='$tahun',
            arsip_sampul='$sampul',
            arsip_box='$box',
            arsip_jumlah='$jumlah',
            arsip_index='$index',
            arsip_deskripsi='$deskripsi',
            arsip_kategori='$kategori',
            arsip_rak=" . ($rak ? "'$rak'" : "NULL") . ",
            surat_akses=" . ($akses ? "'$akses'" : "NULL") . ",
            arsip_keterangan='$keterangan'
        WHERE arsip_id='$id'
    ") or die(mysqli_error($koneksi));

    header("location:arsip.php?alert=update_sukses");
    exit();

} else {
    $jenis = pathinfo($filename, PATHINFO_EXTENSION);

    if ($jenis == "php") {
        header("location:arsip.php?alert=gagal");
        exit();
    } else {
        // Hapus file lama
        $lama = mysqli_query($koneksi, "SELECT * FROM arsip WHERE arsip_id='$id'");
        $l = mysqli_fetch_assoc($lama);
        $nama_file_lama = $l['arsip_file'];
        if ($nama_file_lama && file_exists("../arsip/" . $nama_file_lama)) {
            unlink("../arsip/" . $nama_file_lama);
        }

        // Upload file baru
        $nama_file = $rand . '_' . $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $nama_file);

        // Update data + file baru
        mysqli_query($koneksi, "
            UPDATE arsip SET 
                arsip_kode='$kode',
                arsip_nama='$nama',
                arsip_tahun='$tahun',
                arsip_sampul='$sampul',
                arsip_box='$box',
                arsip_jumlah='$jumlah',
                arsip_index='$index',
                arsip_deskripsi='$deskripsi',
                arsip_kategori='$kategori',
                arsip_rak=" . ($rak ? "'$rak'" : "NULL") . ",
                surat_akses=" . ($akses ? "'$akses'" : "NULL") . ",
                arsip_keterangan='$keterangan',
                arsip_file='$nama_file'
            WHERE arsip_id='$id'
        ") or die(mysqli_error($koneksi));

        header("location:arsip.php?alert=update_sukses");
        exit();
    }
}
?>