<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php?alert=belum_login");
    exit;
}

include '../koneksi.php';

$id = intval($_SESSION['id']);
$password = $_POST['password'] ?? '';
$confirm = $_POST['password_confirm'] ?? '';

// Validasi kekuatan password
if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
    header("Location: gantipassword.php?alert=weak");
    exit;
}

if ($password !== $confirm) {
    header("Location: gantipassword.php?alert=nomatch");
    exit;
}

// Gunakan bcrypt modern (kompatibel dengan index.php checkPassword)
$hash = password_hash($password, PASSWORD_BCRYPT);

// Update dengan prepared statement
$stmt = mysqli_prepare($koneksi, "UPDATE admin SET admin_password=? WHERE admin_id=?");
mysqli_stmt_bind_param($stmt, "si", $hash, $id);
$update = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($update) {
    header("Location: gantipassword.php?alert=sukses");
    exit;
} else {
    header("Location: gantipassword.php?alert=gagal");
    exit;
}
?>