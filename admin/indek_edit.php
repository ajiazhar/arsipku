<?php include 'header.php'; ?>
<?php
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM `index` WHERE index_id='$id'");
$d = mysqli_fetch_assoc($data);
?>
<div class="container-fluid">
    <div class="panel panel">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Index</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="indek_update.php">
                <input type="hidden" name="id" value="<?php echo $d['index_id']; ?>">
                <div class="form-group">
                    <label>Nama Index</label>
                    <input type="text" name="index_nama" class="form-control" value="<?php echo $d['index_nama']; ?>"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="indek.php" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>