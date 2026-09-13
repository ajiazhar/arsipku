<?php include 'header.php'; ?>
<?php include '../include/notif.php'; ?>

<div class="wrapper">
    <div class="content">
        <div class="breadcome-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcome-list">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="breadcome-heading">
                                        <h4 style="margin-bottom: 0px">Data Arsip</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6">
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

                    <style>
                        .arsip-action-toolbar {
                            display: flex !important;
                            align-items: center !important;
                            gap: 12px !important;
                            margin-bottom: 20px !important;
                            flex-wrap: wrap !important;
                        }
                        .arsip-action-toolbar .btn-action-top {
                            display: inline-flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            gap: 8px !important;
                            height: 38px !important;
                            min-height: 38px !important;
                            max-height: 38px !important;
                            padding: 0 18px !important;
                            font-size: 13px !important;
                            font-weight: 600 !important;
                            border-radius: 8px !important;
                            border: none !important;
                            line-height: 38px !important;
                            box-sizing: border-box !important;
                            margin: 0 !important;
                            cursor: pointer !important;
                            text-decoration: none !important;
                            vertical-align: middle !important;
                            transition: all 0.25s ease !important;
                        }
                        .arsip-action-toolbar .btn-action-top i {
                            font-size: 14px !important;
                            line-height: 1 !important;
                            margin: 0 !important;
                        }
                        .arsip-action-toolbar .btn-action-primary {
                            background: linear-gradient(135deg, #1a56db 0%, #0f3797 100%) !important;
                            color: #ffffff !important;
                            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.25) !important;
                        }
                        .arsip-action-toolbar .btn-action-primary:hover {
                            background: linear-gradient(135deg, #164ec7 0%, #0d2f80 100%) !important;
                            transform: translateY(-2px) !important;
                            box-shadow: 0 6px 16px rgba(26, 86, 219, 0.35) !important;
                            color: #ffffff !important;
                        }
                        .arsip-action-toolbar .btn-action-excel {
                            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
                            color: #ffffff !important;
                            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important;
                        }
                        .arsip-action-toolbar .btn-action-excel:hover {
                            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
                            transform: translateY(-2px) !important;
                            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35) !important;
                            color: #ffffff !important;
                        }
                    </style>

                    <div class="arsip-action-toolbar">
                        <!-- Upload Arsip -->
                        <a href="arsip_tambah.php" class="btn-action-top btn-action-primary">
                            <i class="fa fa-cloud-upload"></i> Upload Arsip
                        </a>

                        <!-- Import Excel -->
                        <button type="button" class="btn-action-top btn-action-excel" data-toggle="modal" data-target="#importModal">
                            <i class="fa fa-file-excel-o"></i> Import Excel
                        </button>
                    </div>

                    <center>
                        <?php
                        if (isset($_GET['alert'])) {
                            if ($_GET['alert'] == "gagal") {
                                echo '<div class="alert alert-danger">File arsip gagal diupload. File .php tidak diperbolehkan.</div>';
                            } else {
                                echo '<div class="alert alert-success">Arsip berhasil tersimpan.</div>';
                            }
                        }
                        ?>
                    </center>

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
                                    <th class="th-opsi text-center" width="15%">OPSI</th>
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
                            a.arsip_bidang,
                            k.kategori_nama,
                            p.petugas_nama,
                            COALESCE(a.arsip_rak, 'Belum diatur') AS rak_nama,
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
                        WHERE a.arsip_petugas = '$id_petugas'
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
                                                <?php if (!empty($p['arsip_file'])) { ?>
                                                    <a target="_blank" class="btn-action btn-action-download"
                                                        href="../arsip/<?= $p['arsip_file']; ?>" title="Download Berkas">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                <?php } ?>
                                                <a target="_blank" href="arsip_preview.php?id=<?= $p['arsip_id']; ?>"
                                                    class="btn-action btn-action-preview" title="Preview Arsip">
                                                    <i class="fa fa-eye"></i> Preview
                                                </a>
                                                <a href="arsip_edit.php?id=<?= $p['arsip_id']; ?>"
                                                    class="btn-action btn-action-edit" title="Edit Arsip">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0);" onclick="hapusData('<?= $p['arsip_id']; ?>')"
                                                    class="btn-action btn-action-delete" title="Hapus Data">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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
                        window.location = "arsip_hapus.php?id=" + id + "&msg=arsip_hapus";
                    }
                });
            }
        </script>
        <!-- Modal Import -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 520px;">
                <div class="modal-content">
                    <form id="formImportExcel" enctype="multipart/form-data">
                        <div class="modal-header-custom">
                            <div class="modal-header-left">
                                <div class="modal-icon-badge">
                                    <i class="fa fa-file-excel-o"></i>
                                </div>
                                <div>
                                    <h4 class="modal-title-custom" id="importModalLabel">Import Data dari Excel</h4>
                                    <p class="modal-subtitle">Unggah berkas spreadsheet (.xlsx atau .xls)</p>
                                </div>
                            </div>
                            <button type="button" class="close-custom" data-dismiss="modal" aria-label="Close" title="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body-custom">
                            <div class="modal-form-group">
                                <label><i class="fa fa-cloud-upload"></i> Pilih File Excel</label>
                                <input type="file" name="file_excel" class="form-control" accept=".xls,.xlsx" required style="padding-top: 10px !important;">
                            </div>
                            <div class="export-modal-tip">
                                <i class="fa fa-info-circle text-primary" style="font-size: 15px; flex-shrink: 0;"></i>
                                <span>Pastikan struktur kolom data sudah sesuai dengan format template yang ditentukan.</span>
                            </div>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn-modal-cancel" data-dismiss="modal">
                                <i class="fa fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn-modal-download" id="btnImport">
                                <i class="fa fa-upload"></i> Mulai Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include 'footer.php'; ?>

        <!-- SweetAlert + AJAX Import -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('formImportExcel').addEventListener('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                let btn = document.getElementById('btnImport');
                btn.disabled = true;
                btn.innerHTML = 'Importing...';

                fetch('import_excel.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        $('#importModal').modal('hide');
                        btn.disabled = false;
                        btn.innerHTML = 'Import';

                        if (data.status === 'ok') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Import Berhasil',
                                text: `${data.success} data berhasil diimport, ${data.fail} gagal.`,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Import',
                                text: data.message || 'Terjadi kesalahan saat import.'
                            });
                        }
                    })
                    .catch(err => {
                        $('#importModal').modal('hide');
                        btn.disabled = false;
                        btn.innerHTML = 'Import';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Tidak bisa terhubung ke server!'
                        });
                    });
            });
        </script>
    </div>
</div>