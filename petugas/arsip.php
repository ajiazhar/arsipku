<?php include 'header.php'; ?>

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

            <br><br><br>

            <!-- Modal Import -->
            <div class="modal fade" id="importModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formImportExcel" enctype="multipart/form-data">
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
                                <button type="submit" class="btn btn-success" id="btnImport">Import</button>
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
                        echo '<div class="alert alert-danger">File arsip gagal diupload. File .php tidak diperbolehkan.</div>';
                    } else {
                        echo '<div class="alert alert-success">Arsip berhasil tersimpan.</div>';
                    }
                }
                ?>
            </center>

            <!-- Table -->
            <div class="table-responsive">
                <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th>Kode Klasifikasi</th>
                            <th>Arsip</th>
                            <th>Index</th>
                            <th>Uraian Informasi Arsip</th>
                            <th>Kurun Waktu</th>
                            <th>Jumlah</th>
                            <th>Sampul</th>
                            <th>Box</th>
                            <th>Rak</th>
                            <th>Tingkat Perkembangan</th>
                            <th>Hak Akses</th>
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
                            a.arsip_bidang,
                            k.kategori_nama,
                            p.petugas_nama,
                            COALESCE(r.rak_nama, 'Belum diatur') AS rak_nama,
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
                                <td><?php echo $p['arsip_kode'] ?></td>
                                <td>
                                    <b>Pencipta</b> : <?php echo $p['arsip_nama'] ?><br>
                                    <b>Bidang</b> : <?php echo $p['arsip_bidang'] ?><br>
                                    <?php
                                    ?>
                                </td>
                                <td><?php echo $p['index_nama'] ?></td>
                                <td><?php echo $p['arsip_deskripsi'] ?></td>
                                <td><?= $p['arsip_tahun'] ? $p['arsip_tahun'] : 'Belum diatur'; ?></td>
                                <td><?php echo $p['arsip_jumlah'] ?></td>
                                <td><?php echo $p['arsip_sampul']; ?></td>
                                <td><?php echo $p['arsip_box']; ?></td>
                                <td><?php echo $p['rak_nama']; ?></td>
                                <td><?php echo $p['kategori_nama'] ?></td>
                                <td><?php echo $p['akses_nama']; ?></td>
                                <td><?php echo $p['arsip_keterangan'] ?></td>
                                <td class="text-center">
                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="exampleModal_<?php echo $p['arsip_id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">PERINGATAN!</h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus data ini? <br>File dan semua yang
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
                                            href="../arsip/<?php echo $p['arsip_file']; ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a target="_blank" href="arsip_preview.php?id=<?php echo $p['arsip_id']; ?>"
                                            class="btn btn-default">
                                            <i class="fa fa-search"></i> Preview
                                        </a>
                                        <a href="arsip_edit.php?id=<?php echo $p['arsip_id']; ?>" class="btn btn-default">
                                            <i class="fa fa-wrench"></i>
                                        </a>
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
</div>

<?php include 'footer.php'; ?>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function () {
        $('#table').DataTable({
            scrollX: true,
            autoWidth: false
        });
    });
</script> -->


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