<?php
include '../koneksi.php';
session_start();

$id = $_SESSION['id'];
$username = $_POST['username'];
$nama = $_POST['nama'];

$rand = rand();
$allowed = ['gif', 'png', 'jpg', 'jpeg'];

$filename = $_FILES['foto']['name'] ?? '';

if ($filename == "") {
	// Update tanpa ganti foto
	$sql = "UPDATE user 
            SET user_nama='$nama', user_username='$username' 
            WHERE user_id='$id'";
	mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
	header("Location: profil.php?alert=sukses");
	exit;
} else {
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

	if (in_array($ext, $allowed)) {
		// cek error upload
		if ($_FILES['foto']['error'] === 0) {

			// hapus foto lama kalau ada
			$lama = mysqli_query($koneksi, "SELECT user_foto FROM user WHERE user_id='$id'");
			$l = mysqli_fetch_assoc($lama);
			if (!empty($l['user_foto']) && file_exists("../gambar/user/" . $l['user_foto'])) {
				unlink("../gambar/user/" . $l['user_foto']);
			}

			// simpan foto baru
			$nama_file = $rand . '_' . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $filename); // amankan nama file
			$target = '../gambar/user/' . $nama_file;

			if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
				$sql = "UPDATE user 
                        SET user_nama='$nama', 
                            user_username='$username', 
                            user_foto='$nama_file' 
                        WHERE user_id='$id'";
				mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
				header("Location: profil.php?alert=sukses");
				exit;
			} else {
				header("Location: profil.php?alert=gagal_upload");
				exit;
			}
		} else {
			header("Location: profil.php?alert=gagal_upload");
			exit;
		}
	} else {
		header("Location: profil.php?alert=format_tidak_valid");
		exit;
	}
}
