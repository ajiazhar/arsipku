<?php
// Pastikan tidak ada output sebelum header
ob_start(); // Mulai output buffering untuk mencegah output awal

// Set header untuk file Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Template_Import_Arsip.xls"');
header('Cache-Control: max-age=0');

// Include koneksi database
include 'koneksi.php';

// Buat template dalam format HTML Table (Excel compatible)
echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
echo '</head>';
echo '<body>';
echo '<table border="1">';

// Header
echo '<tr>';
echo '<td>No</td>';
echo '<td>Waktu Upload</td>';
echo '<td>KODE</td>';
echo '<td>Nama Arsip</td>';
echo '<td>Jenis</td>';
echo '<td>Kategori</td>';
echo '<td>Petugas</td>';
echo '<td>Keterangan</td>';
echo '</tr>';

// Contoh data
echo '<tr>';
echo '<td>1</td>';
echo '<td>2025-01-15 10:00:00</td>';
echo '<td>ARSIP-001</td>';
echo '<td>Contoh Surat Keputusan</td>';
echo '<td>pdf</td>';
echo '<td>Surat Keputusan</td>';
echo '<td>Admin</td>';
echo '<td>Contoh dokumen untuk import</td>';
echo '</tr>';

echo '<tr>';
echo '<td>2</td>';
echo '<td>2025-01-15 11:00:00</td>';
echo '<td>ARSIP-002</td>';
echo '<td>Contoh Laporan Bulanan</td>';
echo '<td>pdf</td>';
echo '<td>Laporan</td>';
echo '<td>Staff</td>';
echo '<td>Contoh dokumen laporan</td>';
echo '</tr>';

// Tambahkan baris kosong untuk user isi
for ($i = 3; $i <= 10; $i++) {
    echo '<tr>';
    echo '<td>' . $i . '</td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '</tr>';
}

echo '</table>';

// Tambahkan sheet kedua dengan master data untuk referensi
echo '<br><br>';
echo '<table border="1">';
echo '<tr><td colspan="2"><b>MASTER DATA KATEGORI</b></td></tr>';
echo '<tr><td><b>Nama Kategori</b></td><td><b>Keterangan</b></td></tr>';

// Ambil data kategori dengan pengecekan error
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama");
if ($kategori === false) {
    echo '<tr><td colspan="2">Error: Tidak dapat mengambil data kategori.</td></tr>';
} else {
    while ($k = mysqli_fetch_array($kategori)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($k['kategori_nama']) . '</td>';
        echo '<td>' . htmlspecialchars($k['kategori_keterangan']) . '</td>';
        echo '</tr>';
    }
}

echo '</table>';

// Master data petugas
echo '<br><br>';
echo '<table border="1">';
echo '<tr><td colspan="2"><b>MASTER DATA PETUGAS</b></td></tr>';
echo '<tr><td><b>Nama Petugas</b></td><td><b>Level</b></td></tr>';

// Cek tabel petugas atau user dengan pengecekan error
$petugas_query = "SELECT * FROM petugas ORDER BY petugas_nama";
$petugas_result = mysqli_query($koneksi, $petugas_query);

if ($petugas_result === false) {
    echo '<tr><td colspan="2">Error: Tidak dapat mengambil data petugas.</td></tr>';
} elseif (mysqli_num_rows($petugas_result) > 0) {
    while ($p = mysqli_fetch_array($petugas_result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($p['petugas_nama']) . '</td>';
        echo '<td>' . (isset($p['petugas_level']) ? htmlspecialchars($p['petugas_level']) : 'Petugas') . '</td>';
        echo '</tr>';
    }
} else {
    // Jika tidak ada tabel petugas, ambil dari user
    $user_query = "SELECT * FROM user ORDER BY user_nama";
    $user_result = mysqli_query($koneksi, $user_query);
    if ($user_result === false) {
        echo '<tr><td colspan="2">Error: Tidak dapat mengambil data user.</td></tr>';
    } else {
        while ($u = mysqli_fetch_array($user_result)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($u['user_nama']) . '</td>';
            echo '<td>' . (isset($u['user_level']) ? htmlspecialchars($u['user_level']) : 'User') . '</td>';
            echo '</tr>';
        }
    }
}

echo '</table>';
echo '</body></html>';

// Flush output dan hentikan eksekusi
ob_end_flush();
exit;
?>