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
<div class="container-fluid">
    <div class="panel panel">
        <div class="panel-heading">
            <h3 class="panel-title">Data Index</h3>
        </div>
        <div class="panel-body">
            <a href="indek_tambah.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Index</a>
            <br><br>
            <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Nama Index</th>
                        <th width="20%">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $no = 1;
                    $data = mysqli_query($koneksi, "SELECT * FROM `index` ORDER BY index_nama ASC");
                    while ($d = mysqli_fetch_array($data)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['index_nama']; ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="indek_edit.php?id=<?php echo $d['index_id']; ?>"><i
                                        class="fa fa-edit"></i> Edit</a>
                                <a class="btn btn-danger btn-sm" href="indek_hapus.php?id=<?php echo $d['index_id']; ?>"
                                    onclick="return confirm('Yakin hapus index ini?');"><i class="fa fa-trash"></i>
                                    Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>