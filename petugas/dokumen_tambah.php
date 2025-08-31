<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 style="margin-bottom:0">Buat Dokumen Baru</h4>
                        </div>
                        <div class="col-lg-6">
                            <ul class="breadcome-menu" style="padding-top:0">
                                <li><a href="index.php">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">Buat Dokumen</span></li>
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
            <h3 class="panel-title">Editor Dokumen</h3>
        </div>

        <div class="panel-body">
            <?php
            include '../koneksi.php';
            $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama ASC");
            $rak = mysqli_query($koneksi, "SELECT * FROM arsip_rak ORDER BY rak_nama ASC");
            $akses = mysqli_query($koneksi, "SELECT * FROM surat_akses ORDER BY akses_nama ASC");

            $kode_sugesti = 'ARSIP-' . date('YmdHis');
            ?>

            <form action="dokumen_aksi.php" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="arsip_kode" class="form-control"
                                value="<?php echo $kode_sugesti; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Dokumen</label>
                            <input type="text" name="arsip_nama" class="form-control"
                                placeholder="Misal: Surat Keputusan Kepala Dinas" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="arsip_kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
                                    <option value="<?php echo $k['kategori_id']; ?>">
                                        <?php echo $k['kategori_nama']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rak</label>
                            <select name="arsip_rak" class="form-control" required>
                                <option value="">-- Pilih Rak --</option>
                                <?php while ($r = mysqli_fetch_assoc($rak)) { ?>
                                    <option value="<?php echo $r['rak_id']; ?>">
                                        <?php echo $r['rak_nama']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Akses Surat</label>
                            <select name="surat_akses" class="form-control" required>
                                <option value="">-- Pilih Akses Surat --</option>
                                <?php while ($sa = mysqli_fetch_assoc($akses)) { ?>
                                    <option value="<?php echo $sa['akses_id']; ?>">
                                        <?php echo $sa['akses_nama']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="arsip_keterangan" class="form-control"
                                placeholder="Keterangan singkat dokumen (opsional)">
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label>Isi Dokumen</label>
                    <textarea id="isi" name="isi" rows="16" class="form-control" placeholder="Tulis dokumen di sini..."
                        required></textarea>
                </div>
                <div class="text-left" style="margin-top:10px;">
                    <!-- Tombol Kembali -->
                    <a href="arsip.php" class="btn btn-primary" style="margin-left:5px;">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Tombol Simpan sebagai PDF -->
                    <button type="submit" class="btn btn-primary" style="margin-top:15px;">
                        <i class="fa fa-save"></i> Simpan sebagai PDF
                    </button>
                </div>


                <!-- <div class="text-right">
                    <a href="arsip.php" class="btn btn-default">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan sebagai PDF
                    </button>
                </div> -->

                <!-- <div class="text-left" style="margin-top:10px;"> -->
                <!-- Tombol Kembali -->
                <!-- <a href="arsip.php" class="btn btn-primary" style="margin-right:5px;">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a> -->

                <!-- Tombol Simpan sebagai PDF -->
                <!-- <a href="#" onclick="document.getElementById('form_arsip').submit();" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan sebagai PDF
                    </a> -->
        </div>

        </form>
    </div>
</div>
</div>

<!-- CKEditor 4 -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('isi', { height: 420 });
</script>

<?php include 'footer.php'; ?>