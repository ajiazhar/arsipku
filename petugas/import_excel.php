<?php
// petugas/import_excel.php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../koneksi.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// cek login
$petugasId = isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;
if ($petugasId <= 0) {
    http_response_code(403);
    exit('Akses ditolak: Anda belum login sebagai petugas.');
}

// cek upload
if (empty($_FILES['file_excel']['tmp_name'])) {
    exit('Tidak ada file yang diupload.');
}

$fileTmp = $_FILES['file_excel']['tmp_name'];
$fileExt = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));
if (!in_array($fileExt, ['xls', 'xlsx'])) {
    exit('Format file tidak valid. Harap upload file .xls atau .xlsx');
}

try {
    $spreadsheet = IOFactory::load($fileTmp);
    $sheet = $spreadsheet->getActiveSheet();

    // Nama ada di C3
    $pencipta = trim((string) $sheet->getCell('C3')->getValue());
    $highestRow = (int) $sheet->getHighestRow();

    if ($pencipta === '') {
        exit('Nama (C3) kosong. Isi C3 pada file Excel.');
    }

    // mulai transaksi
    mysqli_begin_transaction($koneksi);

    // prepared statement: 12 parameter (see binding types below)
    $sql = "INSERT INTO arsip (
        arsip_waktu_upload, arsip_petugas, arsip_kode, arsip_index,
        arsip_nama, arsip_deskripsi, arsip_tahun, arsip_jumlah,
        arsip_sampul, arsip_box, arsip_rak, arsip_keterangan, arsip_kategori
    ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $sql);
    if (!$stmt) {
        throw new Exception('Gagal prepare: ' . mysqli_error($koneksi));
    }

    $ok = 0;
    $fail = 0;
    $errors = [];

    // helper: lookup id by name (returns int id or 0)
    $lookupId = function ($table, $idOrName, $koneksi) {
        $idOrName = trim((string) $idOrName);
        if ($idOrName === '')
            return 0;
        if (ctype_digit($idOrName))
            return (int) $idOrName;

        // tidak angka -> cari berdasarkan nama kolom yang umum
        // asumsi kolom nama di table: kategori_nama, index_nama, rak_nama
        $colName = '';
        if ($table === 'kategori')
            $colName = 'kategori_nama';
        elseif ($table === 'index')
            $colName = 'index_nama';
        elseif ($table === 'arsip_rak')
            $colName = 'rak_nama';
        else
            $colName = null;

        if (!$colName)
            return 0;

        $q = mysqli_prepare($koneksi, "SELECT {$table}_id FROM {$table} WHERE {$colName} = ? LIMIT 1");
        if (!$q)
            return 0;
        mysqli_stmt_bind_param($q, 's', $idOrName);
        mysqli_stmt_execute($q);
        mysqli_stmt_bind_result($q, $foundId);
        $res = 0;
        if (mysqli_stmt_fetch($q))
            $res = (int) $foundId;
        mysqli_stmt_close($q);
        return $res ?: 0;
    };

    // loop mulai baris 7
    for ($row = 7; $row <= $highestRow; $row++) {
        // baca kolom sesuai mapping
        $arsip_kode = trim((string) $sheet->getCell("B{$row}")->getValue()); // B = KODE KLASIFIKASI -> arsip_kode
        $arsip_index_in = trim((string) $sheet->getCell("C{$row}")->getValue()); // C = INDEKS (nama atau id)
        $arsip_deskripsi = trim((string) $sheet->getCell("D{$row}")->getValue()); // D = Uraian informasi
        $tahun_arsip = trim((string) $sheet->getCell("E{$row}")->getValue()); // E = Kurun waktu
        $arsip_jumlah = trim((string) $sheet->getCell("F{$row}")->getValue()); // F = Jumlah
        $arsip_sampul = trim((string) $sheet->getCell("G{$row}")->getValue()); // G = Sampul
        $arsip_box = trim((string) $sheet->getCell("H{$row}")->getValue()); // H = Box
        $arsip_rak_in = trim((string) $sheet->getCell("I{$row}")->getValue()); // I = Rak (nama atau id)
        $arsip_kategori_in = trim((string) $sheet->getCell("K{$row}")->getValue()); // K = Kategori (baru)
        $arsip_keterangan = trim((string) $sheet->getCell("N{$row}")->getValue()); // N = Ket.

        // jika baris kosong (minimal isi) -> skip
        if ($arsip_kode === '' && $arsip_index_in === '' && $arsip_deskripsi === '') {
            continue;
        }

        // validasi minimal: arsip_kode wajib (sesuai mapping), pencipta sudah dicek sebelum
        if ($arsip_kode === '') {
            $fail++;
            $errors[] = "Baris {$row}: kolom KODE (B{$row}) kosong, dilewati.";
            continue;
        }

        // lookup index -> dapatkan id (atau 0 jika tidak ditemukan)
        $arsip_index = 0;
        if ($arsip_index_in !== '') {
            if (ctype_digit($arsip_index_in)) {
                $arsip_index = (int) $arsip_index_in;
            } else {
                // cari di tabel `index`
                $q = mysqli_prepare($koneksi, "SELECT index_id FROM `index` WHERE index_nama = ? LIMIT 1");
                if ($q) {
                    mysqli_stmt_bind_param($q, 's', $arsip_index_in);
                    mysqli_stmt_execute($q);
                    mysqli_stmt_bind_result($q, $foundIndexId);
                    if (mysqli_stmt_fetch($q))
                        $arsip_index = (int) $foundIndexId;
                    mysqli_stmt_close($q);
                }
            }
        }

        // lookup rak -> id atau 0
        $arsip_rak = 0;
        if ($arsip_rak_in !== '') {
            if (ctype_digit($arsip_rak_in)) {
                $arsip_rak = (int) $arsip_rak_in;
            } else {
                $q = mysqli_prepare($koneksi, "SELECT rak_id FROM arsip_rak WHERE rak_nama = ? LIMIT 1");
                if ($q) {
                    mysqli_stmt_bind_param($q, 's', $arsip_rak_in);
                    mysqli_stmt_execute($q);
                    mysqli_stmt_bind_result($q, $foundRakId);
                    if (mysqli_stmt_fetch($q))
                        $arsip_rak = (int) $foundRakId;
                    mysqli_stmt_close($q);
                }
            }
        }

        // lookup kategori -> id atau 0
        $arsip_kategori = 0; // default 0 = tidak berkategori
        if ($arsip_kategori_in !== '') {
            if (ctype_digit($arsip_kategori_in)) {
                $arsip_kategori = (int) $arsip_kategori_in;
            } else {
                $q = mysqli_prepare($koneksi, "SELECT kategori_id FROM kategori WHERE kategori_nama = ? LIMIT 1");
                if ($q) {
                    mysqli_stmt_bind_param($q, 's', $arsip_kategori_in);
                    mysqli_stmt_execute($q);
                    mysqli_stmt_bind_result($q, $foundCatId);
                    if (mysqli_stmt_fetch($q))
                        $arsip_kategori = (int) $foundCatId;
                    mysqli_stmt_close($q);
                }
            }
        }

        // bind & execute
        // parameter types: 
        // 1 i (petugasId)
        // 2 s (arsip_kode)
        // 3 i (arsip_index)
        // 4 s (arsip_nama = pencipta)
        // 5 s (arsip_deskripsi)
        // 6 s (tahun_arsip)
        // 7 s (arsip_jumlah)
        // 8 s (arsip_sampul)
        // 9 s (arsip_box)
        // 10 i (arsip_rak)
        // 11 s (arsip_keterangan)
        // 12 i (arsip_kategori)
        $types = 'isissssssis i'; // a bit spaced for readability below - will remove spaces in actual call

        // remove spaces to get actual type string
        $types = str_replace(' ', '', $types); // becomes "isissssssisi" (12 chars)
        // prepare variables
        $param1 = $petugasId;
        $param2 = $arsip_kode;
        $param3 = $arsip_index;
        $param4 = $pencipta;
        $param5 = $arsip_deskripsi;
        $param6 = $tahun_arsip;
        $param7 = $arsip_jumlah;
        $param8 = $arsip_sampul;
        $param9 = $arsip_box;
        $param10 = $arsip_rak;
        $param11 = $arsip_keterangan;
        $param12 = $arsip_kategori;

        // bind param (use references)
        mysqli_stmt_bind_param(
            $stmt,
            $types,
            $param1,
            $param2,
            $param3,
            $param4,
            $param5,
            $param6,
            $param7,
            $param8,
            $param9,
            $param10,
            $param11,
            $param12
        );

        if (!mysqli_stmt_execute($stmt)) {
            $fail++;
            $errors[] = "Baris {$row}: " . mysqli_stmt_error($stmt);
        } else {
            $ok++;
        }
    } // end for

    if ($fail > 0) {
        mysqli_rollback($koneksi);
        echo "Import selesai dengan error. Berhasil: {$ok}, Gagal: {$fail}<br>";
        echo implode('<br>', $errors);
    } else {
        mysqli_commit($koneksi);
        echo "✅ Import sukses. Baris berhasil: {$ok}";
    }

} catch (Exception $e) {
    if (isset($koneksi) && mysqli_connect_errno() === 0)
        mysqli_rollback($koneksi);
    exit('Terjadi kesalahan: ' . $e->getMessage());

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    exit("Terjadi kesalahan: " . $e->getMessage());


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
