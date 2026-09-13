<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin - Sistem Arsip Digital Dispusip</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet"> -->
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

    if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
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

                        <li class="<?php echo in_array($current_page, ['arsip.php', 'arsip_tambah.php', 'arsip_edit.php', 'arsip_preview.php']) ? 'active' : ''; ?>">
                            <a href="arsip.php">
                                <span class="educate-icon educate-course icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Data Arsip</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['kategori.php', 'kategori_tambah.php', 'kategori_edit.php']) ? 'active' : ''; ?>">
                            <a href="kategori.php">
                                <span class="educate-icon educate-data-table icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Data Kategori</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['rak.php', 'rak_tambah.php', 'rak_edit.php']) ? 'active' : ''; ?>">
                            <a href="rak.php">
                                <span class="educate-icon educate-library icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Data Rak</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['petugas.php', 'petugas_tambah.php', 'petugas_edit.php']) ? 'active' : ''; ?>">
                            <a href="petugas.php">
                                <span class="educate-icon educate-professor icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Data Petugas</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['user.php', 'user_tambah.php', 'user_edit.php']) ? 'active' : ''; ?>">
                            <a href="user.php">
                                <span class="educate-icon educate-student icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Data User</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['surat.php', 'surat_tambah.php', 'surat_edit.php']) ? 'active' : ''; ?>">
                            <a href="surat.php">
                                <span class="educate-icon educate-message icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Surat Akses</span>
                            </a>
                        </li>

                        <li class="<?php echo in_array($current_page, ['indek.php', 'indek_tambah.php', 'indek_edit.php']) ? 'active' : ''; ?>">
                            <a href="indek.php">
                                <span class="educate-icon educate-message icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Indek</span>
                            </a>
                        </li>

                        <li class="<?php echo ($current_page == 'riwayat.php') ? 'active' : ''; ?>">
                            <a href="riwayat.php">
                                <span class="educate-icon educate-cloud icon-wrap sub-icon-mg"></span>
                                <span class="mini-click-non">Riwayat Unduh</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- End Left menu area -->
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
                                                        aria-expanded="false" class="nav-link dropdown-toggle"><i
                                                            class="educate-icon educate-bell"
                                                            aria-hidden="true"></i><span
                                                            class="indicator-nt"></span></a>
                                                    <div role="menu"
                                                        class="notification-author dropdown-menu animated zoomIn">
                                                        <div class="notification-single-top">
                                                            <h1>Riwayat unduh terakhir</h1>
                                                        </div>
                                                        <ul class="notification-menu">
                                                            <?php
                                                            $arsip = mysqli_query($koneksi, "SELECT * FROM riwayat,arsip,user WHERE riwayat_arsip=arsip_id and riwayat_user=user_id ORDER BY riwayat_id DESC LIMIT 5");
                                                            while ($p = mysqli_fetch_array($arsip)) {
                                                                ?>
                                                                <li>
                                                                    <a href="riwayat.php">
                                                                        <div class="notification-content">
                                                                            <p>
                                                                                <small><i><?php echo date('H:i:s  d-m-Y', strtotime($p['riwayat_waktu'])) ?></i></small>
                                                                                <br>
                                                                                <b><?php echo $p['user_nama'] ?></b>
                                                                                menunduh
                                                                                <b><?php echo $p['arsip_nama'] ?></b>.
                                                                            </p>
                                                                        </div>
                                                                    </a>
                                                                    <hr>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                        <div class="notification-view">
                                                            <a href="riwayat.php">Lihat semua riwayat</a>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="#" data-toggle="dropdown" role="button"
                                                        aria-expanded="false" class="nav-link dropdown-toggle">
                                                        <?php
                                                        $id_admin = $_SESSION['id'];
                                                        $profil = mysqli_query($koneksi, "select * from admin where admin_id='$id_admin'");
                                                        $profil = mysqli_fetch_assoc($profil);
                                                        if ($profil['admin_foto'] == "") {
                                                            ?>
                                                            <img src="../gambar/sistem/user.png"
                                                                style="width:20px; height:20px; border-radius:50%; object-fit:cover;">
                                                        <?php } else { ?>
                                                            <img src="../gambar/admin/<?php echo $profil['admin_foto'] ?>"
                                                                style="width:20px; height:20px; border-radius:50%; object-fit:cover;">
                                                        <?php } ?>
                                                        <span class="admin-name"><?php echo $_SESSION['nama']; ?> [
                                                            <b>Administrator</b> ]</span>
                                                        <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                                    </a>
                                                    <ul role="menu"
                                                        class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                        <li><a href="profil.php"><span
                                                                    class="edu-icon edu-home-admin author-log-ic"></span>Profil
                                                                Saya</a></li>
                                                        <li><a href="gantipassword.php"><span
                                                                    class="edu-icon edu-user-rounded author-log-ic"></span>Ganti
                                                                Password</a></li>
                                                        <li><a href="logout.php"><span
                                                                    class="edu-icon edu-locked author-log-ic"></span>Log
                                                                Out</a></li>
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
                                        <li class="<?php echo in_array($current_page, ['kategori.php', 'kategori_tambah.php', 'kategori_edit.php']) ? 'active' : ''; ?>">
                                            <a href="kategori.php">
                                                <span class="educate-icon educate-data-table icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Data Kategori</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo in_array($current_page, ['rak.php', 'rak_tambah.php', 'rak_edit.php']) ? 'active' : ''; ?>">
                                            <a href="rak.php">
                                                <span class="educate-icon educate-library icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Data Rak</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo in_array($current_page, ['surat.php', 'surat_tambah.php', 'surat_edit.php']) ? 'active' : ''; ?>">
                                            <a href="surat.php">
                                                <span class="educate-icon educate-message icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Surat Akses</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo in_array($current_page, ['indek.php', 'indek_tambah.php', 'indek_edit.php']) ? 'active' : ''; ?>">
                                            <a href="indek.php">
                                                <span class="educate-icon educate-message icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Indek</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo in_array($current_page, ['petugas.php', 'petugas_tambah.php', 'petugas_edit.php']) ? 'active' : ''; ?>">
                                            <a href="petugas.php">
                                                <span class="educate-icon educate-professor icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Data Petugas</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo in_array($current_page, ['user.php', 'user_tambah.php', 'user_edit.php']) ? 'active' : ''; ?>">
                                            <a href="user.php">
                                                <span class="educate-icon educate-student icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Data User</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo ($current_page == 'riwayat.php') ? 'active' : ''; ?>">
                                            <a href="riwayat.php">
                                                <span class="educate-icon educate-cloud icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Riwayat Unduh</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo ($current_page == 'gantipassword.php') ? 'active' : ''; ?>">
                                            <a href="gantipassword.php">
                                                <span class="educate-icon educate-settings icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Ganti Password</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="logout.php">
                                                <span class="educate-icon educate-pages icon-wrap sub-icon-mg"></span>
                                                <span class="mini-click-non">Logout</span>
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