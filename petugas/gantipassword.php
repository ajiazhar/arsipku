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
                                        <h4 style="margin-bottom: 0px">Ganti Password</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <ul class="breadcome-menu" style="padding-top: 0px">
                                        <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                        <li><span class="bread-blod">Ganti Password</span></li>
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
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel">

                        <div class="panel-heading">
                            <h3 class="panel-title">Ganti Password</h3>
                        </div>

                        <div class="panel-body">

                            <form action="gantipassword_act.php" method="post">
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <div style="position:relative;">
                                        <input type="password" id="pass1" name="password" class="form-control" required>
                                        <span onclick="togglePass('pass1')"
                                            style="position:absolute; right:10px; top:10px; cursor:pointer;">👁</span>
                                    </div>
                                    <small>Min 8 karakter, kombinasi huruf & angka</small>
                                </div>

                                <div class="form-group">
                                    <label>Konfirmasi Password Baru</label>
                                    <div style="position:relative;">
                                        <input type="password" id="pass2" name="password_confirm" class="form-control"
                                            required>
                                        <span onclick="togglePass('pass2')"
                                            style="position:absolute; right:10px; top:10px; cursor:pointer;">👁</span>
                                    </div>
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
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<script>
    // Show/Hide Password
    function togglePass(id) {
        let el = document.getElementById(id);
        el.type = (el.type === "password") ? "text" : "password";
    }

    // Validasi password
    function validatePassword() {
        let p1 = document.getElementById("pass1").value;
        let p2 = document.getElementById("pass2").value;

        if (p1.length < 8) {
            alert("Password harus minimal 8 karakter!");
            return false;
        }
        if (!/[A-Za-z]/.test(p1) || !/[0-9]/.test(p1)) {
            alert("Password harus mengandung huruf dan angka!");
            return false;
        }
        if (p1 !== p2) {
            alert("Konfirmasi password tidak sama!");
            return false;
        }
        return true;
    }
</script>

<?php include 'footer.php'; ?>