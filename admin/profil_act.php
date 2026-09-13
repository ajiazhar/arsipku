<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
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
    $stmt = mysqli_prepare($koneksi, "UPDATE admin SET admin_nama=?, admin_username=? WHERE admin_id=?");
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
            $stmt = mysqli_prepare($koneksi, "SELECT admin_foto FROM admin WHERE admin_id=?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $l = mysqli_fetch_assoc($res);
            mysqli_stmt_close($stmt);

            if (!empty($l['admin_foto']) && file_exists("../gambar/admin/" . $l['admin_foto'])) {
                unlink("../gambar/admin/" . $l['admin_foto']);
            }

            // Upload foto baru
            $clean_basename = preg_replace("/[^a-zA-Z0-9\-_]/", "", pathinfo($filename, PATHINFO_FILENAME));
            $nama_file = $rand . '_' . $clean_basename . '.' . $ext;
            $target = '../gambar/admin/' . $nama_file;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                $stmt = mysqli_prepare($koneksi, "UPDATE admin SET admin_nama=?, admin_username=?, admin_foto=? WHERE admin_id=?");
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
