-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Agu 2025 pada 04.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_arsip`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_nama` varchar(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_nama`, `admin_username`, `admin_password`, `admin_foto`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', '589321099_DSC03129.JPG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip`
--

CREATE TABLE `arsip` (
  `arsip_id` int(11) NOT NULL,
  `arsip_waktu_upload` datetime NOT NULL,
  `arsip_petugas` int(11) NOT NULL,
  `arsip_kode` varchar(255) NOT NULL,
  `arsip_nama` varchar(255) NOT NULL,
  `arsip_jenis` varchar(255) NOT NULL,
  `arsip_kategori` int(11) NOT NULL,
  `arsip_keterangan` text NOT NULL,
  `arsip_rak` int(11) DEFAULT NULL,
  `surat_akses` int(11) DEFAULT NULL,
  `arsip_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `arsip`
--

INSERT INTO `arsip` (`arsip_id`, `arsip_waktu_upload`, `arsip_petugas`, `arsip_kode`, `arsip_nama`, `arsip_jenis`, `arsip_kategori`, `arsip_keterangan`, `arsip_rak`, `surat_akses`, `arsip_file`) VALUES
(2, '2019-10-10 15:09:59', 4, 'ARSIP-MN-0002', 'File keberngkatan', 'png', 4, 'tes ttead', NULL, NULL, '1162363338_Screen Shot 2019-10-10 at 13.22.15.png'),
(3, '2019-10-10 16:02:44', 4, 'asda', 'asdasd 2x', 'pdf', 3, 'asdasd', NULL, NULL, '432536246_mamunur.pdf'),
(4, '2019-10-12 17:02:16', 5, 'MN-002', 'Contoh Surat Izin Pelaksanaan', 'pdf', 4, 'Ini Contoh Surat Izin Pelaksanaan', NULL, NULL, '1352467019_c4611_sample_explain.pdf'),
(5, '2019-10-12 17:03:01', 5, 'MN-003', 'Contoh Keputusan Kerja', 'pdf', 3, 'Contoh Keputusan Kerja pegawai', NULL, NULL, '1765932248_Contoh-surat-lamaran-kerja-pdf (1).pdf'),
(6, '2019-10-12 17:03:37', 5, 'MN-004', 'Contoh Surat Izin Pegawai', 'pdf', 7, 'berikut Contoh Surat Izin Pegawai untuk pelaksana kerja', NULL, NULL, '1651167980_instructions-for-adding-your-logo.pdf'),
(7, '2019-10-12 17:04:30', 5, 'MN-005', 'Contoh SPK Proyek Kontraktor', 'pdf', 5, 'Contoh SPK Proyek Kontraktor adalah contoh surat SPK KONTRAK', NULL, NULL, '142845393_OoPdfFormExample.pdf'),
(8, '2019-10-12 17:05:22', 5, 'MN-006', 'SPK Kontrak Jembatan', 'pdf', 6, 'Surat SPK Kontrak Jembatan Layang', NULL, NULL, '106615077_sample-link_1.pdf'),
(9, '2019-10-12 17:06:55', 6, 'MN-008', 'Contoh Curiculum Vitae Untuk Lamaran Kerja', 'pdf', 10, 'Contoh Curiculum Vitae Untuk Lamaran Kerja untuk pegawai baru', NULL, NULL, '927990343_pdf-sample(1).pdf'),
(10, '2019-10-12 17:07:30', 6, 'MN-009', 'Surat Cuti Sakit Pegawai', 'pdf', 7, 'Contoh Surat Cuti Sakit Pegawai baru', NULL, NULL, '2071946811_PEMBUATAN FILE PDF_FNH_tamim (1).pdf'),
(15, '2025-08-14 11:01:43', 5, 'ARSIP-20250814060121', 'tes tos', 'doc', 4, 'aji', NULL, NULL, '1755144103_tes-tos.doc'),
(231, '2025-08-27 11:28:50', 7, 'ARSIP-20250827062837', 'ajiazhar', 'pdf', 7, 'fadsfaseqr', 7, 6, 'ARSIP-20250827062837.pdf'),
(286, '2025-08-28 23:20:52', 8, 'A001', 'Surat Masuk 1', 'xlsx', 1, 'Uji coba import', 6, 1, '554113030_coba1.xlsx'),
(296, '2025-08-31 07:35:56', 8, '200', 'Jurnal', 'png', 1, 'Laporan kerja praktek', 12, 6, '1780733754_SnapInsta.to_416039682_1374476396494771_8231277102212196809_n 1.png'),
(298, '2025-08-31 07:36:38', 8, 'A006', 'Nota Dinas 21', '', 3, 'Arsip', 7, 2, ''),
(299, '2025-08-31 07:36:38', 8, 'A007', 'Nota Dinas 25', '', 6, 'Arsip uji', 12, 4, ''),
(300, '2025-08-31 07:36:38', 8, 'A008', 'Nota Dinas 23', '', 5, 'Arsip uji coba', 8, 6, ''),
(301, '2025-08-31 07:38:00', 8, '100', 'Surat balasan intansi', 'pdf', 14, 'aji', 13, 6, '100.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip_rak`
--

CREATE TABLE `arsip_rak` (
  `rak_id` int(11) NOT NULL,
  `rak_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `arsip_rak`
--

INSERT INTO `arsip_rak` (`rak_id`, `rak_nama`) VALUES
(6, 'A'),
(7, 'B'),
(8, 'C'),
(12, 'D'),
(13, 'E');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_nama` varchar(255) NOT NULL,
  `kategori_keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_nama`, `kategori_keterangan`) VALUES
(1, 'Tidak berkategori', 'Semua yang tidak memiliki kategori'),
(3, 'Surat Keputusan', 'Format arsip untuk surat keputusan\r\n'),
(4, 'Surat Izin Pelaksanaan', 'Contoh format surat izin pelaksaan pekerjaan'),
(5, 'Surat Perintah Kerja Proyek jalan', 'Contoh format surat perintah untuk pekerjaan proyek jalan'),
(6, 'Surat Perintah Kerja Proyek Jembatan', 'Contoh format untuk surat perintah kerja proyek jembatan'),
(7, 'Surat Kesehatan Pegawai', 'Surat kesehatan untuk pegawai'),
(8, 'Surat Lampiran Skripsi', 'Surat contoh lampiran untuk skripsi'),
(10, 'Curiculum Vitae', 'Contoh format surat curiculum vitae untuk kenaikan jabatan'),
(14, 'Surat Izin Sakit', 'sakitt');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `petugas_id` int(11) NOT NULL,
  `petugas_nama` varchar(255) NOT NULL,
  `petugas_username` varchar(255) NOT NULL,
  `petugas_password` varchar(255) NOT NULL,
  `petugas_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`petugas_id`, `petugas_nama`, `petugas_username`, `petugas_password`, `petugas_foto`) VALUES
(4, 'Vikrih Yanto', 'petugas1', '202cb962ac59075b964b07152d234b70', ''),
(5, 'Junaidi Mus', 'petugas2', 'ac5604a8b8504d4ff5b842480df02e91', ''),
(8, 'ihsanhz', 'ihsan', '81dc9bdb52d04dc20036dbd8313ed055', '279437702_DSC03173.JPG'),
(9, 'aji', 'aji2', '202cb962ac59075b964b07152d234b70', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `riwayat_id` int(11) NOT NULL,
  `riwayat_waktu` datetime NOT NULL,
  `riwayat_user` int(11) NOT NULL,
  `riwayat_arsip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`riwayat_id`, `riwayat_waktu`, `riwayat_user`, `riwayat_arsip`) VALUES
(1, '2019-10-11 15:32:29', 8, 3),
(2, '2019-10-12 17:09:31', 8, 10),
(3, '2019-10-12 17:09:45', 8, 9),
(4, '2019-10-12 17:09:50', 8, 8),
(5, '2019-10-12 17:09:53', 8, 3),
(6, '2019-10-12 17:10:07', 9, 10),
(7, '2019-10-12 17:10:16', 9, 9),
(8, '2019-10-12 17:10:19', 9, 8),
(9, '2019-10-12 17:10:22', 9, 6),
(10, '2019-10-12 17:10:26', 9, 2),
(11, '2021-11-11 22:25:05', 13, 11),
(12, '2025-08-27 20:53:45', 15, 231),
(13, '2025-08-29 21:21:03', 11, 290),
(14, '2025-08-31 07:39:59', 11, 301),
(15, '2025-08-31 07:40:33', 11, 300);

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_akses`
--

CREATE TABLE `surat_akses` (
  `akses_id` int(11) NOT NULL,
  `akses_nama` varchar(100) NOT NULL,
  `akses_keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `surat_akses`
--

INSERT INTO `surat_akses` (`akses_id`, `akses_nama`, `akses_keterangan`) VALUES
(1, 'Publik', NULL),
(2, 'Pemerintah', NULL),
(3, 'Presiden', 'untuk presiden'),
(4, 'Internal', 'khusus internal'),
(6, 'kerja praktek', 'kerja praktek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(100) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_nama`, `user_username`, `user_password`, `user_foto`) VALUES
(8, 'Samsul Bahri', 'user1', '24c9e15e52afc47c225b757e7bee1f9d', ''),
(9, 'Reza Yuzanni', 'user2', '7e58d63b60197ceb55a1c487989a3720', ''),
(10, 'Ajir Muhajier', 'user3', '92877af70a45fd6a2ed7fe81e1236b78', ''),
(11, 'aji', 'aji', '202cb962ac59075b964b07152d234b70', '982689687_DSC03144.JPG'),
(16, 'ihsan', 'ihsan2', '202cb962ac59075b964b07152d234b70', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `foto`, `role`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', '1542866784_Screenshot (7).png', 'admin'),
(2, 'Vikrih Yanto', 'petugas1', '202cb962ac59075b964b07152d234b70', '', 'petugas'),
(3, 'Junaidi Mus', 'petugas2', 'ac5604a8b8504d4ff5b842480df02e91', '', 'petugas'),
(4, 'ihsanhk', 'ihsan', '202cb962ac59075b964b07152d234b70', '', 'petugas'),
(5, 'Samsul Bahri', 'user1', '24c9e15e52afc47c225b757e7bee1f9d', '', 'user'),
(6, 'Reza Yuzanni', 'user2', '7e58d63b60197ceb55a1c487989a3720', '', 'user'),
(7, 'Ajir Muhajier', 'user3', '92877af70a45fd6a2ed7fe81e1236b78', '', 'user'),
(8, 'aji', 'aji', '202cb962ac59075b964b07152d234b70', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`arsip_id`),
  ADD KEY `surat_akses` (`surat_akses`);

--
-- Indeks untuk tabel `arsip_rak`
--
ALTER TABLE `arsip_rak`
  ADD PRIMARY KEY (`rak_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`petugas_id`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`riwayat_id`);

--
-- Indeks untuk tabel `surat_akses`
--
ALTER TABLE `surat_akses`
  ADD PRIMARY KEY (`akses_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `arsip`
--
ALTER TABLE `arsip`
  MODIFY `arsip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT untuk tabel `arsip_rak`
--
ALTER TABLE `arsip_rak`
  MODIFY `rak_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `petugas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `riwayat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `surat_akses`
--
ALTER TABLE `surat_akses`
  MODIFY `akses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `arsip`
--
ALTER TABLE `arsip`
  ADD CONSTRAINT `fk_arsip_surat_akses` FOREIGN KEY (`surat_akses`) REFERENCES `surat_akses` (`akses_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
