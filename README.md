<div align="center">

# 📁 Arsipku - Sistem Manajemen Arsip Digital

**Sistem Informasi Pengelolaan Dokumen & Arsip Elektronik Berbasis Web**

[![PHP Version](https://img.shields.io/badge/PHP-8.0%20--%208.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Database](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Web Server](https://img.shields.io/badge/Apache-2.4+-D22128?style=for-the-badge&logo=apache&logoColor=white)](https://httpd.apache.org)
[![Security](https://img.shields.io/badge/Security-Hardened-success?style=for-the-badge&logo=shield&logoColor=white)](#-keamanan--keandalan)
[![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen?style=for-the-badge)](#)

<p align="center">
  Aplikasi web untuk digitalisasi, pengarsipan, pencarian, dan pengelolaan dokumen resmi secara terstruktur, cepat, dan aman dengan dukungan multi-level user serta pelacakan riwayat unduhan.
</p>

[Fitur Utama](#-fitur-utama) •
[Instalasi Cepat](#-panduan-instalasi-lokal-xampp) •
[Akun Default](#-akun-login-bawaan) •
[Struktur Direktori](#-struktur-direktori) •
[Panduan Deployment](DEPLOYMENT.md)

</div>

---

## 🌟 Fitur Utama

### 👥 1. Hak Akses Multi-Level (3 Role)
* **Administrator**:
  - Dashboard statistik & grafik pemantauan unduhan per hari dalam sebulan.
  - Manajemen master data: **Kategori Arsip**, **Rak Penyimpanan Fisik**, **Indeks Klasifikasi Berkas**, dan **Tingkat Akses Surat**.
  - Manajemen akun **Petugas** dan **User/Pengguna**.
  - Akses riwayat unduhan dokumen & ekspor data arsip ke format **Excel (.xlsx)**.
* **Petugas**:
  - Pengelolaan berkas arsip (unggah dokumen, perbarui metadata, preview PDF, unduh, dan hapus berkas).
  - Monitoring grafik unduhan dan data pengguna.
* **User / Pegawai**:
  - Penelusuran arsip berdasarkan kategori, rak, dan indeks klasifikasi.
  - Fitur **Preview Dokumen PDF** interaktif langsung di browser.
  - Pengunduhan berkas arsip resmi dan pencatatan riwayat unduhan otomatis.

### 🗂️ 2. Manajemen Arsip Terstruktur
- **Klasifikasi Lengkap**: Pengelompokan dokumen berdasarkan nomor/kode arsip, nama, kategori, rak penyimpanan, dan tingkat kerahasiaan (*Publik, Pemerintah, Presiden, Internal*).
- **Pencarian Cepat**: Integrasi **DataTables** untuk instant search, sorting dinamis, dan pagination rapi.
- **Ekspor Laporan Excel**: Didukung oleh pustaka PhpOffice/PhpSpreadsheet untuk rekapitulasi data arsip.

---

## 🛡️ Keamanan & Keandalan (Security Hardened)

Sistem ini telah melewati proses audit dan hardening keamanan menyeluruh:

| Aspek Keamanan | Implementasi |
|---|---|
| **Pencegahan SQL Injection** | Seluruh proses autentikasi, transaksi arsip, dan update profil menggunakan **Prepared Statements** (`mysqli_stmt`). |
| **Proteksi Folder Upload** | Folder `arsip/` dan `gambar/` diproteksi berkas `.htaccess` untuk **memblokir eksekusi skrip PHP** (`Require all denied` / HTTP 403). |
| **Validasi Upload Ketat** | Whitelist ekstensi dokumen (`pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar, jpg, jpeg, png`) dan pembatasan ukuran maksimal 25 MB. |
| **Enkripsi Kata Sandi** | Menggunakan algoritma standar industri **Bcrypt** (`password_hash` & `password_verify`). |
| **Proteksi Berkas Rahasia** | Root `.htaccess` secara otomatis menolak akses publik langsung ke file `.env`, file `.sql`, repositori Git, dan dokumentasi deployment. |
| **Role-Based Access Control** | Validasi session role ketat di lebih dari 25 berkas pengendali tindakan (*action files*) untuk mencegah eskalasi hak akses IDOR. |

---

## ⚡ Optimasi Performa

* **Single Query Aggregation**: Grafik unduhan bulanan Morris.js menggunakan query agregasi tunggal (`GROUP BY DATE`), menuntaskan masalah query ganda berulang (O(N) queries).
* **Database Indexing**: Tabel `arsip` dan `riwayat` dilengkapi index B-Tree pada foreign key (`arsip_kategori`, `arsip_petugas`, `arsip_rak`, `arsip_index`, `arsip_tahun`) dan `riwayat_waktu`.
* **Penghematan RAM PHP**: Penghitungan statistik dashboard memanfaatkan `SELECT COUNT(*)`, menghemat penggunaan memori server.
* **Kompresi Gzip & Browser Caching**: Otomatisasi kompresi `mod_deflate` dan header masa simpan aset statis CSS/JS/Gambar via `mod_expires`.

---

## 💻 Panduan Instalasi Lokal (XAMPP)

### 1. Kebutuhan Sistem
- **PHP**: Versi 8.0, 8.1, atau 8.2
- **Ekstensi PHP**: `mysqli`, `gd`, `zip`, `xml`, `mbstring`, `fileinfo`
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **Web Server**: Apache 2.4+

### 2. Langkah Instalasi

1. **Clone Repository**:
   ```bash
   cd c:/xampp/htdocs/
   git clone https://github.com/ajiazhar/arsipku.git
   ```

2. **Buat Database & Impor Skema**:
   - Buka **phpMyAdmin** di browser (`http://localhost/phpmyadmin`).
   - Buat database baru dengan nama: `db_arsip`.
   - Pilih database `db_arsip`, klik tab **Import**, lalu pilih berkas:
     ```
     db/db_arsip_clean.sql
     ```
   - Klik **Go / Import**.

3. **Konfigurasi Database (Opsional)**:
   - Sistem secara default langsung tersambung ke konfigurasi lokal XAMPP (`localhost`, user: `root`, tanpa password).
   - Jika menggunakan kredensial custom, Anda dapat membuat file `.env` dari template yang tersedia:
     ```bash
     cp .env.example .env
     ```
     Lalu sesuaikan isinya:
     ```env
     DB_HOST=localhost
     DB_USER=root
     DB_PASS=
     DB_NAME=db_arsip
     ```

4. **Jalankan Aplikasi**:
   - Buka browser dan akses:
     ```
     http://localhost/arsipku/
     ```

---

## 🔑 Akun Login Bawaan

Template database bersih (`db_arsip_clean.sql`) menyediakan akun administrator awal:

| Role | Username | Password Default | Hak Akses |
|---|---|---|---|
| **Administrator** | `admin` | `admin123` | Akses Penuh Sistem & Pengaturan |

> [!IMPORTANT]
> Segera ubah password default melalui menu **Profil Saya** -> **Ganti Password** setelah pertama kali login.

---

## 📁 Struktur Direktori

```text
arsipku/
├── admin/                  # Modul & antarmuka untuk Administrator
├── arsip/                  # Folder penyimpanan berkas dokumen (terproteksi .htaccess)
├── assets/                 # Berkas statis (CSS, JS, Font, Gambar template)
│   ├── css/                # Style, custom.css, dan design-upgrade.css
│   └── js/                 # Library vendor (jQuery, Morris, DataTables)
├── db/                     # Template skema basis data
│   ├── db_arsip_clean.sql      # Template database bersih siap pakai
│   └── db_arsip_production.sql # Database rilis dengan struktur index lengkap
├── gambar/                 # Folder penyimpanan foto profil & aset sistem
├── include/                # Komponen modular bersama (notifikasi, dll.)
├── petugas/                # Modul & antarmuka untuk Petugas Arsip
├── user/                   # Modul & antarmuka untuk User / Pegawai
├── vendor/                 # Pustaka Composer (PhpSpreadsheet, dll.)
├── .env.example            # Template variabel lingkungan server
├── .htaccess               # Konfigurasi Apache (Gzip, Caching, Keamanan)
├── DEPLOYMENT.md           # Panduan lengkap publikasi hosting / cPanel / VPS
├── index.php               # Halaman depan & form login utama
├── koneksi.php             # Konektor database terenkapsulasi dengan auto-loader .env
└── README.md               # Dokumentasi utama proyek
```

---

## 🚀 Panduan Publikasi ke Hosting

Untuk panduan langkah-demi-langkah pengunggahan ke hosting cPanel, DirectAdmin, atau VPS Linux, silakan baca dokumentasi terpisah di:

👉 **[Panduan Deployment Produksi (DEPLOYMENT.md)](DEPLOYMENT.md)**

---

## 📄 Lisensi & Kontributor

Dikembangkan untuk kebutuhan pengelolaan arsip dokumen digital yang tertib, modern, dan akuntabel.
Dikembangkan oleh [@ajiazhar](https://github.com/ajiazhar).
