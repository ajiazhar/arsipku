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
		"UPDATE petugas 
         SET petugas_nama='$nama', petugas_username='$username' 
         WHERE petugas_id='$id'"
	) or die(mysqli_error($koneksi));

	header("Location: profil.php?alert=sukses");
	exit;
} else {
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

	if (in_array($ext, $allowed)) {
		// cek error upload
		if ($_FILES['foto']['error'] === 0) {
			// hapus foto lama kalau ada
			$lama = mysqli_query($koneksi, "SELECT petugas_foto FROM petugas WHERE petugas_id='$id'");
			$l = mysqli_fetch_assoc($lama);

			if (!empty($l['petugas_foto']) && file_exists("../gambar/petugas/" . $l['petugas_foto'])) {
				unlink("../gambar/petugas/" . $l['petugas_foto']);
			}

			// upload file baru
			$nama_file = $rand . '_' . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $filename);
			$target = '../gambar/petugas/' . $nama_file;

			if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
				mysqli_query(
					$koneksi,
					"UPDATE petugas 
                     SET petugas_nama='$nama', 
                         petugas_username='$username', 
                         petugas_foto='$nama_file' 
                     WHERE petugas_id='$id'"
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
