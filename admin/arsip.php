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

                                        <!-- Kategori -->
                                        <label class="mt-2">Tingkat Perkembangan</label>
                                        <select name="Tingkat Perkembangan" class="form-control">
                                            <option value="">Semua Tingkat Perkembangan</option>
                                            <?php
                                            $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama ASC");
                                            while ($k = mysqli_fetch_assoc($kategori)) {
                                                echo "<option value='{$k['kategori_id']}'>{$k['kategori_nama']}</option>";
                                            }
                                            ?>
                                        </select>

                                        <!-- Rak -->
                                        <label class="mt-2">Rak</label>
                                        <input type="text" name="rak" class="form-control"
                                            placeholder="Masukkan nama rak">

                                        <!-- Sampul -->
                                        <label class="mt-2">Sampul</label>
                                        <input type="text" name="sampul" class="form-control"
                                            placeholder="Masukkan nomor sampul">

                                        <!-- Box -->
                                        <label class="mt-2">Box</label>
                                        <input type="text" name="box" class="form-control"
                                            placeholder="Masukkan nomor box">

                                        <!-- Pencipta -->
                                        <label class="mt-2">Pencipta</label>
                                        <input type="text" name="pencipta" class="form-control"
                                            placeholder="Masukkan pencipta">


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Download</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
                                    <th>Hak Akases</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" width="15%">OPSI</th>
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
                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $p['arsip_kode']; ?></td>
                                        <td>
                                            <b>Pencipta</b>: <?= $p['arsip_nama']; ?><br>
                                            <b>Bidang</b>: <?= $p['arsip_bidang']; ?><br>
                                        </td>
                                        <td><?= $p['index_nama']; ?></td>
                                        <td><?= $p['arsip_deskripsi']; ?></td>
                                        <td><?= $p['arsip_tahun'] ?: 'Belum diatur'; ?></td>
                                        <td><?= $p['arsip_jumlah']; ?></td>
                                        <td><?= $p['arsip_sampul']; ?></td>
                                        <td><?= $p['arsip_box']; ?></td>
                                        <td><?= $p['rak_nama']; ?></td>
                                        <td><?= $p['kategori_nama']; ?></td>
                                        <td><?= $p['akses_nama']; ?></td>
                                        <td><?= $p['arsip_keterangan']; ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">

                                                <a target="_blank" class="btn btn-default"
                                                    href="../arsip/<?php echo $p['arsip_file']; ?>"><i
                                                        class="fa fa-download"></i></a>
                                                <a target="_blank" href="arsip_preview.php?id=<?php echo $p['arsip_id']; ?>"
                                                    class="btn btn-default"><i class="fa fa-search"></i> Preview</a>
                                                <button onclick="hapusData('<?php echo $p['arsip_id']; ?>')"
                                                    class="btn btn-danger" title="Hapus">
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
    </div>
</div>

<?php include 'footer.php'; ?>