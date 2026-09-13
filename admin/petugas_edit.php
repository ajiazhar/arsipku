<?php include 'header.php'; ?>

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
                                        <h4 style="margin-bottom: 0px">Edit Petugas</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <ul class="breadcome-menu" style="padding-top: 0px">
                                        <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                        <li><span class="bread-blod">Petugas</span></li>
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
                            <h3 class="panel-title">Edit Petugas</h3>
                        </div>
                        <div class="panel-body">

                            <div class="pull-right">
                                <a href="petugas.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                            </div>
                            <br>
                            <br>

                            <?php
                            $id = $_GET['id'];
                            $data = mysqli_query($koneksi, "select * from petugas where petugas_id='$id'");
                            while ($d = mysqli_fetch_array($data)) {
                                ?>

                                <form method="post" action="petugas_update.php" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="hidden" name="id" value="<?php echo $d['petugas_id']; ?>">
                                        <input type="text" class="form-control" name="nama" required="required"
                                            value="<?php echo $d['petugas_nama']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" required="required"
                                            value="<?php echo $d['petugas_username']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <div style="position:relative;">
                                            <input type="password" id="pass_edit" class="form-control" name="password" placeholder="Masukkan password baru jika ingin mengubah" style="padding-right: 40px;">
                                            <span onclick="togglePass('pass_edit')" style="position:absolute; right:12px; top:50%; transform: translateY(-50%); cursor:pointer; color:#64748b;">
                                                <i class="fa fa-eye" id="icon-pass_edit"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted" style="display:block; margin-top:5px;"><i class="fa fa-info-circle"></i> Kosongkan jika tidak ingin mengubah password.</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Foto</label>
                                        <input type="file" name="foto" class="form-control" style="height:auto; padding:6px 12px;">
                                        <small class="text-muted" style="display:block; margin-top:5px;"><i class="fa fa-info-circle"></i> Kosongkan jika tidak ingin mengubah foto.</small>
                                    </div>

                                    <div class="form-group" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:8px;">
                                            <i class="fa fa-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePass(id) {
        var el = document.getElementById(id);
        var icon = document.getElementById('icon-' + id);
        if (el.type === "password") {
            el.type = "text";
            if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
        } else {
            el.type = "password";
            if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
        }
    }
</script>

<?php include 'footer.php'; ?>