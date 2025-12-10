<?php
include '../koneksi.php';
session_start();

$id = $_SESSION['id'];

$password = $_POST['password'];
$confirm = $_POST['password_confirm'];

// validasi server-side agar tidak hanya bergantung pada JS
if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
    header("Location: gantipassword.php?alert=weak");
    exit;
}

if ($password != $confirm) {
    header("Location: gantipassword.php?alert=nomatch");
    exit;
}

// enkripsi password (disarankan bcrypt, tapi mengikuti sistem awal md5)
$hash = md5($password);

// update ke database
$update = mysqli_query(
    $koneksi,
    "UPDATE user SET user_password='$hash' WHERE user_id='$id'"
);

if ($update) {
    header("Location: gantipassword.php?alert=sukses");

    exit;
} else {
    die("Gagal update password: " . mysqli_error($koneksi));
}
?>