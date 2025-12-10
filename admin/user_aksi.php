<?php
include '../koneksi.php';

$nama = $_POST['nama'];
$username = $_POST['username'];
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
	// tanpa foto
	mysqli_query($koneksi, "INSERT INTO user VALUES(NULL,'$nama','$username','$password','')");
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

		// Insert data ke database
		mysqli_query($koneksi, "INSERT INTO user VALUES(NULL,'$nama','$username','$password','$newname')");
		header("Location: user.php?msg=user_tambah");
		exit();
	}
}
?>