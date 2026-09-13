<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}
include '../koneksi.php';

// Validasi input
$id = intval($_POST['id']);
$nama = trim($_POST['nama']);
$username = trim($_POST['username']);
$pwd = $_POST['password'];
$password = md5($_POST['password']);

// cek gambar
$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if ($pwd == "" && $filename == "") {
	// Update tanpa password dan foto - PREPARED STATEMENT
	$stmt = mysqli_prepare($koneksi, "UPDATE petugas SET petugas_nama=?, petugas_username=? WHERE petugas_id=?");
	mysqli_stmt_bind_param($stmt, "ssi", $nama, $username, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("Location: petugas.php?msg=petugas_edit");
} elseif ($pwd == "") {
	// Update dengan foto
	if (!in_array(strtolower($ext), $allowed)) {
		header("location:petugas.php?alert=gagal");
	} else {
		$newname = $rand . '_' . $filename;
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/petugas/' . $newname);
		
		// PREPARED STATEMENT
		$stmt = mysqli_prepare($koneksi, "UPDATE petugas SET petugas_nama=?, petugas_username=?, petugas_foto=? WHERE petugas_id=?");
		mysqli_stmt_bind_param($stmt, "sssi", $nama, $username, $newname, $id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		header("location:petugas.php?msg=petugas_edit");
	}
} elseif ($filename == "") {
	// Update dengan password - PREPARED STATEMENT
	$stmt = mysqli_prepare($koneksi, "UPDATE petugas SET petugas_nama=?, petugas_username=?, petugas_password=? WHERE petugas_id=?");
	mysqli_stmt_bind_param($stmt, "sssi", $nama, $username, $password, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location:petugas.php?msg=petugas_edit");
}

