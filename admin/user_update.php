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
	$stmt = mysqli_prepare($koneksi, "UPDATE user SET user_nama=?, user_username=? WHERE user_id=?");
	mysqli_stmt_bind_param($stmt, "ssi", $nama, $username, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("Location: user.php?msg=user_edit");
} elseif ($pwd == "") {
	// Update dengan foto
	if (!in_array(strtolower($ext), $allowed)) {
		header("location:user.php?alert=gagal");
	} else {
		$newname = $rand . '_' . $filename;
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/' . $newname);
		
		// PREPARED STATEMENT
		$stmt = mysqli_prepare($koneksi, "UPDATE user SET user_nama=?, user_username=?, user_foto=? WHERE user_id=?");
		mysqli_stmt_bind_param($stmt, "sssi", $nama, $username, $newname, $id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		header("location:user.php?msg=user_edit");
	}
} elseif ($filename == "") {
	// Update dengan password - PREPARED STATEMENT
	$stmt = mysqli_prepare($koneksi, "UPDATE user SET user_nama=?, user_username=?, user_password=? WHERE user_id=?");
	mysqli_stmt_bind_param($stmt, "sssi", $nama, $username, $password, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("Location: user.php?msg=user_edit");
}

