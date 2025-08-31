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
                                <li><span class="bread-blod">Preview Arsip</span></li>
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
                    $id = $_GET['id'];
                    $data = mysqli_query($koneksi, "SELECT * FROM arsip,kategori,petugas WHERE arsip_petugas=petugas_id and arsip_kategori=kategori_id and arsip_id='$id'");
                    while ($d = mysqli_fetch_array($data)) {
                        ?>

                        <div class="row">
                            <div class="col-lg-4">
                                <table class="table">
                                    <tr>
                                        <th>Kode Arsip</th>
                                        <td><?php echo $d['arsip_kode']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Upload</th>
                                        <td><?php echo date('H:i:s  d-m-Y', strtotime($d['arsip_waktu_upload'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama File</th>
                                        <td><?php echo $d['arsip_nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td><?php echo $d['kategori_nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis File</th>
                                        <td><?php echo $d['arsip_jenis']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Petugas Pengupload</th>
                                        <td><?php echo $d['petugas_nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td><?php echo $d['arsip_keterangan']; ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-lg-8">
                                <?php
                                $file_path = "../arsip/" . $d['arsip_file'];
                                $file_url = urlencode("http://websitekamu.com/arsip/" . $d['arsip_file']); // Ganti dengan URL hosting kamu
                            
                                if (in_array($d['arsip_jenis'], ["png", "jpg", "gif", "jpeg"])) {
                                    // Preview Gambar
                                    echo '<img src="' . $file_path . '" style="max-width:100%;">';

                                } elseif ($d['arsip_jenis'] == "pdf") {
                                    // Preview PDF
                                    echo '<div class="pdf-singe-pro">
                                            <a class="media" href="' . $file_path . '"></a>
                                          </div>';

                                } elseif (in_array($d['arsip_jenis'], ["doc", "docx", "xls", "xlsx", "ppt", "pptx"])) {
                                    // Preview File Office via Google Docs Viewer
                                    echo '<iframe src="https://docs.google.com/gview?url=' . $file_url . '&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>';

                                } else {
                                    // Tidak ada preview
                                    echo '<p>Preview tidak tersedia, silahkan <a target="_blank" style="color: blue" href="' . $file_path . '">Download di sini.</a></p>';
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>