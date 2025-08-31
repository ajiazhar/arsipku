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
	// update tanpa ganti foto
	mysqli_query(
		$koneksi,
		"UPDATE admin 
         SET admin_nama='$nama', admin_username='$username' 
         WHERE admin_id='$id'"
	) or die(mysqli_error($koneksi));

	header("Location: profil.php?alert=sukses");
	exit;
} else {
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

	if (in_array($ext, $allowed)) {
		if ($_FILES['foto']['error'] === 0) {
			// hapus foto lama kalau ada
			$lama = mysqli_query($koneksi, "SELECT admin_foto FROM admin WHERE admin_id='$id'");
			$l = mysqli_fetch_assoc($lama);

			if (!empty($l['admin_foto']) && file_exists("../gambar/admin/" . $l['admin_foto'])) {
				unlink("../gambar/admin/" . $l['admin_foto']);
			}

			// upload file baru
			$nama_file = $rand . '_' . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $filename);
			$target = '../gambar/admin/' . $nama_file;

			if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
				mysqli_query(
					$koneksi,
					"UPDATE admin 
                     SET admin_nama='$nama', 
                         admin_username='$username', 
                         admin_foto='$nama_file' 
                     WHERE admin_id='$id'"
				) or die(mysqli_error($koneksi));

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
