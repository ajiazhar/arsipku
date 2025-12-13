-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Des 2025 pada 03.14
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
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', '237011684_Screenshot1.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip`
--

CREATE TABLE `arsip` (
  `arsip_id` int(11) NOT NULL,
  `arsip_waktu_upload` datetime NOT NULL,
  `arsip_tahun` year(4) DEFAULT NULL,
  `arsip_petugas` int(11) NOT NULL,
  `arsip_kode` varchar(255) NOT NULL,
  `arsip_bidang` varchar(100) DEFAULT NULL,
  `arsip_nama` varchar(255) NOT NULL,
  `arsip_kategori` int(11) NOT NULL,
  `arsip_keterangan` text NOT NULL,
  `arsip_deskripsi` text DEFAULT NULL,
  `arsip_sampul` varchar(50) DEFAULT NULL,
  `arsip_index` int(11) DEFAULT NULL,
  `arsip_box` varchar(50) DEFAULT NULL,
  `arsip_rak` varchar(100) DEFAULT NULL,
  `arsip_jumlah` varchar(100) DEFAULT NULL,
  `surat_akses` int(11) DEFAULT NULL,
  `arsip_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `arsip`
--

INSERT INTO `arsip` (`arsip_id`, `arsip_waktu_upload`, `arsip_tahun`, `arsip_petugas`, `arsip_kode`, `arsip_bidang`, `arsip_nama`, `arsip_kategori`, `arsip_keterangan`, `arsip_deskripsi`, `arsip_sampul`, `arsip_index`, `arsip_box`, `arsip_rak`, `arsip_jumlah`, `surat_akses`, `arsip_file`) VALUES
(2, '2019-10-10 15:09:59', NULL, 4, 'ARSIP-MN-0002', NULL, 'File keberngkatan', 4, 'tes ttead', NULL, NULL, NULL, NULL, NULL, '0', NULL, '1162363338_Screen Shot 2019-10-10 at 13.22.15.png'),
(3, '2019-10-10 16:02:44', NULL, 4, 'asda', NULL, 'asdasd 2x', 3, 'asdasd', NULL, NULL, NULL, NULL, NULL, '0', NULL, '432536246_mamunur.pdf'),
(4, '2019-10-12 17:02:16', NULL, 5, 'MN-002', NULL, 'Contoh Surat Izin Pelaksanaan', 4, 'Ini Contoh Surat Izin Pelaksanaan', NULL, NULL, NULL, NULL, NULL, '0', NULL, '1352467019_c4611_sample_explain.pdf'),
(5, '2019-10-12 17:03:01', NULL, 5, 'MN-003', NULL, 'Contoh Keputusan Kerja', 3, 'Contoh Keputusan Kerja pegawai', NULL, NULL, NULL, NULL, NULL, '0', NULL, '1765932248_Contoh-surat-lamaran-kerja-pdf (1).pdf'),
(6, '2019-10-12 17:03:37', NULL, 5, 'MN-004', NULL, 'Contoh Surat Izin Pegawai', 7, 'berikut Contoh Surat Izin Pegawai untuk pelaksana kerja', NULL, NULL, NULL, NULL, NULL, '0', NULL, '1651167980_instructions-for-adding-your-logo.pdf'),
(7, '2019-10-12 17:04:30', NULL, 5, 'MN-005', NULL, 'Contoh SPK Proyek Kontraktor', 5, 'Contoh SPK Proyek Kontraktor adalah contoh surat SPK KONTRAK', NULL, NULL, NULL, NULL, NULL, '0', NULL, '142845393_OoPdfFormExample.pdf'),
(8, '2019-10-12 17:05:22', NULL, 5, 'MN-006', NULL, 'SPK Kontrak Jembatan', 6, 'Surat SPK Kontrak Jembatan Layang', NULL, NULL, NULL, NULL, NULL, '0', NULL, '106615077_sample-link_1.pdf'),
(9, '2019-10-12 17:06:55', NULL, 6, 'MN-008', NULL, 'Contoh Curiculum Vitae Untuk Lamaran Kerja', 10, 'Contoh Curiculum Vitae Untuk Lamaran Kerja untuk pegawai baru', NULL, NULL, NULL, NULL, NULL, '0', NULL, '927990343_pdf-sample(1).pdf'),
(10, '2019-10-12 17:07:30', NULL, 6, 'MN-009', NULL, 'Surat Cuti Sakit Pegawai', 7, 'Contoh Surat Cuti Sakit Pegawai baru', NULL, NULL, NULL, NULL, NULL, '0', NULL, '2071946811_PEMBUATAN FILE PDF_FNH_tamim (1).pdf'),
(383, '2025-09-18 08:48:26', '2025', 4, '900', 'TES', 'intansi Kesehatan', 3, 'Baik', 'SP2D No. 440/LS/2010 Keg. Pembinaan, pengendalian dan pengawasan gerakan rehabilitasi hutan dan lahan (DAK) Rp. 43.401.868', '19', 4, '2', NULL, '1 Bundel', NULL, ''),
(458, '2025-12-04 20:27:56', '2010', 11, '900', 'dispusip', 'dinas keshatan', 3, 'Baik', 'SP2D No. 7047/GU/2010 Keg. Rapat rapat koordinasi dan konsultasi keluar daerah Rp. 14.400.000', '30', 4, '3', '', '1 Berkas', NULL, ''),
(460, '2025-12-10 19:15:02', '2025', 13, '123', 'aji', 'aji', 3, 'aji', 'aji', '10', 7, '01', '01', '01', 4, '484787287_jadwal_lari_pola1.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `index`
--

CREATE TABLE `index` (
  `index_id` int(11) NOT NULL,
  `index_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `index`
--

INSERT INTO `index` (`index_id`, `index_nama`) VALUES
(4, 'Keuangan'),
(7, 'keshatan');

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
(3, 'Asli', 'Format arsip untuk surat keputusan\r\n'),
(4, 'Copy', 'Contoh format surat izin pelaksaan pekerjaan'),
(5, 'Tembusan', 'Contoh format surat perintah untuk pekerjaan proyek jalan'),
(6, 'Surat Perintah Kerja Proyek Jembatan', 'Contoh format untuk surat perintah kerja proyek jembatan'),
(7, 'Surat Kesehatan Pegawai', 'Surat kesehatan untuk pegawai'),
(8, 'Surat Lampiran Skripsi', 'Surat contoh lampiran untuk skripsi'),
(10, 'Curiculum Vitae', 'Contoh format surat curiculum vitae untuk kenaikan jabatan'),
(16, 'tes', 'aji123');

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
(4, 'Vikrih Yanto', 'petugas1', 'f75aa8d5251757f3bd906e1723eae373', ''),
(5, 'Junaidi Mus', 'petugas2', 'ac5604a8b8504d4ff5b842480df02e91', ''),
(13, 'maul', 'maul', '1eddb5a5061f6538c1091a73dd0d6f11', '');

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
(15, '2025-08-31 07:40:33', 11, 300),
(16, '2025-09-02 13:18:32', 11, 301),
(17, '2025-09-02 13:18:35', 11, 300),
(18, '2025-09-02 13:18:38', 11, 299),
(19, '2025-12-10 19:20:15', 26, 460);

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
(4, 'Internal', 'khusus internal');

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
(10, 'Ajir Muhajier2', 'user3', '92877af70a45fd6a2ed7fe81e1236b78', ''),
(26, 'fikri', 'fikri', '19da9ebef1ca88a6cb3ffcb997054199', '');

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
-- Indeks untuk tabel `index`
--
ALTER TABLE `index`
  ADD PRIMARY KEY (`index_id`);

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
  MODIFY `arsip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=461;

--
-- AUTO_INCREMENT untuk tabel `index`
--
ALTER TABLE `index`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `petugas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `riwayat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `surat_akses`
--
ALTER TABLE `surat_akses`
  MODIFY `akses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
