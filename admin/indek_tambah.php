<?php include 'header.php'; ?>
<div class="container-fluid">
    <div class="panel panel">
        <div class="panel-heading">
            <h3 class="panel-title">Tambah Index</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="indek_aksi.php">
                <div class="form-group">
                    <label>Nama Index</label>
                    <input type="text" name="index_nama" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="indek.php" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>