<?php
// petugas/import_excel.php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../koneksi.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Pastikan sudah login (punya id petugas)
$petugasId = isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;
if ($petugasId <= 0) {
    http_response_code(403);
    exit('Akses ditolak: Anda belum login sebagai petugas.');
}

// File upload ada?
if (empty($_FILES['file_excel']['tmp_name'])) {
    exit('Tidak ada file yang diupload.');
}

$fileTmp = $_FILES['file_excel']['tmp_name'];
$fileExt = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));

// Hanya izinkan xls/xlsx (kasus uppercase juga ok)
if (!in_array($fileExt, ['xls', 'xlsx'])) {
    exit('Format file tidak valid. Harap upload file .xls atau .xlsx');
}

try {
    $spreadsheet = IOFactory::load($fileTmp);
    // Pakai array dengan key huruf kolom agar mudah baca header
    $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    if (!$rows || count($rows) < 2) {
        exit('File kosong atau tidak ada data.');
    }

    // Baca header (baris pertama) dan buat peta nama kolom -> huruf kolom
    $header = array_shift($rows);
    $map = [];
    foreach ($header as $col => $name) {
        $key = strtolower(trim((string) $name));
        if ($key !== '') {
            $map[$key] = $col;
        }
    }

    // Helper ambil nilai berdasarkan nama header
    $get = function (array $row, string $name) use ($map) {
        $name = strtolower($name);
        if (!isset($map[$name]))
            return '';
        $col = $map[$name];
        return isset($row[$col]) ? trim((string) $row[$col]) : '';
    };

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    // Query insert termasuk rak dan surat_akses
    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO arsip
    (arsip_waktu_upload, arsip_petugas, arsip_kode, arsip_nama, arsip_kategori, arsip_rak, surat_akses, arsip_keterangan, arsip_file)
    VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    if (!$stmt) {
        throw new Exception('Gagal menyiapkan statement: ' . mysqli_error($koneksi));
    }

    $ok = 0;
    $fail = 0;
    $errors = [];

    foreach ($rows as $i => $row) {
        // Ambil nilai per kolom
        $arsip_kode = $get($row, 'arsip_kode');
        $arsip_nama = $get($row, 'arsip_nama');
        $arsip_jenis = $get($row, 'arsip_jenis');       // boleh kosong
        $arsip_kategori_in = $get($row, 'arsip_kategori');    // bisa ID atau nama
        $arsip_rak_in = $get($row, 'arsip_rak');         // bisa ID atau nama
        $surat_akses_in = $get($row, 'surat_akses');       // bisa ID atau nama
        $arsip_keterangan = $get($row, 'arsip_keterangan');
        $arsip_file = $get($row, 'arsip_file');

        // Lewati baris kosong total
        if ($arsip_kode === '' && $arsip_nama === '' && $arsip_file === '') {
            continue;
        }

        // arsip_jenis kosong? isi dari ekstensi arsip_file
        if ($arsip_jenis === '' && $arsip_file !== '') {
            $arsip_jenis = strtolower(pathinfo($arsip_file, PATHINFO_EXTENSION));
        }

        // arsip_kategori: jika bukan angka, coba lookup by nama
        $arsip_kategori = 0;
        if ($arsip_kategori_in !== '') {
            if (ctype_digit($arsip_kategori_in)) {
                $arsip_kategori = (int) $arsip_kategori_in;
            } else {
                $q = mysqli_prepare($koneksi, "SELECT kategori_id FROM kategori WHERE kategori_nama = ? LIMIT 1");
                mysqli_stmt_bind_param($q, 's', $arsip_kategori_in);
                mysqli_stmt_execute($q);
                mysqli_stmt_bind_result($q, $foundId);
                if (mysqli_stmt_fetch($q)) {
                    $arsip_kategori = (int) $foundId;
                }
                mysqli_stmt_close($q);
            }
        }
        // ---- arsip_rak (ID atau nama) ----
        $arsip_rak = 0;
        if ($arsip_rak_in !== '') {
            if (ctype_digit($arsip_rak_in)) {
                $arsip_rak = (int) $arsip_rak_in;
            } else {
                $q = mysqli_prepare($koneksi, "SELECT rak_id FROM arsip_rak WHERE rak_nama = ? LIMIT 1");
                mysqli_stmt_bind_param($q, 's', $arsip_rak_in);
                mysqli_stmt_execute($q);
                mysqli_stmt_bind_result($q, $foundId);
                if (mysqli_stmt_fetch($q)) {
                    $arsip_rak = (int) $foundId;
                }
                mysqli_stmt_close($q);
            }
        }
        // ---- surat_akses (ID atau nama) ----
        $surat_akses = 0;
        if ($surat_akses_in !== '') {
            if (ctype_digit($surat_akses_in)) {
                $surat_akses = (int) $surat_akses_in;
            } else {
                $q = mysqli_prepare($koneksi, "SELECT akses_id FROM surat_akses WHERE akses_nama = ? LIMIT 1");
                mysqli_stmt_bind_param($q, 's', $surat_akses_in);
                mysqli_stmt_execute($q);
                mysqli_stmt_bind_result($q, $foundId);
                if (mysqli_stmt_fetch($q)) {
                    $surat_akses = (int) $foundId;
                }
                mysqli_stmt_close($q);
            }
        }


        // Validasi minimum (kode & nama sebaiknya ada)
        if ($arsip_kode === '' || $arsip_nama === '') {
            $fail++;
            $errors[] = "Baris " . ($i + 2) . ": 'arsip_kode' dan 'arsip_nama' wajib diisi.";
            continue;
        }

        // Bind & execute (tanpa arsip_jenis)
        mysqli_stmt_bind_param(
            $stmt,
            'issiisss',
            $petugasId,          // i
            $arsip_kode,         // s
            $arsip_nama,         // s
            $arsip_kategori,     // i
            $arsip_rak,          // i
            $surat_akses,        // i
            $arsip_keterangan,   // s
            $arsip_file          // s
        );

        if (!mysqli_stmt_execute($stmt)) {
            $fail++;
            $errors[] = "Baris " . ($i + 2) . ": " . mysqli_stmt_error($stmt);
        } else {
            $ok++;
        }
    }

    // Commit bila minimal ada 1 sukses
    mysqli_commit($koneksi);

    // Tampilan hasil + auto redirect
    $backUrl = 'arsip.php';
    ?>
    <!doctype html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <title>Hasil Import</title>
        <meta http-equiv="refresh" content="3;url=<?php echo htmlspecialchars($backUrl, ENT_QUOTES); ?>">
        <style>
            body {
                font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Helvetica, Arial, sans-serif;
                padding: 24px;
            }

            .box {
                max-width: 680px;
                margin: auto;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 24px
            }

            .ok {
                color: #16a34a;
                font-weight: 600
            }

            .fail {
                color: #dc2626;
                font-weight: 600
            }

            .btn {
                display: inline-block;
                margin-top: 16px;
                padding: 10px 16px;
                border-radius: 10px;
                border: 1px solid #e5e7eb;
                text-decoration: none
            }
        </style>
    </head>

    <body>
        <div class="box">
            <h2>Import Data Arsip</h2>
            <p><span class="ok">Berhasil:</span> <?php echo $ok; ?> baris &nbsp; • &nbsp; <span class="fail">Gagal:</span>
                <?php echo $fail; ?> baris</p>

            <?php if ($fail > 0): ?>
                <details>
                    <summary>Detail error</summary>
                    <ul>
                        <?php foreach ($errors as $e)
                            echo '<li>' . htmlspecialchars($e, ENT_QUOTES) . '</li>'; ?>
                    </ul>
                </details>
            <?php endif; ?>

            <p>Anda akan dialihkan ke halaman data arsip dalam 3 detik…</p>
            <a class="btn" href="<?php echo htmlspecialchars($backUrl, ENT_QUOTES); ?>">Kembali sekarang</a>
        </div>
        <script>
            setTimeout(function () { location.href = "<?php echo addslashes($backUrl); ?>"; }, 3000);
        </script>
    </body>

    </html>
    <?php
    exit;

} catch (Throwable $e) {
    // Gagal total: rollback bila perlu
    if ($koneksi && mysqli_errno($koneksi)) {
        @mysqli_rollback($koneksi);
    }
    http_response_code(500);
    exit('Gagal memproses file: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES));
}
