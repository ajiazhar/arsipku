<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Data Arsip</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu" style="padding-top: 0px">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">Arsip</span></li>
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
            <h3 class="panel-title">Data Arsip Saya</h3>
        </div>
        <div class="panel-body">


            <div class="pull-left" style="margin-bottom:10px;">
                <!-- Upload Arsip -->
                <a href="arsip_tambah.php" class="btn btn-primary" style="margin-right:5px;">
                    <i class="fa fa-cloud"></i> Upload Arsip
                </a>

                <!-- Import Excel -->
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                    <i class="fa fa-upload"></i> Import Excel
                </a>
            </div>

            <br>
            <br>
            <br>

            <!-- Modal Import -->
            <div class="modal fade" id="importModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="import_excel.php" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Import Data Arsip dari Excel</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <label>Pilih file Excel (.xlsx / .xls)</label>
                                <input type="file" name="file_excel" class="form-control" accept=".xls,.xlsx" required>
                                <small class="text-muted">Pastikan format sesuai template yang sudah ditentukan.</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <br>

            <center>
                <?php
                if (isset($_GET['alert'])) {
                    if ($_GET['alert'] == "gagal") {
                        ?>
                        <div class="alert alert-danger">File arsip gagal diupload. krena demi keamanan file .php tidak
                            diperbolehkan.</div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-success">Arsip berhasil tersimpan.</div>
                        <?php
                    }
                }
                ?>
            </center>
            <!-- Table -->
            <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <!-- <th>Waktu Upload</th> -->
                        <th>Tahun</th>
                        <th>Arsip</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <!-- <th>Petugas</th> -->
                        <th>Rak</th>
                        <th>Sampul</th>
                        <th>Box</th>
                        <th>Akses</th>
                        <th>Keterangan</th>
                        <th class="text-center" width="20%">OPSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $id_petugas = $_SESSION['id'];
                    $arsip = mysqli_query(
                        $koneksi,
                        "SELECT 
                            a.arsip_id,
                            a.arsip_tahun,
                            a.arsip_kode,
                            a.arsip_nama,
                            k.kategori_nama,
                            p.petugas_nama,
                            COALESCE(r.rak_nama, 'Belum diatur') AS rak_nama,
                            a.arsip_sampul,
                            a.arsip_box,
                            COALESCE(sa.akses_nama, 'Belum diatur') AS akses_nama,
                            COALESCE(i.index_nama, 'Belum diatur') AS index_nama,  -- ✅ pakai i.index_nama, bukan a.index_nama
                            a.arsip_jumlah,
                            a.arsip_keterangan,
                            a.arsip_deskripsi,
                            a.arsip_file
                        FROM arsip a
                        LEFT JOIN kategori k     ON a.arsip_kategori = k.kategori_id
                        LEFT JOIN petugas p      ON a.arsip_petugas  = p.petugas_id
                        LEFT JOIN arsip_rak r    ON a.arsip_rak      = r.rak_id
                        LEFT JOIN surat_akses sa ON a.surat_akses    = sa.akses_id
                        LEFT JOIN `index` i      ON a.arsip_index    = i.index_id
                         WHERE a.arsip_petugas = '$id_petugas'
                        ORDER BY a.arsip_id DESC"
                    );


                    while ($p = mysqli_fetch_array($arsip)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?= $p['arsip_tahun'] ? $p['arsip_tahun'] : 'Belum diatur'; ?></td>
                            <td>
                                <b>KODE</b> : <?php echo $p['arsip_kode'] ?><br>
                                <b>Nama</b> : <?php echo $p['arsip_nama'] ?><br>
                                <b>Jumlah</b> : <?php echo $p['arsip_jumlah'] ?><br>
                                <b>index</b> : <?php echo $p['index_nama'] ?><br>
                            </td>
                            <td><?php echo $p['arsip_deskripsi'] ?></td>
                            <td><?php echo $p['kategori_nama'] ?></td>
                            <td><?php echo $p['rak_nama']; ?></td>
                            <td><?php echo $p['arsip_sampul']; ?></td>
                            <td><?php echo $p['arsip_box']; ?></td>
                            <td><?php echo $p['akses_nama']; ?></td>
                            <td><?php echo $p['arsip_keterangan'] ?></td>
                            <td class="text-center">



                                <div class="modal fade" id="exampleModal_<?php echo $p['arsip_id']; ?>" tabindex="-1"
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
                                                Apakah anda yakin ingin menghapus data ini? <br>file dan semua yang
                                                berhubungan akan dihapus secara permanen.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batalkan</button>
                                                <a href="arsip_hapus.php?id=<?php echo $p['arsip_id']; ?>"
                                                    class="btn btn-primary"><i class="fa fa-check"></i> &nbsp; Ya, hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="btn-group">
                                    <a target="_blank" class="btn btn-default"
                                        href="../arsip/<?php echo $p['arsip_file']; ?>"><i class="fa fa-download"></i></a>
                                    <a target="_blank" href="arsip_preview.php?id=<?php echo $p['arsip_id']; ?>"
                                        class="btn btn-default"><i class="fa fa-search"></i> Preview</a>
                                    <a href="arsip_edit.php?id=<?php echo $p['arsip_id']; ?>" class="btn btn-default"><i
                                            class="fa fa-wrench"></i></a>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal_<?php echo $p['arsip_id']; ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
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