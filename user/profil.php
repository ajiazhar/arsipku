<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Profil</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu" style="padding-top: 0px">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">Profil</span></li>
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

            <div class="col-lg-3">

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
                            <img class="img-user" src="../gambar/sistem/user.png" style="object-fit:cover">
                            <?php
                        } else {
                            ?>
                            <img class="img-user" src="../gambar/user/<?php echo $s['user_foto']; ?>"
                                style="object-fit:cover">
                            <?php
                        }
                        ?>

                        <h4><a class="cards-hd-dn" href="#"><?php echo $s['user_nama']; ?></a></h4>
                        <h5>user</h5>
                        <p class="ctn-cards">Pengelolaan arsip jadi lebih mudah dengan sistem informasi arsip digital.
                        </p>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">

                <?php
                if (isset($_GET['alert'])) {
                    if ($_GET['alert'] == "sukses") {
                        echo "<div class='alert alert-success'>Profil berhasil diperbarui!</div>";
                    } elseif ($_GET['alert'] == "hapus_sukses") {
                        echo "<div class='alert alert-warning'>Foto profil berhasil dihapus!</div>";
                    } elseif ($_GET['alert'] == "gagal_upload") {
                        echo "<div class='alert alert-danger'>Gagal mengunggah foto!</div>";
                    } elseif ($_GET['alert'] == "format_tidak_valid") {
                        echo "<div class='alert alert-danger'>Format file tidak valid! (hanya gif/png/jpg/jpeg)</div>";
                    }
                }
                ?>

                <div class="panel">
                    <div class="panel-heading">
                        <h4>Data Diri</h4>
                    </div>
                    <div class="panel-body">

                        <form action="profil_act.php" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama .." name="nama"
                                    required="required" value="<?php echo $s['user_nama'] ?>">
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="Masukkan Username .."
                                    name="username" required="required" value="<?php echo $s['user_username'] ?>">
                            </div>

                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto">
                                <small>Kosongkan jika tidak ingin mengubah foto.</small>
                            </div>

                            <div> <?php if (!empty($s['user_foto']) && $s['user_foto'] != ''): ?>
                                    <a href="profil_hapus_foto.php?id=<?php echo $s['user_id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus foto profil?')">
                                        <i class="fa fa-trash"></i> Hapus Foto
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Simpan">
                            </div>

                        </form>

                    </div>
                </div>

            </div>



        </div>
    </div>
</div>


<?php include 'footer.php'; ?>