<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Preview Arsip</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu" style="padding-top: 0px">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">Preview</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Preview Arsip</h3>
                </div>
                <div class="panel-body">

                    <a href="arsip.php" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <br><br>

                    <?php
                    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    $query = "SELECT a.*, 
                        a.arsip_tahun AS tahun_arsip,
                        k.kategori_nama, 
                        p.petugas_nama,
                        COALESCE(r.rak_nama, 'Belum diatur') AS rak_nama
                        FROM arsip a
                        LEFT JOIN kategori k ON a.arsip_kategori = k.kategori_id
                        LEFT JOIN petugas p  ON a.arsip_petugas  = p.petugas_id
                        LEFT JOIN arsip_rak r ON a.arsip_rak = r.rak_id
                        WHERE a.arsip_id = '$id'
                        LIMIT 1";
                    $res = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

                    if ($d = mysqli_fetch_assoc($res)) {
                        // safe variables
                        $tahun = $d['tahun_arsip'] ?? 'Belum diatur';
                        $deskripsi = $d['arsip_deskripsi'] ?? '-';
                        $sampul = $d['arsip_sampul'] ?? '-';
                        $box = $d['arsip_box'] ?? '-';
                        $jumlah = $d['arsip_jumlah'] ?? '-';
                        $rak_nama = $d['rak_nama'] ?? '-';
                        $file_name = $d['arsip_file'] ?? '';
                        $file_path = "../arsip/" . $file_name;
                        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                        ?>

                        <div class="row">
                            <div class="col-lg-4">
                                <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                                    <tr>
                                        <th>Kode Arsip</th>
                                        <td><?= htmlspecialchars($d['arsip_kode']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah</th>
                                        <td><?= htmlspecialchars($jumlah); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Upload</th>
                                        <td><?= isset($d['arsip_waktu_upload']) ? date('H:i:s d-m-Y', strtotime($d['arsip_waktu_upload'])) : '-'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pencipta</th>
                                        <td><?= htmlspecialchars($d['arsip_nama']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bidang</th>
                                        <td><?= htmlspecialchars($d['arsip_bidang']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td><?= htmlspecialchars($d['kategori_nama'] ?? '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Petugas Pengupload</th>
                                        <td><?= htmlspecialchars($d['petugas_nama'] ?? '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Index</th>
                                        <td><?= htmlspecialchars($d['index_nama'] ?? '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td><?= nl2br(htmlspecialchars($d['arsip_keterangan'] ?? '-')); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tahun</th>
                                        <td><?= htmlspecialchars($tahun); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td><?= nl2br(htmlspecialchars($deskripsi)); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sampul</th>
                                        <td><?= htmlspecialchars($sampul); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Box</th>
                                        <td><?= htmlspecialchars($box); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Rak</th>
                                        <td><?= htmlspecialchars($rak_nama); ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-lg-8">
                                <?php
                                if (!empty($file_name) && file_exists($file_path)) {
                                    if (in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                                        echo '<img src="' . $file_path . '" style="max-width:100%;height:auto;border:1px solid #ddd;padding:5px;">';
                                    } elseif ($ext === 'pdf') {
                                        echo '<iframe src="' . $file_path . '" width="100%" height="600px"></iframe>';
                                    } else {
                                        echo '<p>Preview tidak tersedia. Silakan <a target="_blank" href="' . $file_path . '">download di sini</a>.</p>';
                                    }
                                } else {
                                    echo '<p class="text-warning">File tidak ditemukan.</p>';
                                }
                                ?>
                            </div>
                        </div>

                    <?php } else { ?>
                        <p class="text-danger">Data arsip tidak ditemukan.</p>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>