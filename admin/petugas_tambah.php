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
                                        <h4 style="margin-bottom: 0px">Tambah Petugas</h4>
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
                            <h3 class="panel-title">Tambah Petugas</h3>
                        </div>
                        <div class="panel-body">

                            <div class="pull-right">
                                <a href="petugas.php" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                            </div>

                            <br>
                            <br>

                            <form method="post" action="petugas_aksi.php" enctype="multipart/form-data" onsubmit="return cekPassword()">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" required="required" placeholder="Nama lengkap">
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" required="required" placeholder="Username">
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <div style="position:relative;">
                                        <input type="password" id="pass1" name="password" class="form-control" placeholder="Masukkan password" required style="padding-right: 40px;">
                                        <span onclick="togglePass('pass1')" style="position:absolute; right:12px; top:50%; transform: translateY(-50%); cursor:pointer; color:#64748b;">
                                            <i class="fa fa-eye" id="icon-pass1"></i>
                                        </span>
                                    </div>
                                    <small class="text-muted" style="display:block; margin-top:5px;"><i class="fa fa-info-circle"></i> Min. 8 karakter, kombinasi huruf & angka</small>
                                </div>

                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" name="foto" class="form-control" style="height:auto; padding:6px 12px;">
                                </div>

                                <div class="form-group" style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:8px;">
                                        <i class="fa fa-save"></i> Simpan Petugas
                                    </button>
                                </div>
                            </form>
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

    function cekPassword() {
        var pass = document.getElementById('pass1').value;
        var regex = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;

        if (!regex.test(pass)) {
            Swal.fire({
                icon: 'warning',
                title: 'Password Kurang Kuat',
                text: 'Password minimal 8 karakter dan harus mengandung kombinasi huruf dan angka!'
            });
            return false;
        }
        return true;
    }
</script>

<?php include 'footer.php'; ?>