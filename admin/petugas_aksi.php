<?php
include '../koneksi.php';

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];

// Validasi server (backup dari JS)
if (strlen($password) < 8 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/\d/", $password)) {
	header("location:petugas_tambah.php?alert=weak");
	exit;
}

$password = md5($password);

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];

if ($filename == "") {
	mysqli_query($koneksi, "INSERT INTO petugas VALUES(NULL,'$nama','$username','$password','')");
	header("location:petugas.php?msg=petugas_tambah");

} else {

	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if (!in_array($ext, $allowed)) {
		header("location:petugas_tambah.php?alert=gagal");
		exit;
	}

	$file = $rand . "_" . $filename;
	move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/petugas/' . $file);

	mysqli_query($koneksi, "INSERT INTO petugas VALUES(NULL,'$nama','$username','$password','$file')");
	header("location:petugas.php?msg=petugas_tambah");
}
?>