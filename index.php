<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login | Sistem Informasi Arsip Digital</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
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
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/design-upgrade.css">

    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body class="hold-transition login-page">
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
                    $username  = trim($_POST['username']);
                    $plainPass = $_POST['password'];

                    // Helper: cocokkan password dengan bcrypt ATAU md5 (legacy)
                    function checkPassword($plain, $hash) {
                        if (password_verify($plain, $hash)) return true;          // bcrypt
                        if (md5($plain) === $hash)           return true;          // md5 legacy
                        return false;
                    }

                    // --- cek admin ---
                    $stmt = mysqli_prepare($koneksi, "SELECT admin_id, admin_nama, admin_password FROM admin WHERE admin_username=?");
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        if (checkPassword($plainPass, $row['admin_password'])) {
                            session_regenerate_id(true);
                            $_SESSION['id']   = $row['admin_id'];
                            $_SESSION['nama'] = $row['admin_nama'];
                            $_SESSION['role'] = "admin";
                            mysqli_stmt_close($stmt);
                            header("Location: admin/index.php");
                            exit;
                        }
                    }
                    mysqli_stmt_close($stmt);

                    // --- cek petugas ---
                    $stmt = mysqli_prepare($koneksi, "SELECT petugas_id, petugas_nama, petugas_password FROM petugas WHERE petugas_username=?");
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        if (checkPassword($plainPass, $row['petugas_password'])) {
                            session_regenerate_id(true);
                            $_SESSION['id']   = $row['petugas_id'];
                            $_SESSION['nama'] = $row['petugas_nama'];
                            $_SESSION['role'] = "petugas";
                            mysqli_stmt_close($stmt);
                            header("Location: petugas/index.php");
                            exit;
                        }
                    }
                    mysqli_stmt_close($stmt);

                    // --- cek user ---
                    $stmt = mysqli_prepare($koneksi, "SELECT user_id, user_nama, user_password FROM user WHERE user_username=?");
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        if (checkPassword($plainPass, $row['user_password'])) {
                            session_regenerate_id(true);
                            $_SESSION['id']   = $row['user_id'];
                            $_SESSION['nama'] = $row['user_nama'];
                            $_SESSION['role'] = "user";
                            mysqli_stmt_close($stmt);
                            header("Location: user/index.php");
                            exit;
                        }
                    }
                    mysqli_stmt_close($stmt);

                    // semua gagal
                    $error = "Username atau password salah!";
                }
                ?>
                <div class="hpanel">
                    <div class="panel-body">
                        <div style="display:flex; justify-content:center; align-items:center; margin-bottom: 20px;">
                            <img class="main-logo" src="assets/img/logo/logo_dispusip.png" alt="Logo Dispusip" style="max-width: 180px; height: auto; object-fit: contain;" />
                        </div>

                        <form action="index.php" method="POST" id="loginForm">
                            <?php if (!empty($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fa fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="Masukkan username" title="Please enter your username"
                                    required="required" autocomplete="off" name="username" id="username"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <div style="position:relative;">
                                    <input type="password" title="Please enter your password" placeholder="Masukkan password"
                                        required="required" autocomplete="off" name="password" id="password"
                                        class="form-control" style="padding-right: 40px;">
                                    <span onclick="toggleLoginPass()" style="position:absolute; right:12px; top:50%; transform: translateY(-50%); cursor:pointer; color:#64748b;">
                                        <i class="fa fa-eye" id="icon-login-pass"></i>
                                    </span>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success btn-block loginbtn" value="Login">
                        </form>

                        <br>
                    </div>
                </div>
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

    <script>
        function toggleLoginPass() {
            var el = document.getElementById('password');
            var icon = document.getElementById('icon-login-pass');
            if (el.type === "password") {
                el.type = "text";
                if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
            } else {
                el.type = "password";
                if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
            }
        }
    </script>
</body>
</html>