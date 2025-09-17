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
    $arsip_nama = trim((string) $sheet->getCell('C3')->getValue());
    $highestRow = (int) $sheet->getHighestRow();

    if ($arsip_nama === '') {
        exit('Nama (C3) kosong. Isi C3 pada file Excel.');
    }

    // mulai transaksi
    mysqli_begin_transaction($koneksi);

    // prepared statement: 12 parameter (see binding types below)
    $sql = "INSERT INTO arsip (
    arsip_petugas,
    arsip_kode,
    arsip_index,
    arsip_nama,
    arsip_deskripsi,
    arsip_tahun,
    arsip_jumlah,
    arsip_sampul,
    arsip_box,
    arsip_rak,
    arsip_kategori,
    surat_akses,
    arsip_keterangan
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
        $arsip_tahun = trim((string) $sheet->getCell("E{$row}")->getValue()); // E = Kurun waktu
        $arsip_jumlah = trim((string) $sheet->getCell("F{$row}")->getValue()); // F = Jumlah
        $arsip_sampul = trim((string) $sheet->getCell("G{$row}")->getValue()); // G = Sampul
        $arsip_box = trim((string) $sheet->getCell("H{$row}")->getValue()); // H = Box
        $arsip_rak_in = trim((string) $sheet->getCell("I{$row}")->getValue()); // I = Rak (nama atau id)
        $arsip_kategori_in = trim((string) $sheet->getCell("J{$row}")->getValue()); // J = Kategori (baru)
        $surat_akses_in = trim((string) $sheet->getCell("K" . $row)->getValue()); // K = akses nama
        $arsip_keterangan = trim((string) $sheet->getCell("L{$row}")->getValue()); // L = Ket.

        // jika baris kosong (minimal isi) -> skip
        if ($arsip_kode === '' && $arsip_index_in === '' && $arsip_deskripsi === '') {
            continue;
        }

        // validasi minimal: arsip_kode wajib (sesuai mapping), arsip_nama sudah dicek sebelum
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

        // Default jika tidak ditemukan
        $surat_akses = 0;
        if ($surat_akses_in !== '') {
            if (ctype_digit($surat_akses_in)) {
                $surat_akses = (int) $surat_akses_in;
            } else {
                $q = mysqli_prepare($koneksi, "SELECT akses_id FROM surat_akses WHERE akses_nama = ? LIMIT 1");
                if ($q) {
                    mysqli_stmt_bind_param($q, 's', $surat_akses_in);
                    mysqli_stmt_execute($q);
                    mysqli_stmt_bind_result($q, $foundAksesId);
                    if (mysqli_stmt_fetch($q))
                        $surat_akses = (int) $foundAksesId;
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
        // 4 s (arsip_nama = arsip_nama)
        // 5 s (arsip_deskripsi)
        // 6 s (arsip_tah$arsip_tahun)
        // 7 s (arsip_jumlah)
        // 8 s (arsip_sampul)
        // 9 s (arsip_box)
        // 10 i (arsip_rak)
        // 11 s (arsip_keterangan)
        // 12 i (arsip_kategori)
        $types = "isissssssiiis";

        $types = str_replace(' ', '', $types); // becomes "isissssssisi" (12 chars)

        $param1 = $petugasId;
        $param2 = $arsip_kode;       // kolom B
        $param3 = $arsip_index;      // kolom C
        $param4 = $arsip_nama;       // dari C3 (sama semua baris)
        $param5 = $arsip_deskripsi;  // kolom D
        $param6 = $arsip_tahun;      // kolom E
        $param7 = $arsip_jumlah;     // kolom F
        $param8 = $arsip_sampul;     // kolom G
        $param9 = $arsip_box;        // kolom H
        $param10 = $arsip_rak;        // kolom I
        $param11 = $arsip_kategori;   // kolom J
        $param12 = $surat_akses;      // kolom K
        $param13 = $arsip_keterangan; // kolom L

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
            $param12,
            $param13
        );


        if (!mysqli_stmt_execute($stmt)) {
            $fail++;
            $errors[] = "Baris {$row}: " . mysqli_stmt_error($stmt);
        } else {
            $ok++;
        }
    } // end for

    // Commit bila minimal ada 1 sukses
    mysqli_commit($koneksi);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'ok',
        'success' => $ok,
        'fail' => $fail,
        'errors' => $errors
    ]);
    exit;

} catch (Throwable $e) {
    if ($koneksi && mysqli_errno($koneksi)) {
        @mysqli_rollback($koneksi);
    }
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}
