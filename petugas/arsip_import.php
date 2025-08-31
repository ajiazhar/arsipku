?>
<!DOCTYPE html>
<html>

<head>
    <title>Import Excel - Sistem Arsip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fa fa-file-excel"></i> Import Data Arsip dari Excel</h5>
                    </div>
                    <div class="card-body">

                        <?php
                        // Include koneksi database
                        include 'koneksi.php'; // Sesuaikan nama file koneksi
                        include 'functions/import_excel_functions.php';

                        // Proses import jika ada file yang diupload
                        if (isset($_POST['import_excel']) && isset($_FILES['excel_file'])) {
                            $upload_dir = 'uploads/temp/';
                            if (!is_dir($upload_dir)) {
                                mkdir($upload_dir, 0777, true);
                            }

                            $file_name = time() . '_' . $_FILES['excel_file']['name'];
                            $file_path = $upload_dir . $file_name;

                            if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $file_path)) {
                                $result = importExcelArsip($file_path, $conn);

                                // Hapus file temporary
                                unlink($file_path);

                                // Tampilkan hasil
                                if ($result['success']) {
                                    echo '<div class="alert alert-success">';
                                    echo '<strong>Sukses!</strong> ' . $result['message'];
                                    if (!empty($result['errors'])) {
                                        echo '<hr><strong>Peringatan:</strong><ul>';
                                        foreach ($result['errors'] as $error) {
                                            echo '<li>' . $error . '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                    echo '</div>';
                                } else {
                                    echo '<div class="alert alert-danger">';
                                    echo '<strong>Error!</strong> ' . $result['message'];
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger">Gagal upload file!</div>';
                            }
                        }
                        ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih File Excel:</label>
                                        <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls"
                                            required>
                                        <div class="form-text">Format yang didukung: .xlsx, .xls (maksimal 5MB)</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" name="import_excel" class="btn btn-primary">
                                            <i class="fa fa-upload"></i> Import Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>📝 Panduan Import:</h6>
                                <ul class="small">
                                    <li>Download template Excel terlebih dahulu</li>
                                    <li>Isi data sesuai format template</li>
                                    <li>Pastikan Kategori dan Petugas sudah ada di sistem</li>
                                    <li>Upload file Excel yang sudah diisi</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>📊 Template Excel:</h6>
                                <a href="download_template.php" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-download"></i> Download Template
                                </a>
                                <div class="form-text mt-2">Template sudah berisi format dan contoh data</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Preview Data -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>📋 Info Import Terakhir</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        // Tampilkan statistik import terakhir atau data arsip terbaru
                        $sql = "SELECT COUNT(*) as total FROM arsip WHERE DATE(arsip_waktu_upload) = CURDATE()";
                        $result = mysqli_query($conn, $sql);
                        $today_count = mysqli_fetch_assoc($result)['total'];

                        echo "<p><strong>Data hari ini:</strong> $today_count arsip</p>";

                        $sql = "SELECT COUNT(*) as total FROM arsip";
                        $result = mysqli_query($conn, $sql);
                        $total_count = mysqli_fetch_assoc($result)['total'];

                        echo "<p><strong>Total arsip:</strong> $total_count dokumen</p>";
                        ?>

                        <hr>
                        <a href="arsip.php" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali ke Data Arsip
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>