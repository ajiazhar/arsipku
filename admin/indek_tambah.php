<?php include 'header.php'; ?>
<!-- <div class="content-wrapper"> -->
<div class="wrapper">
    <div class="content">
        <div class="breadcome-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcome-list">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="breadcome-heading">
                                        <h4 style="margin-bottom: 0px">Tambah Index</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="breadcome-menu" style="padding-top: 0px">
                                        <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                        <li><span class="bread-blod">Index</span></li>
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
                            <h3 class="panel-title">Tambah Index</h3>
                        </div>
                        <div class="panel-body">
                            <div class="pull-right">
                                <a href="indek.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                            <br>
                            <br>
                            <form method="post" action="indek_aksi.php">
                                <div class="form-group">
                                    <label>Nama Index</label>
                                    <input type="text" name="index_nama" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>