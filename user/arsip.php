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

    <div class="panel">

        <div class="panel-heading">
            <h3 class="panel-title">Data arsip</h3>
        </div>
        <div class="panel-body">

            <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Waktu Upload</th>
                        <th>Arsip</th>
                        <th>Kategori</th>
                        <th>Petugas</th>
                        <th>Rak</th>
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
                        "SELECT a.*,
                            k.kategori_nama,
                            p.petugas_nama,
                            COALESCE(r.rak_nama, 'Belum diatur')  AS rak_nama,
                            COALESCE(sa.akses_nama, 'Belum diatur') AS akses_nama 
                            FROM arsip a
                            JOIN kategori k  ON a.arsip_kategori = k.kategori_id
                            JOIN petugas p   ON a.arsip_petugas  = p.petugas_id
                            LEFT JOIN arsip_rak r    ON a.arsip_rak   = r.rak_id
                            LEFT JOIN surat_akses sa ON a.surat_akses = sa.akses_id
                            WHERE arsip_petugas=petugas_id 
                            AND arsip_kategori=kategori_id 
                            ORDER BY arsip_id DESC"
                    );
                    while ($p = mysqli_fetch_array($arsip)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('H:i:s  d-m-Y', strtotime($p['arsip_waktu_upload'])) ?></td>
                            <td>
                                <b>KODE</b> : <?php echo $p['arsip_kode'] ?><br>
                                <b>Nama</b> : <?php echo $p['arsip_nama'] ?><br>
                                <b>Jenis</b> : <?php echo $p['arsip_jenis'] ?><br>
                            </td>
                            <td><?php echo $p['kategori_nama'] ?></td>
                            <td><?php echo $p['petugas_nama'] ?></td>
                            <td><?php echo $p['rak_nama']; ?></td>
                            <td><?php echo $p['akses_nama']; ?></td>
                            <td><?php echo $p['arsip_keterangan'] ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <!-- <a target="_blank" class="btn btn-default" href="../arsip/<?php echo $p['arsip_file']; ?>"><i class="fa fa-download"></i></a> -->
                                    <a target="_blank" class="btn btn-default"
                                        href="arsip_download.php?id=<?php echo $p['arsip_id']; ?>"><i
                                            class="fa fa-download"></i></a>
                                    <a target="_blank" href="arsip_preview.php?id=<?php echo $p['arsip_id']; ?>"
                                        class="btn btn-default"><i class="fa fa-search"></i> Preview</a>
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