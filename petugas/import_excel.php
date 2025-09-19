<?php
// petugas/import_excel.php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../koneksi.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

header('Content-Type: application/json; charset=utf-8');

try {
    // cek login
    $petugasId = isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;
    if ($petugasId <= 0) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Akses ditolak: Anda belum login.']);
        exit;
    }

    // cek upload
    if (empty($_FILES['file_excel']['tmp_name'])) {
        throw new Exception('Tidak ada file yang diupload.');
    }

    $fileTmp = $_FILES['file_excel']['tmp_name'];
    $fileExt = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExt, ['xls', 'xlsx'])) {
        throw new Exception('Format file tidak valid. Harap upload file .xls atau .xlsx');
    }

    // load spreadsheet
    $spreadsheet = IOFactory::load($fileTmp);
    $sheet = $spreadsheet->getActiveSheet();

    // ambil arsip_nama (C3) dan arsip_bidang (B4)
    $arsip_nama = trim((string) $sheet->getCell('C3')->getValue());
    $arsip_bidang = trim((string) $sheet->getCell('C4')->getValue());

    if ($arsip_nama === '') {
        throw new Exception('Nama (C3) kosong. Isi C3 pada file Excel.');
    }
    if ($arsip_bidang === '') {
        // Opsional: bisa dibuat tidak wajib — jika wajib, keep this exception
        // throw new Exception('Bidang (B4) kosong. Isi B4 pada file Excel.');
        // Jika tidak wajib, uncomment baris di atas dan hapus exception di bawah.
        $arsip_bidang = null;
    }

    $highestRow = (int) $sheet->getHighestRow();
    if ($highestRow < 7) {
        throw new Exception('File tidak memiliki data pada baris 7 ke bawah.');
    }

    // lookup helper: menerima ID atau nama; mengembalikan int id (0 jika tidak ditemukan/kosong)
    $lookupId = function ($table, $value, $koneksi) {
        $value = trim((string) $value);
        if ($value === '')
            return 0;
        if (ctype_digit($value))
            return (int) $value;

        // mapping kolom nama untuk tiap table
        $map = [
            'kategori' => ['id_col' => 'kategori_id', 'name_col' => 'kategori_nama'],
            'index' => ['id_col' => 'index_id', 'name_col' => 'index_nama'],
            'arsip_rak' => ['id_col' => 'rak_id', 'name_col' => 'rak_nama'],
            'surat_akses' => ['id_col' => 'akses_id', 'name_col' => 'akses_nama'],
        ];
        if (!isset($map[$table]))
            return 0;

        $idCol = $map[$table]['id_col'];
        $nameCol = $map[$table]['name_col'];
        $q = mysqli_prepare($koneksi, "SELECT {$idCol} FROM `{$table}` WHERE {$nameCol} = ? LIMIT 1");
        if (!$q)
            return 0;
        mysqli_stmt_bind_param($q, 's', $value);
        mysqli_stmt_execute($q);
        mysqli_stmt_bind_result($q, $foundId);
        $res = 0;
        if (mysqli_stmt_fetch($q))
            $res = (int) $foundId;
        mysqli_stmt_close($q);
        return $res ?: 0;
    };

    // mulai transaksi
    mysqli_begin_transaction($koneksi);

    // PREPARE INSERT
    // Perhatikan: kita menggunakan NULLIF(?,0) untuk kolom FK (index, rak, kategori, surat_akses)
    $sql = "INSERT INTO arsip (
                arsip_waktu_upload,
                arsip_petugas,
                arsip_kode,
                arsip_index,
                arsip_nama,
                arsip_bidang,
                arsip_deskripsi,
                arsip_tahun,
                arsip_jumlah,
                arsip_sampul,
                arsip_box,
                arsip_rak,
                arsip_keterangan,
                arsip_kategori,
                surat_akses
            ) VALUES (
                NOW(), ?, ?, NULLIF(?,0), ?, ?, ?, ?, ?, ?, ?, NULLIF(?,0), ?, NULLIF(?,0), NULLIF(?,0)
            )";

    $stmt = mysqli_prepare($koneksi, $sql);
    if (!$stmt)
        throw new Exception('Gagal prepare: ' . mysqli_error($koneksi));

    $startRow = 7; // ubah jika data mulai di baris lain
    $ok = 0;
    $fail = 0;
    $errors = [];

    for ($row = $startRow; $row <= $highestRow; $row++) {
        // baca kolom B..L sesuai mapping final
        $arsip_kode_in = trim((string) $sheet->getCell("B{$row}")->getValue()); // B
        $arsip_index_in = trim((string) $sheet->getCell("C{$row}")->getValue()); // C
        $arsip_deskripsi = trim((string) $sheet->getCell("D{$row}")->getValue()); // D
        $tahun_in = trim((string) $sheet->getCell("E{$row}")->getValue()); // E
        $arsip_jumlah = trim((string) $sheet->getCell("F{$row}")->getValue()); // F
        $arsip_sampul = trim((string) $sheet->getCell("G{$row}")->getValue()); // G
        $arsip_box = trim((string) $sheet->getCell("H{$row}")->getValue()); // H
        $arsip_rak_in = trim((string) $sheet->getCell("I{$row}")->getValue()); // I
        $arsip_kategori_in = trim((string) $sheet->getCell("J{$row}")->getValue()); // J
        $surat_akses_in = trim((string) $sheet->getCell("K{$row}")->getValue()); // K
        $arsip_keterangan = trim((string) $sheet->getCell("L{$row}")->getValue()); // L

        // skip baris kosong minimal
        if ($arsip_kode_in === '' && $arsip_index_in === '' && $arsip_deskripsi === '') {
            continue;
        }

        // validasi minimal
        if ($arsip_kode_in === '') {
            $fail++;
            $errors[] = "Baris {$row}: kolom KODE (B{$row}) kosong — dilewati.";
            continue;
        }

        // mapping lookup (menghasilkan id integer atau 0)
        $arsip_index = $lookupId('index', $arsip_index_in, $koneksi);
        $arsip_rak = $lookupId('arsip_rak', $arsip_rak_in, $koneksi);
        $arsip_kategori = $lookupId('kategori', $arsip_kategori_in, $koneksi);
        $surat_akses = $lookupId('surat_akses', $surat_akses_in, $koneksi);

        // konversi tahun (integer jika numeric)
        $tahun_arsip = 0;
        if ($tahun_in !== '' && ctype_digit($tahun_in))
            $tahun_arsip = (int) $tahun_in;

        // siapkan parameter (14 param sesuai INSERT)
        $param1 = $petugasId;           // i
        $param2 = $arsip_kode_in;       // s
        $param3 = $arsip_index;         // i (NULLIF -> jadi NULL jika 0)
        $param4 = $arsip_nama;          // s (C3)
        $param5 = $arsip_bidang;        // s (B4) -- bisa null
        $param6 = $arsip_deskripsi;     // s
        $param7 = $tahun_arsip;         // i
        $param8 = $arsip_jumlah;        // s
        $param9 = $arsip_sampul;        // s
        $param10 = $arsip_box;           // s
        $param11 = $arsip_rak;           // i (NULLIF)
        $param12 = $arsip_keterangan;    // s
        $param13 = $arsip_kategori;      // i (NULLIF)
        $param14 = $surat_akses;         // i (NULLIF)

        // types string (14 params): i s i s s s i s s s i s i i
        $types = 'isisssisssisi i'; // human readable
        $types = str_replace(' ', '', $types); // hasil: 'isisssisssisi i i' -> remove spaces

        // Build the final types exactly:
        // faster/bulletproof: set directly:
        $types = 'isisssisssisii'; // matches param order above (14 chars)

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
            $param13,
            $param14
        );

        if (!mysqli_stmt_execute($stmt)) {
            $fail++;
            $errors[] = "Baris {$row}: " . mysqli_stmt_error($stmt);
        } else {
            $ok++;
        }
    } // end loop

    if ($fail > 0) {
        mysqli_rollback($koneksi);
        echo json_encode(['status' => 'partial', 'success' => $ok, 'fail' => $fail, 'errors' => $errors]);
        exit;
    }

    mysqli_commit($koneksi);
    echo json_encode(['status' => 'ok', 'success' => $ok, 'fail' => $fail, 'errors' => $errors]);
    exit;

} catch (Exception $e) {
    if (isset($koneksi) && mysqli_connect_errno() === 0) {
        @mysqli_rollback($koneksi);
    }
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}
