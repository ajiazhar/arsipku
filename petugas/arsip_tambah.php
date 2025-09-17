<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Upload Arsip</h4>
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
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel">

                <div class="panel-heading">
                    <h3 class="panel-title">Upload Arsip</h3>
                </div>
                <div class="panel-body">

                    <div class="pull-right">
                        <a href="arsip.php" class="btn btn-sm btn-primary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <br><br>

                    <form method="post" action="arsip_aksi.php" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Kode Arsip</label>
                            <input type="text" class="form-control" name="kode" required>
                        </div>

                        <div class="form-group">
                            <label>Pencipta</label>
                            <input type="text" class="form-control" name="Pencipta" required>
                        </div>

                        <div class="form-group">
                            <label>Bidang</label>
                            <input type="text" class="form-control" name="Bidang" required>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" class="form-control" name="tahun" required>
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" required>
                        </div>

                        <div class="form-group">
                            <label>Sampul</label>
                            <input type="text" class="form-control" name="sampul" required>
                        </div>

                        <div class="form-group">
                            <label>Box</label>
                            <input type="text" class="form-control" name="box" required>
                        </div>

                        <div class="form-group">
                            <label>Rak Penyimpanan</label>
                            <select class="form-control" name="rak" required>
                                <option value="">Pilih rak</option>
                                <?php
                                $rak = mysqli_query($koneksi, "SELECT * FROM arsip_rak ORDER BY rak_nama ASC");
                                while ($r = mysqli_fetch_array($rak)) {
                                    echo "<option value='{$r['rak_id']}'>{$r['rak_nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tingkat Perkembangan</label>
                            <select class="form-control" name="kategori" required>
                                <option value="">Pilih kategori</option>
                                <?php
                                $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama ASC");
                                while ($k = mysqli_fetch_array($kategori)) {
                                    echo "<option value='{$k['kategori_id']}'>{$k['kategori_nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Akses Surat</label>
                            <select class="form-control" name="akses" required>
                                <option value="">Pilih akses</option>
                                <?php
                                $akses = mysqli_query($koneksi, "SELECT * FROM surat_akses ORDER BY akses_nama ASC");
                                while ($a = mysqli_fetch_array($akses)) {
                                    echo "<option value='{$a['akses_id']}'>{$a['akses_nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Index</label>
                            <select name="index" class="form-control">
                                <option value="">- Pilih Index -</option>
                                <?php
                                $index = mysqli_query($koneksi, "SELECT * FROM `index` ORDER BY index_nama ASC");
                                while ($i = mysqli_fetch_array($index)) {
                                    echo "<option value='{$i['index_id']}'>{$i['index_nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- End tambahan baru -->

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>File</label>
                            <input type="file" name="file">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>P