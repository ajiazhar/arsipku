<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>User - Sistem Arsip Digital Dispusip</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.css">
    <link rel="stylesheet" href="../assets/css/owl.theme.css">
    <link rel="stylesheet" href="../assets/css/owl.transitions.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link rel="stylesheet" href="../assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/educate-custon-icon.css">
    <link rel="stylesheet" href="../assets/css/morrisjs/morris.css">
    <link rel="stylesheet" href="../assets/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="../assets/css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="../assets/css/metisMenu/metisMenu-vertical.css">
    <link rel="stylesheet" href="../assets/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../assets/css/calendar/fullcalendar.print.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=1.0.0">
    <link rel="stylesheet" href="../assets/css/custom.css?v=1.0.0">
    <link rel="stylesheet" href="../assets/css/design-upgrade.css?v=1.0.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" type="text/css" href="../assets/js/DataTables/datatables.css">

    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <?php
    session_start();
    include '../koneksi.php';

    if (!isset($_SESSION['role']) || $_SESSION['role'] != "user") {
        header("location:../index.php?alert=belum_login");
        exit;
    }
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>

</head>

<body>
    <div class="left-sidebar-pro">
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <a href="index.php"><img class="main-logo" src="../assets/img/logo/logo_dispusip.png" alt="Logo Dispusip" /></a>
                <strong><a href="index.php"><img src="../assets/img/logo/logosn.png" alt="Logo Dispusip" /></a></strong>
            </div>
            <div class="left-custom-menu-adp-wrap comment-scrollbar">

                <nav class="sidebar-nav left-sidebar-menu-pro" style="margin-top: 20px">

                    <ul class="metismenu" id="menu1">
                        <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                            <a href="index.php">
                                <span class="educate-icon educate-home icon-wrap"></span>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['arsip.php', 'arsip_preview.php']) ? 'active' : ''; ?>">
                            <a href="arsip.php">
                                <span class="educate-icon educate-course icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Data Arsip</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['kategori.php']) ? 'active' : ''; ?>">
                            <a href="kategori.php">
                                <span class="educate-icon educate-data-table icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Perkembangan</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['surat.php']) ? 'active' : ''; ?>">
                            <a href="surat.php">
                                <span class="educate-icon educate-message icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Hak Akses</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['indek.php']) ? 'active' : ''; ?>">
                            <a href="indek.php">
                                <span class="educate-icon educate-message icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Indek</span>
                            </a>
                        </li>

                        <!-- <li>
                            <a href="rak.php">
                                <span class="educate-icon educate-library icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Data Rak</span>
                            </a>
                        </li> -->

                        <!-- <li>
                            <a href="gantipassword.php" aria-expanded="false"><span
                                    class="educate-icon educate-danger icon-wrap sub-icon-mg" aria-hidden="true"></span>
                                <span class="mini-click-non">Ganti Password</span></a>
                        </li>

                        <li>
                            <a href="logout.php" aria-expanded="false"><span
                                    class="educate-icon educate-pages icon-wrap sub-icon-mg" aria-hidden="true"></span>
                                <span class="mini-click-non">Logout</span></a>
                        </li> -->

                    </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="index.php"><img class="main-logo" src="../assets/img/logo/logo.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-wraper">
                                <div class="row" style="display: flex; align-items: center; width: 100%; margin: 0; justify-content: space-between;">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="display: flex; align-items: center; gap: 14px; padding: 0;">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse"
                                                class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                <i class="educate-icon educate-nav"></i>
                                            </button>
                                        </div>
                                        <div class="header-top-menu tabl-d-n">
                                            <ul class="nav navbar-nav mai-top-nav" style="margin: 0; padding: 0;">
                                                <li class="nav-item"><a href="#" class="nav-link">Sistem Arsip Dokumen Dispusip</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" style="margin-left: auto; padding: 0; display: flex; align-items: center; justify-content: flex-end;">
                                        <div class="header-right-info" style="display: flex; align-items: center; justify-content: flex-end;">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu" style="display: flex; align-items: center; justify-content: flex-end; margin: 0;">
                                                <li class="nav-item">
                                                    <a href="#" data-toggle="dropdown" role="button"
                                                        aria-expanded="false" class="nav-link dropdown-toggle">

                                                        <?php
                                                        $id_user = $_SESSION['id'];
                                                        $profil = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id='$id_user'");
                                                        $profil = mysqli_fetch_assoc($profil);

                                                        if ($profil && $profil['user_foto'] != "") {
                                                            echo '<img src="../gambar/user/' . $profil['user_foto'] . '" style="width:20px; height:20px; border-radius:50%; object-fit:cover;">';
                                                        } else {
                                                            echo '<img src="../gambar/sistem/user.png" style="width:20px; height:20px; border-radius:50%; object-fit:cover;">';
                                                        }
                                                        ?>
                                                        <span class="admin-name"><?php echo $_SESSION['nama']; ?> [
                                                            <b>User</b> ]</span>
                                                        <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>

                                                    </a>
                                                    <ul role="menu"
                                                        class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                        <li><a href="profil.php"><span
                                                                    class="edu-icon edu-money author-log-ic"></span>Profil</a>
                                                        </li>
                                                        <li><a href="gantipassword.php"><span
                                                                    class="edu-icon edu-settings author-log-ic"></span>GantiPassword</a>
                                                        </li>
                                                        <li><a href="logout.php"><span
                                                                    class="edu-icon edu-locked author-log-ic"></span>LogOut</a>
                                                        </li>
                                                    </ul>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul class="mobile-menu-nav">
                                        <li class="active">
                                            <a href="index.php">
                                                <span class="educate-icon educate-home icon-wrap"></span>
                                                <span class="mini-click-non">Dashboard</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="arsip.php" aria-expanded="false"><span
                                                    class="educate-icon educate-data-table icon-wrap sub-icon-mg"
                                                    aria-hidden="true"></span> <span
                                                    class="mini-click-non">DataArsip</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="gantipassword.php" aria-expanded="false"><span
                                                    class="educate-icon educate-danger icon-wrap sub-icon-mg"
                                                    aria-hidden="true"></span> <span
                                                    class="mini-click-non">GantiPassword</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="logout.php" aria-expanded="false"><span
                                                    class="educate-icon educate-pages icon-wrap sub-icon-mg"
                                                    aria-hidden="true"></span> <span
                                                    class="mini-click-non">Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>