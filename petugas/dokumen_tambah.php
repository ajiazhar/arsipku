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
            $index = mysqli_query($koneksi, "SELECT * FROM `index` ORDER BY index_nama ASC");

            $kode_sugesti = 'ARSIP-' . date('YmdHis');
            ?>

            <!-- ⚡ Form tunggal dimulai di sini -->
            <form action="dokumen_aksi.php" method="POST">

                <!-- Baris 1: Kode + Index + Tahun + Bidang -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="arsip_kode" class="form-control" value="<?= $kode_sugesti; ?>"
                                required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Index</label>
                            <select name="arsip_index" class="form-control" required>
                                <option value="">-- Pilih Index Arsip --</option>
                                <?php while ($i = mysqli_fetch_assoc($index)) { ?>
                                    <option value="<?= $i['index_id']; ?>"><?= $i['index_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tahun Arsip</label>
                            <input type="number" name="tahun_arsip" class="form-control" placeholder="Misal: 2024"
                                required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Bidang</label>
                            <input type="text" name="arsip_bidang" class="form-control"
                                placeholder="Unit / Bidang Pengolah" required>
                        </div>
                    </div>
                </div>

                <!-- Baris 2: Sampul + Box + Rak -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sampul</label>
                            <input type="text" name="arsip_sampul" class="form-control"
                                placeholder="Misal: Sampul Hijau">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Box</label>
                            <input type="text" name="arsip_box" class="form-control" placeholder="Misal: Box A1">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rak</label>
                            <select name="arsip_rak" class="form-control" required>
                                <option value="">-- Pilih Rak --</option>
                                <?php while ($r = mysqli_fetch_assoc($rak)) { ?>
                                    <option value="<?= $r['rak_id']; ?>"><?= $r['rak_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Baris 3: Jumlah + Kategori + Akses Surat -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" name="arsip_jumlah" class="form-control"
                                placeholder="Contoh: 10 berkas, 2 set">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tingkat Perkembangan</label>
                            <select name="arsip_kategori" class="form-control" required>
                                <option value="">-- Tingkat Perkembangan --</option>
                                <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
                                    <option value="<?= $k['kategori_id']; ?>"><?= $k['kategori_nama']; ?></option>
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
                                    <option value="<?= $sa['akses_id']; ?>"><?= $sa['akses_nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Baris 4: Keterangan + Deskripsi + Pencipta -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="arsip_keterangan" class="form-control" rows="3"
                                placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="arsip_deskripsi" class="form-control" rows="3"
                                placeholder="Deskripsi isi dokumen"></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pencipta</label>
                            <textarea name="arsip_nama" class="form-control" rows="3"
                                placeholder="Misal: Dinas Pendidikan"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Isi Dokumen -->
                <div class="form-group">
                    <label>Isi Dokumen</label>
                    <textarea id="isi" name="isi" rows="16" class="form-control" placeholder="Tulis dokumen di sini..."
                        required></textarea>
                </div>

                <!-- Tombol -->
                <div class="text-left" style="margin-top:10px;">
                    <a href="arsip.php" class="btn btn-primary" style="margin-left:5px;">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success" style="margin-top:15px;">
                        <i class="fa fa-save"></i> Simpan sebagai PDF
                    </button>
                </div>
            </form>
            <!-- ⚡ Form ditutup di sini -->

        </div>
    </div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('isi', { height: 420 });
</script>

<?php include 'footer.php'; ?>