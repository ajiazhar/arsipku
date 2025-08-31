<?php
// Pastikan file ini dipanggil dari lokasi yang benar, misal dari direktori 'functions'
// Dan koneksi database sudah ada
require_once __DIR__ . '/SimpleXLSX.php'; // Pastikan file SimpleXLSX.php ada di direktori ini

use Shuchkin\SimpleXLSX; // Impor namespace yang benar

function importExcelArsip($file_path, $koneksi)
{
    $result = [
        'success' => false,
        'message' => '',
        'imported' => 0,
        'errors' => []
    ];

    try {
        // Memeriksa apakah file SimpleXLSX.php ada
        if (!file_exists(__DIR__ . '/SimpleXLSX.php')) {
            throw new Exception("File SimpleXLSX.php tidak ditemukan di " . __DIR__);
        }

        // Memeriksa apakah file Excel ada
        if (!file_exists($file_path)) {
            $result['message'] = 'File tidak ditemukan';
            return $result;
        }

        // Parsing file Excel dengan kelas yang benar
        $xlsx = SimpleXLSX::parse($file_path);
        if ($xlsx === false) {
            $result['message'] = 'File Excel tidak valid atau rusak: ' . SimpleXLSX::parseError();
            return $result;
        }

        // Mengambil semua baris dari file Excel
        $rows = $xlsx->rows();

        // Memeriksa apakah file Excel kosong atau hanya berisi header
        if (count($rows) < 2) {
            $result['message'] = 'File Excel kosong atau tidak ada data';
            return $result;
        }

        // Mulai transaksi database
        if (!method_exists($koneksi, 'begin_transaction')) {
            throw new Exception("Koneksi database tidak mendukung transaksi.");
        }
        $koneksi->begin_transaction();

        // Melewati baris header
        array_shift($rows);

        $imported_count = 0;

        foreach ($rows as $index => $row) {
            $row_number = $index + 2;

            // Melewati baris yang kosong sepenuhnya
            if (empty(array_filter($row))) {
                continue;
            }

            // Mapping data dari baris Excel (sesuaikan dengan urutan kolom template)
            $arsip_waktu = !empty($row[1]) ? date('Y-m-d H:i:s', strtotime($row[1])) : date('Y-m-d H:i:s');
            $arsip_kode = trim($row[2] ?? '');
            $arsip_nama = trim($row[3] ?? '');
            $arsip_jenis = trim($row[4] ?? '');
            $kategori_nama = trim($row[5] ?? '');
            $petugas_nama = trim($row[6] ?? '');
            $arsip_keterangan = trim($row[7] ?? '');

            // Validasi data wajib
            if (empty($arsip_kode) || empty($arsip_nama)) {
                $result['errors'][] = "Baris $row_number: Kode dan Nama Arsip wajib diisi";
                continue;
            }

            // Cek duplikasi kode arsip
            $check_sql = "SELECT arsip_id FROM arsip WHERE arsip_kode = ? LIMIT 1";
            $check_stmt = $koneksi->prepare($check_sql);
            if (!$check_stmt) {
                throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
            }
            $check_stmt->bind_param("s", $arsip_kode);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            if ($check_result->num_rows > 0) {
                $result['errors'][] = "Baris $row_number: Kode '$arsip_kode' sudah ada";
                $check_stmt->close();
                continue;
            }
            $check_stmt->close();

            // Validasi dan ambil ID kategori
            $kategori_id = null;
            if (!empty($kategori_nama)) {
                $kat_sql = "SELECT kategori_id FROM kategori WHERE kategori_nama = ? LIMIT 1";
                $kat_stmt = $koneksi->prepare($kat_sql);
                if (!$kat_stmt) {
                    throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
                }
                $kat_stmt->bind_param("s", $kategori_nama);
                $kat_stmt->execute();
                $kat_result = $kat_stmt->get_result();
                $kat_row = $kat_result->fetch_assoc();
                if ($kat_row) {
                    $kategori_id = $kat_row['kategori_id'];
                } else {
                    $result['errors'][] = "Baris $row_number: Kategori '$kategori_nama' tidak ditemukan";
                    $kat_stmt->close();
                    continue;
                }
                $kat_stmt->close();
            }

            // Validasi dan ambil ID petugas
            $petugas_id = null;
            if (!empty($petugas_nama)) {
                $pet_sql = "SELECT petugas_id FROM petugas WHERE petugas_nama = ? LIMIT 1";
                $pet_stmt = $koneksi->prepare($pet_sql);
                if (!$pet_stmt) {
                    throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
                }
                $pet_stmt->bind_param("s", $petugas_nama);
                $pet_stmt->execute();
                $pet_result = $pet_stmt->get_result();
                $pet_row = $pet_result->fetch_assoc();

                if ($pet_row) {
                    $petugas_id = $pet_row['petugas_id'];
                } else {
                    $pet_stmt->close();
                    $user_sql = "SELECT user_id FROM user WHERE user_nama = ? LIMIT 1";
                    $user_stmt = $koneksi->prepare($user_sql);
                    if (!$user_stmt) {
                        throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
                    }
                    $user_stmt->bind_param("s", $petugas_nama);
                    $user_stmt->execute();
                    $user_result = $user_stmt->get_result();
                    $user_row = $user_result->fetch_assoc();

                    if ($user_row) {
                        $petugas_id = $user_row['user_id'];
                    } else {
                        $result['errors'][] = "Baris $row_number: Petugas '$petugas_nama' tidak ditemukan";
                        $user_stmt->close();
                        continue;
                    }
                    $user_stmt->close();
                }
            }

            // Insert data ke tabel arsip
            $insert_sql = "INSERT INTO arsip (arsip_waktu_upload, arsip_kode, arsip_nama, arsip_jenis, arsip_kategori, arsip_petugas, arsip_keterangan, arsip_file) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, NULL)";
            $insert_stmt = $koneksi->prepare($insert_sql);
            if (!$insert_stmt) {
                throw new Exception("Gagal mempersiapkan statement: " . $koneksi->error);
            }

            // Pastikan semua parameter memiliki nilai yang valid sebelum binding
            $kategori_id = $kategori_id ?: null;
            $petugas_id = $petugas_id ?: null;

            $insert_stmt->bind_param(
                "ssssiss",
                $arsip_waktu,
                $arsip_kode,
                $arsip_nama,
                $arsip_jenis,
                $kategori_id,
                $petugas_id,
                $arsip_keterangan
            );

            if ($insert_stmt->execute()) {
                $imported_count++;
            } else {
                $result['errors'][] = "Baris $row_number: Gagal menyimpan ke database: " . $insert_stmt->error;
            }
            $insert_stmt->close();
        }

        // Selesaikan transaksi
        if (empty($result['errors'])) {
            $koneksi->commit();
            $result['success'] = true;
            $result['imported'] = $imported_count;
            $result['message'] = "Berhasil mengimport $imported_count data arsip.";
        } else {
            $koneksi->rollback();
            $result['message'] = "Import selesai dengan beberapa kesalahan. " . count($result['errors']) . " baris gagal diimport.";
        }

        if ($imported_count == 0 && empty($result['errors'])) {
            $result['message'] = "Tidak ada data valid untuk diimport";
        }

    } catch (Exception $e) {
        if (isset($koneksi) && $koneksi->in_transaction) {
            $koneksi->rollback();
        }
        $result['message'] = 'Error sistem: ' . $e->getMessage();
    }

    return $result;
}