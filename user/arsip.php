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
                            a.arsip_keterangan,
                            a.arsip_deskripsi,
                            a.arsip_file
                        FROM arsip a
                        LEFT JOIN kategori k   ON a.arsip_kategori = k.kategori_id
                        LEFT JOIN petugas p    ON a.arsip_petugas  = p.petugas_id
                        LEFT JOIN arsip_rak r  ON a.arsip_rak   = r.rak_id
                        LEFT JOIN surat_akses sa ON a.surat_akses = sa.akses_id
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
                            </td>
                            <td><?php echo $p['arsip_deskripsi'] ?></td>
                            <td><?php echo $p['kategori_nama'] ?></td>
                            <td><?php echo $p['rak_nama']; ?></td>
                            <td><?php echo $p['arsip_sampul']; ?></td>
                            <td><?php echo $p['arsip_box']; ?></td>
                            <td><?php echo $p['akses_nama']; ?></td>
                            <td><?php echo $p['arsip_keterangan'] ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a target="_blank" class="btn btn-default"
                                        href="../arsip/<?php echo $p['arsip_file']; ?>"><i class="fa fa-download"></i></a>
                                    <a target="_blank" href="arsip_preview.php?id=<?php echo $p['arsip_id']; ?>"
                                        class="btn btn-default"><i class="fa fa-search"></i> Preview</a>
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