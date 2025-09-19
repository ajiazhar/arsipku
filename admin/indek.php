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
            <h3 class="panel-title">Index</h3>
        </div>
        <div class="panel-body">
            <div class="pull-right">
                <a href="indek_tambah.php" class="btn btn-primary"><i class="fa fa-plus"></i>Tambah Index</a>
            </div>
            <br>
            <br>
            <br>
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
                    while ($p = mysqli_fetch_array($data)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $p['index_nama']; ?></td>

                            <td class="text-center">
                                <div class="modal fade" id="exampleModal_<?php echo $p['index_id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">PERINGATAN!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus data ini? <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batalkan</button>
                                                <a href="indek_hapus.php?id=<?php echo $p['index_id']; ?>"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-check"></i> &nbsp; Ya, hapus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <a href="indek_edit.php?id=<?php echo $p['index_id']; ?>" class="btn btn-default"><i
                                            class="fa fa-wrench"></i></a>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal_<?php echo $p['index_id']; ?>">
                                        <i class="fa fa-trash"></i>
                                </div>

                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>