<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'petugas') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}

include '../koneksi.php';

$id = intval($_SESSION['id']);
$username = trim($_POST['username'] ?? '');
$nama = trim($_POST['nama'] ?? '');

$rand = rand();
$allowed = ['gif', 'png', 'jpg', 'jpeg'];
$filename = $_FILES['foto']['name'] ?? '';

if (empty($filename)) {
    // Update tanpa ganti foto - PREPARED STATEMENT
    $stmt = mysqli_prepare($koneksi, "UPDATE petugas SET petugas_nama=?, petugas_username=? WHERE petugas_id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $nama, $username, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['nama'] = $nama;
    header("Location: profil.php?msg=profile_edit");
    exit;
} else {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        if ($_FILES['foto']['error'] === 0 && $_FILES['foto']['size'] <= 5 * 1024 * 1024) {
            // Ambil foto lama untuk dihapus
            $stmt = mysqli_prepare($koneksi, "SELECT petugas_foto FROM petugas WHERE petugas_id=?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $l = mysqli_fetch_assoc($res);
            mysqli_stmt_close($stmt);

            if (!empty($l['petugas_foto']) && file_exists("../gambar/petugas/" . $l['petugas_foto'])) {
                unlink("../gambar/petugas/" . $l['petugas_foto']);
            }

            // Upload foto baru
            $clean_basename = preg_replace("/[^a-zA-Z0-9\-_]/", "", pathinfo($filename, PATHINFO_FILENAME));
            $nama_file = $rand . '_' . $clean_basename . '.' . $ext;
            $target = '../gambar/petugas/' . $nama_file;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                $stmt = mysqli_prepare($koneksi, "UPDATE petugas SET petugas_nama=?, petugas_username=?, petugas_foto=? WHERE petugas_id=?");
                mysqli_stmt_bind_param($stmt, "sssi", $nama, $username, $nama_file, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $_SESSION['nama'] = $nama;
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
?>
