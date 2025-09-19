<?php include 'header.php'; ?>
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Index</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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

<?php
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM `index` WHERE index_id='$id'");
$d = mysqli_fetch_assoc($data);
?>
<div class="container-fluid">
    <div class="panel panel">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Index</h3>
        </div>
        <div class="panel-body">
            <div class="pull-right">
                <a href="indek.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <br>
            <br>
            <form method="post" action="indek_update.php">
                <input type="hidden" name="id" value="<?php echo $d['index_id']; ?>">
                <div class="form-group">
                    <label>Nama Index</label>
                    <input type="text" name="index_nama" class="form-control" value="<?php echo $d['index_nama']; ?>"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>