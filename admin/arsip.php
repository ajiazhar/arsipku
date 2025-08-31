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
            <h3 class="panel-title">Semua Arsip</h3>
        </div>

        <div class="panel-body">
            <!-- Tombol Export (popup) -->
            <button type="button" class="btn btn-primary" style="margin-bottom:10px;" data-toggle="modal"
                data-target="#exportModal">
                <i class="fa fa-file-text-o"></i> Download Data
            </button>

            <!-- Modal Export -->
            <div class="modal fade" id="exportModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="GET" action="export_excel.php">
                            <div class="modal-header">
                                <h5 class="modal-title">Filter Export Arsip</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <?php include '../koneksi.php'; ?>

                                <!-- Jenis Dokumen -->
                                <label>Pilih Jenis Dokumen</label>
                                <select name="jenis" class="form-control">
                                    <option value="">-- Semua Jenis --</option>
                                    <?php
                                    $jenis = mysqli_query($koneksi, "SELECT DISTINCT arsip_jenis FROM arsip ORDER BY arsip_jenis ASC");
                                    while ($j = mysqli_fetch_assoc($jenis)) {
                                        if ($j['arsip_jenis'] != '') {
                                            echo "<option value='{$j['arsip_jenis']}'>{$j['arsip_jenis']}</option>";
                                        }
                                    }
                                    ?>
                                </select>

                                <!-- Kategori -->
                                <label class="mt-2">Kategori</label>
                                <select name="kategori" class="form-control">
                                    <option value="">-- Semua Kategori --</option>
                                    <?php
                                    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama ASC");
                                    while ($k = mysqli_fetch_assoc($kategori)) {
                                        echo "<option value='{$k['kategori_id']}'>{$k['kategori_nama']}</option>";
                                    }
                                    ?>
                                </select>

                                <!-- Rak -->
                                <label class="mt-2">Rak</label>
                                <select name="rak" class="form-control">
                                    <option value="">-- Semua Rak --</option>
                                    <?php
                                    $rak = mysqli_query($koneksi, "SELECT * FROM arsip_rak ORDER BY rak_nama ASC");
                                    while ($r = mysqli_fetch_assoc($rak)) {
                                        echo "<option value='{$r['rak_id']}'>{$r['rak_nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Download</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table -->
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

                                <!-- Modal Hapus -->
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
                                                    class="btn btn-primary">
                                                    <i class="fa fa-check"></i> &nbsp; Ya, hapus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <a target="_blank" class="btn btn-default"
                                        href="../arsip/<?php echo $p['arsip_file']; ?>"><i class="fa fa-download"></i></a>
                                    <a target="_blank" href="arsip_preview.php?id=<?php echo $p['arsip_id']; ?>"
                                        class="btn btn-default"><i class="fa fa-search"></i> Preview</a>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal_<?php echo $p['arsip_id']; ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>