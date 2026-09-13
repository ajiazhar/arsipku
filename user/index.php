<?php include 'header.php'; ?>
<?php include '../include/notif.php'; ?>

<div class="wrapper">
    <div class="content">
        <div class="breadcome-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcome-list">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="breadcome-heading">
                                        <h4 style="margin-bottom: 0px">Dashboard</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <ul class="breadcome-menu" style="padding-top: 0px">
                                        <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                        <li><span class="bread-blod">Dashboard</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-sales-area mg-tb-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="white-box analytics-info-cs res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                                    <h3 class="box-title">Total Arsip</h3>
                                    <ul class="list-inline two-part-sp">
                                        <li>
                                            <div id="sparklinedash3"></div>
                                        </li>
                                        <li class="text-right graph-three-ctn">
                                            <i class="fa fa-level-up" aria-hidden="true"></i>
                                            <span class="counter text-info">
                                                <?php
                                                $jumlah_arsip = mysqli_query($koneksi, "select count(*) as total from arsip");
                                                $c_arsip = mysqli_fetch_assoc($jumlah_arsip);
                                                ?>
                                                <span
                                                    class="counter"><?php echo $c_arsip['total']; ?></span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="white-box analytics-info-cs res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                                    <h3 class="box-title">Kategori Arsip</h3>
                                    <ul class="list-inline two-part-sp">
                                        <li>
                                            <div id="sparklinedash4"></div>
                                        </li>
                                        <li class="text-right graph-four-ctn">
                                            <i class="fa fa-level-down" aria-hidden="true"></i>
                                            <span class="text-danger">
                                                <?php
                                                $jumlah_kategori = mysqli_query($koneksi, "select count(*) as total from kategori");
                                                $c_kategori = mysqli_fetch_assoc($jumlah_kategori);
                                                ?>
                                                <span
                                                    class="counter"><?php echo $c_kategori['total']; ?></span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="product-sales-chart">
                            <br>
                            <br>
                            <center>

                                <h3>Selamat Datang</h3>
                                <h4>Sistem Arsip Dokumen Dispusip</h4>

                            </center>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php
                        $id = $_SESSION['id'];
                        $saya = mysqli_query($koneksi, "select * from user where user_id='$id'");
                        $s = mysqli_fetch_assoc($saya);
                        ?>
                        <div class="single-cards-item">
                            <div class="single-product-image">
                                <a href="#">
                                    <img src="../assets/img/product/profile-bg.jpg" alt="">
                                </a>
                            </div>

                            <div class="single-product-text">
                                <?php
                                if ($s['user_foto'] == "") {
                                    ?>
                                    <img src="../gambar/sistem/user.png" style="width:120px;height:120px;border-radius:50%;object-fit:cover;object-position:center;">
                                    <?php
                                } else {
                                    ?>
                                    <img src="../gambar/user/<?php echo $s['user_foto']; ?>"
                                        style="width:120px;height:120px;border-radius:50%;object-fit:cover;object-position:center;">
                                    <?php
                                }
                                ?>

                                <h4><a class="cards-hd-dn" href="#"><?php echo $s['user_nama']; ?></a></h4>
                                <h5>user</h5>
                                <p class="ctn-cards">Pengelolaan arsip jadi lebih mudah dengan sistem arsip digital.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>