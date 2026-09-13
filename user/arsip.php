<?php include 'header.php'; ?>

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
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped table-hover table-datatable table-arsip">
                            <thead>
                                <tr>
                                    <th class="th-no text-center" width="1%">NO</th>
                                    <th class="th-kode">KODE KLASIFIKASI</th>
                                    <th class="th-arsip">ARSIP</th>
                                    <th class="th-index">INDEX</th>
                                    <th class="th-desc">URAIAN INFORMASI ARSIP</th>
                                    <th class="th-tahun text-center">KURUN WAKTU</th>
                                    <th class="th-jumlah text-center">JUMLAH</th>
                                    <th class="th-sampul text-center">SAMPUL</th>
                                    <th class="th-box text-center">BOX</th>
                                    <th class="th-rak text-center">RAK</th>
                                    <th class="th-kategori text-center">TINGKAT PERKEMBANGAN</th>
                                    <th class="th-akses text-center">HAK AKSES</th>
                                    <th class="th-ket">KETERANGAN</th>
                                    <th class="th-opsi text-center" width="12%">OPSI</th>
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
                            a.arsip_bidang,
                            k.kategori_nama,
                            p.petugas_nama,
                            COALESCE(a.arsip_rak, 'Belum diatur') AS rak_nama, -- ✅ langsung ambil dari kolom arsip
                            a.arsip_sampul,
                            a.arsip_box,
                            COALESCE(sa.akses_nama, 'Belum diatur') AS akses_nama,
                            COALESCE(i.index_nama, 'Belum diatur') AS index_nama,
                            a.arsip_jumlah,
                            a.arsip_keterangan,
                            a.arsip_deskripsi,
                            a.arsip_file
                        FROM arsip a
                        LEFT JOIN kategori k     ON a.arsip_kategori = k.kategori_id
                        LEFT JOIN petugas p      ON a.arsip_petugas  = p.petugas_id
                        LEFT JOIN surat_akses sa ON a.surat_akses    = sa.akses_id
                        LEFT JOIN `index` i      ON a.arsip_index    = i.index_id
                        ORDER BY a.arsip_id DESC"
                                );

                                while ($p = mysqli_fetch_array($arsip)) {
                                    $kat = $p['kategori_nama'] ?: 'Belum diatur';
                                    $katClass = (stripos($kat, 'asli') !== false) ? 'badge-success' : 'badge-info';
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td>
                                            <span class="badge-code"><?= htmlspecialchars($p['arsip_kode']); ?></span>
                                        </td>
                                        <td class="td-arsip">
                                            <div class="arsip-creator">
                                                <div class="arsip-pencipta">
                                                    <i class="fa fa-user text-primary" style="font-size:11px;"></i>
                                                    <?= htmlspecialchars($p['arsip_nama']); ?>
                                                </div>
                                                <div class="arsip-bidang">
                                                    <i class="fa fa-building-o text-muted" style="font-size:11px;"></i>
                                                    <?= htmlspecialchars($p['arsip_bidang']); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-meta">
                                                <i class="fa fa-folder-o text-muted"></i> <?= htmlspecialchars($p['index_nama']); ?>
                                            </span>
                                        </td>
                                        <td class="td-desc">
                                            <div class="col-desc-text"><?= nl2br(htmlspecialchars($p['arsip_deskripsi'])); ?></div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-meta">
                                                <i class="fa fa-calendar-o text-muted"></i> <?= htmlspecialchars($p['arsip_tahun'] ?: '-'); ?>
                                            </span>
                                        </td>
                                        <td class="text-center"><?= htmlspecialchars($p['arsip_jumlah']); ?></td>
                                        <td class="text-center">
                                            <span class="badge-meta"><?= htmlspecialchars($p['arsip_sampul']); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-meta"><?= htmlspecialchars($p['arsip_box']); ?></span>
                                        </td>
                                        <td class="text-center"><?= htmlspecialchars($p['rak_nama']); ?></td>
                                        <td class="text-center">
                                            <span class="badge-status <?= $katClass; ?>"><?= htmlspecialchars($kat); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-status badge-neutral"><?= htmlspecialchars($p['akses_nama']); ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($p['arsip_keterangan'] ?: '-'); ?></td>
                                        <td class="text-center">
                                            <div class="btn-action-group">
                                                <a class="btn-action btn-action-download" href="download.php?id=<?= $p['arsip_id']; ?>" title="Download Berkas">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <a target="_blank" href="arsip_preview.php?id=<?= $p['arsip_id']; ?>"
                                                    class="btn-action btn-action-preview" title="Preview Arsip">
                                                    <i class="fa fa-eye"></i> Preview
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>