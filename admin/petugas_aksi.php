<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$nama = trim($_POST['nama']);
$username = trim($_POST['username']);
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
	// PREPARED STATEMENT
	$stmt = mysqli_prepare($koneksi, "INSERT INTO petugas (petugas_nama, petugas_username, petugas_password, petugas_foto) VALUES (?, ?, ?, '')");
	mysqli_stmt_bind_param($stmt, "sss", $nama, $username, $password);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location:petugas.php?msg=petugas_tambah");

} else {

	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if (!in_array(strtolower($ext), $allowed)) {
		header("location:petugas_tambah.php?alert=gagal");
		exit;
	}

	$file = $rand . "_" . $filename;
	move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/petugas/' . $file);

	// PREPARED STATEMENT
	$stmt = mysqli_prepare($koneksi, "INSERT INTO petugas (petugas_nama, petugas_username, petugas_password, petugas_foto) VALUES (?, ?, ?, ?)");
	mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $password, $file);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location:petugas.php?msg=petugas_tambah");
}
?>