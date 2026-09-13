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
                                        <h4 style="margin-bottom: 0px">Data Petugas</h4>
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
            <div class="panel panel">

                <div class="panel-heading">
                    <h3 class="panel-title">Data Petugas</h3>
                </div>
                <div class="panel-body">
                    <div class="pull-right">
                        <a href="petugas_tambah.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah
                            Petugas</a>
                    </div>
                    <br>
                    <br>
                    <br>
                    <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th class="text-center" width="60px">Foto</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th class="text-center" width="10%">OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../koneksi.php';
                            $no = 1;
                            $petugas = mysqli_query($koneksi, "SELECT * FROM petugas ORDER BY petugas_id DESC");
                            while ($p = mysqli_fetch_array($petugas)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($p['petugas_foto'] == "") {
                                            ?>
                                            <img class="img-user" src="../gambar/sistem/user.png">
                                            <?php
                                        } else {
                                            ?>
                                            <img class="img-user" src="../gambar/petugas/<?php echo $p['petugas_foto']; ?>">
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $p['petugas_nama'] ?></td>
                                    <td><?php echo $p['petugas_username'] ?></td>
                                    <td class="text-center">
                                        <div class="btn-action-group">
                                            <a href="petugas_edit.php?id=<?php echo $p['petugas_id']; ?>" class="btn-action btn-action-edit" title="Edit Petugas"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0);" class="btn-action btn-action-delete" onclick="hapusData(<?= $p['petugas_id']; ?>)" title="Hapus Petugas"><i class="fa fa-trash"></i></a>
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
                        window.location = "petugas_hapus.php?id=" + id + "&msg=hapus_sukses";
                    }
                });
            }
        </script>
    </div>
</div>

<?php include 'footer.php'; ?>