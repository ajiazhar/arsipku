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
                                        <h4 style="margin-bottom: 0px">Data User</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <ul class="breadcome-menu" style="padding-top: 0px">
                                        <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                        <li><span class="bread-blod">User</span></li>
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
                    <h3 class="panel-title">Data User</h3>
                </div>
                <div class="panel-body">

                    <div class="pull-right">
                        <a href="user_tambah.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah user</a>
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
                            $user = mysqli_query($koneksi, "SELECT * FROM user ORDER BY user_id DESC");
                            while ($p = mysqli_fetch_array($user)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($p['user_foto'] == "") {
                                            ?>
                                            <img class="img-user" src="../gambar/sistem/user.png">
                                            <?php
                                        } else {
                                            ?>
                                            <img class="img-user" src="../gambar/user/<?php echo $p['user_foto']; ?>">
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $p['user_nama'] ?></td>
                                    <td><?php echo $p['user_username'] ?></td>
                                    <td class="text-center">
                                        <div class="btn-action-group">
                                            <a href="user_edit.php?id=<?php echo $p['user_id']; ?>" class="btn-action btn-action-edit" title="Edit User"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0);" class="btn-action btn-action-delete" onclick="hapusData(<?= $p['user_id']; ?>)" title="Hapus User"><i class="fa fa-trash"></i></a>
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
                        window.location = "user_hapus.php?id=" + id + "&msg=user_hapus";
                    }
                });
            }
        </script>
    </div>
</div>

<?php include 'footer.php'; ?>