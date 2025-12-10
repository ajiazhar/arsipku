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

                            <form method="post" action="petugas_aksi.php" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" required="required">
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" required="required">
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Masukkan Password Baru</label>
                                        <div style="position:relative;">
                                            <input type="password" id="pass1" name="password" class="form-control"
                                                required>
                                            <span onclick="togglePass('pass1')"
                                                style="position:absolute; right:10px; top:10px; cursor:pointer;">👁</span>
                                        </div>
                                        <small>Min 8 karakter, kombinasi huruf & angka</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Foto</label>
                                        <input type="file" name="foto">
                                    </div>

                                    <div class="form-group">
                                        <label></label>
                                        <input type="submit" class="btn btn-primary" value="Simpan">
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
    // Toggle password show/hide
    function togglePass(id) {
        let el = document.getElementById(id);
        el.type = (el.type === "password") ? "text" : "password";
    }

    function cekPassword() {
        let pass = document.getElementById('password').value;
        let regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (!regex.test(pass)) {
            alert("Password harus minimal 8 karakter & terdapat huruf + angka!");
            return false;
        }
        return true;
    }

    function togglePassword() {
        let input = document.getElementById("password");
        input.type = (input.type === "password") ? "text" : "password";
    }
</script>

<?php include 'footer.php'; ?>