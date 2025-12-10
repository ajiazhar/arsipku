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
                                        <div class="btn-group">
                                            <button class="btn btn-danger" onclick="hapusData(<?= $p['index_id']; ?>)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <a href="indek_edit.php?id=<?php echo $p['index_id']; ?>"
                                                class="btn btn-default"><i class="fa fa-wrench"></i></a>
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

        <script>
            function hapusData(id) {
                Swal.fire({
                    title: "Hapus data?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // arahkan ke file hapus + kirim pesan sukses
                        window.location = "indek_hapus.php?id=" + id + "&msg=index_hapus";
                    }
                });
            }
        </script>
    </div>
</div>
<?php include 'footer.php'; ?>