<?php include 'header.php'; ?>
<?php include '../koneksi.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Edit Surat</h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="breadcome-menu" style="padding-top: 0px">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">Surat</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Surat</h3>
                </div>
                <div class="panel-body">

                    <div class="pull-right">
                        <a href="surat.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                    <br><br>

                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $data = mysqli_query($koneksi, "SELECT * FROM surat_akses WHERE akses_id='$id'");
                        if (mysqli_num_rows($data) > 0) {
                            $d = mysqli_fetch_assoc($data);
                        } else {
                            echo "<div class='alert alert-danger'>Data surat tidak ditemukan!</div>";
                            exit;
                        }
                    } else {
                        echo "<div class='alert alert-danger'>ID tidak diberikan!</div>";
                        exit;
                    }
                    ?>

                    <form method="post" action="surat_update.php">
                        <input type="hidden" name="id" value="<?= $d['akses_id']; ?>">

                        <div class="form-group">
                            <label>Nama Surat</label>
                            <input type="text" class="form-control" name="nama" required="required"
                                value="<?= htmlspecialchars($d['akses_nama']); ?>">
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3"
                                required="required"><?= htmlspecialchars($d['akses_keterangan']); ?></textarea>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>