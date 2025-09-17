<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Edit Arsip</h4>
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
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel">

                <div class="panel-heading">
                    <h3 class="panel-title">Edit Arsip</h3>
                </div>
                <div class="panel-body">

                    <div class="pull-right">
                        <a href="arsip.php" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>

                    <br><br>

                    <?php
                    $id = $_GET['id'];
                    $data = mysqli_query($koneksi, "SELECT * FROM arsip WHERE arsip_id='$id'");
                    while ($d = mysqli_fetch_array($data)) {
                        ?>

                        <form method="post" action="arsip_update.php" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="<?= $d['arsip_id']; ?>">

                            <div class="form-group">
                                <label>Kode Arsip</label>
                                <input type="text" class="form-control" name="kode" required="required"
                                    value="<?= $d['arsip_kode']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Pencipta</label>
                                <input type="text" class="form-control" name="pencipta" required="required"
                                    value="<?= $d['arsip_nama']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Bidang</label>
                                <input type="text" class="form-control" name="bidang" required="required"
                                    value="<?= $d['arsip_bidang']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Tahun Arsip</label>
                                <input type="number" class="form-control" name="tahun" required="required"
                                    value="<?= $d['arsip_tahun']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="text" class="form-control" name="jumlah" value="<?= $d['arsip_jumlah']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Sampul</label>
                                <input type="text" class="form-control" name="sampul" value="<?= $d['arsip_sampul']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Box</label>
                                <input type="text" class="form-control" name="box" value="<?= $d['arsip_box']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi"><?= $d['arsip_deskripsi']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Tingkat Perkembangan</label>
                                <select class="form-control" name="kategori" required="required">
                                    <option value="">Pilih kategori</option>
                                    <?php
                                    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                                    while ($k = mysqli_fetch_array($kategori)) {
                                        $selected = ($k['kategori_id'] == $d['arsip_kategori']) ? "selected" : "";
                                        echo "<option value='{$k['kategori_id']}' $selected>{$k['kategori_nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Rak</label>
                                <select class="form-control" name="rak" required="required">
                                    <option value="">Pilih Rak</option>
                                    <?php
                                    $rak = mysqli_query($koneksi, "SELECT * FROM arsip_rak");
                                    while ($r = mysqli_fetch_array($rak)) {
                                        $selected = ($r['rak_id'] == $d['arsip_rak']) ? "selected" : "";
                                        echo "<option value='{$r['rak_id']}' $selected>{$r['rak_nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Index</label>
                                <select class="form-control" name="arsip_index" required>
                                    <option value="">-- Pilih Index --</option>
                                    <?php
                                    $index = mysqli_query($koneksi, "SELECT * FROM `index` ORDER BY index_nama ASC");
                                    while ($i = mysqli_fetch_array($index)) {
                                        ?>
                                        <option value="<?= $i['index_id']; ?>" <?= ($d['arsip_index'] == $i['index_id']) ? 'selected' : ''; ?>>
                                            <?= $i['index_nama']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Akses Surat</label>
                                <select class="form-control" name="akses" required="required">
                                    <option value="">Pilih Akses Surat</option>
                                    <?php
                                    $akses = mysqli_query($koneksi, "SELECT * FROM surat_akses");
                                    while ($s = mysqli_fetch_array($akses)) {
                                        $selected = ($s['akses_id'] == $d['surat_akses']) ? "selected" : "";
                                        echo "<option value='{$s['akses_id']}' $selected>{$s['akses_nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="keterangan"
                                    required="required"><?= $d['arsip_keterangan']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>File</label>
                                <input type="file" name="file">
                                <small>Kosongkan jika tidak ingin mengubah file</small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </form>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>