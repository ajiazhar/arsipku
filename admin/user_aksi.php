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
$password = $_POST['password']; // ambil mentah dulu untuk validasi

// --- Validasi Password ---
if (
	strlen($password) < 8 ||
	!preg_match("/[0-9]/", $password) ||
	!preg_match("/[A-Za-z]/", $password)
) {
	header("Location: user_tambah.php?alert=weak");
	exit();
}

$password = md5($password); // encrypt setelah validasi

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];

if ($filename == "") {
	// tanpa foto - PREPARED STATEMENT
	$stmt = mysqli_prepare($koneksi, "INSERT INTO user (user_nama, user_username, user_password, user_foto) VALUES (?, ?, ?, '')");
	mysqli_stmt_bind_param($stmt, "sss", $nama, $username, $password);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("Location: user.php?msg=user_tambah");
	exit();

} else {

	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	// Validasi format foto
	if (!in_array(strtolower($ext), $allowed)) {
		header("Location: user_tambah.php?msg=gambar_gagal");
		exit();
	} else {

		// Upload file
		$newname = $rand . '_' . $filename;
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/' . $newname);

		// Insert data ke database - PREPARED STATEMENT
		$stmt = mysqli_prepare($koneksi, "INSERT INTO user (user_nama, user_username, user_password, user_foto) VALUES (?, ?, ?, ?)");
		mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $password, $newname);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		header("Location: user.php?msg=user_tambah");
		exit();
	}
}
?>