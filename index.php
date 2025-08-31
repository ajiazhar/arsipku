<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login User | Sistem Informasi Arsip Digital</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.theme.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/morrisjs/morris.css">
    <link rel="stylesheet" href="assets/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="assets/css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="assets/css/metisMenu/metisMenu-vertical.css">
    <link rel="stylesheet" href="assets/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/calendar/fullcalendar.print.min.css">
    <link rel="stylesheet" href="assets/css/form/all-type-forms.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <div class="error-pagewrap">
        <div class="error-page-int">
            <div class="text-center m-b-md custom-login">
                <h3>SISTEM INFORMASI</h3>
                <h4>ARSIP DIGITAL</h4>

                <!-- <br>

                <p>Silahkan login untuk mengakses arsip.</p> -->

            </div>
            <div class="content-error">
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
                <div class="hpanel">
                    <div class="panel-body">

                        <!-- <br>
                        <br>
                        <center>
                            <h4>LOGIN USER</h4>    
                        </center>
                        <br>
                        <br> -->
                        <center>
                            <img class="main-logo" src="assets/img/logo/logo_dispusip.png" alt=""
                                style="width: 170px; height: 100px;" />
                        </center>
                        <br>

                        <form action="index.php" method="POST" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="username" title="Please enter your username"
                                    required="required" autocomplete="off" name="username" id="username"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******"
                                    required="required" autocomplete="off" name="password" id="password"
                                    class="form-control">
                            </div>
                            <input type="submit" class="btn btn-success btn-block loginbtn" value="Login">
                        </form>

                        <br>
                    </div>
                </div>
                <!-- <br>
                <a href="index.php">Kembali</a>
                <br> -->
            </div>
            <div class="text-center login-footer">
                <p class="text-muted">Copyright © <?php echo date('Y') ?>. All rights reserved. Sistem Informasi Arsip
                    Digital (SIAD)</p>
            </div>
        </div>
    </div>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery-price-slider.js"></script>
    <script src="assets/js/jquery.meanmenu.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.sticky.js"></script>
    <script src="assets/js/jquery.scrollUp.min.js"></script>
    <script src="assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="assets/js/scrollbar/mCustomScrollbar-active.js"></script>
    <script src="assets/js/metisMenu/metisMenu.min.js"></script>
    <script src="assets/js/metisMenu/metisMenu-active.js"></script>
    <script src="assets/js/tab.js"></script>
    <script src="assets/js/icheck/icheck.min.js"></script>
    <script src="assets/js/icheck/icheck-active.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>

    <body class="hold-transition login-page" style="background:url(gambar/depan/bg.jpg)
no-repeat center center fixed; background-size: cover;
 -webkit-background-size: cover; 
 -moz-background-size: cover; -o-background-size: cover;">
    </body>

</html>