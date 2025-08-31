<?php
session_start();
include "koneksi.php"; // sesuaikan path koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // kalau di DB pakai md5, kalau plaintext hapus md5()

    // cek admin
    $q = mysqli_query($koneksi, "SELECT * FROM admin 
    WHERE admin_username='$username' 
    AND admin_password='$password'");

    if (mysqli_num_rows($q) > 0) {
        $d = mysqli_fetch_assoc($q);
        $_SESSION['id'] = $d['admin_id'];
        $_SESSION['nama'] = $d['admin_nama'];
        $_SESSION['role'] = "admin";
        header("Location: admin/index.php");
        exit;
    }


    $q = mysqli_query($koneksi, "SELECT * FROM petugas 
    WHERE petugas_username='$username' 
    AND petugas_password='$password'");

    if (mysqli_num_rows($q) > 0) {
        $d = mysqli_fetch_assoc($q);
        $_SESSION['id'] = $d['petugas_id'];
        $_SESSION['nama'] = $d['petugas_nama'];
        $_SESSION['role'] = "petugas";
        header("Location: petugas/index.php");
        exit;
    }


    // cek user
    $q = mysqli_query($koneksi, "SELECT * FROM user 
    WHERE user_username='$username' 
    AND user_password='$password'");

    if (mysqli_num_rows($q) > 0) {
        $d = mysqli_fetch_assoc($q);
        $_SESSION['id'] = $d['user_id'];
        $_SESSION['nama'] = $d['user_nama'];
        $_SESSION['role'] = "user";
        header("Location: user/index.php");
        exit;
    }


    // kalau semua gagal
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Sistem Arsip Digital</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        .login-box {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 5px #aaa;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login Arsip</h2>
        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>