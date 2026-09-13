# 🚀 Panduan Deployment Produksi — Sistem Informasi Arsip Digital (Arsipku)

Panduan ini berisi petunjuk komprehensif langkah demi langkah untuk mempublikasikan (deploy) aplikasi **Arsipku** ke server produksi (Shared Hosting / cPanel, VPS, atau Cloud Server).

---

## 📋 1. Persyaratan Server (System Requirements)

Pastikan server hosting memenuhi spesifikasi berikut:

| Komponen | Persyaratan Minimum | Rekomendasi |
|---|---|---|
| **Web Server** | Apache 2.4+ (dengan `mod_rewrite` & `.htaccess` aktif) | Apache 2.4+ / Nginx |
| **PHP Version** | PHP 8.0 | PHP 8.1 / PHP 8.2 |
| **Database** | MySQL 5.7+ / MariaDB 10.3+ | MariaDB 10.4+ |
| **Memory Limit** | 128 MB | 256 MB+ |
| **Max Upload Size** | 25 MB | 30 MB - 50 MB |

### Ekstensi PHP yang Wajib Diaktifkan:
Di menu cPanel **Select PHP Version** -> tab **Extensions**, pastikan ekstensi berikut dicentang:
- `mysqli` (koneksi database)
- `gd` (pengolahan foto & avatar profil)
- `zip` (kebutuhan PhpSpreadsheet untuk export Excel)
- `xml` & `xmlwriter` (kebutuhan export Excel)
- `mbstring` (penanganan string multi-byte)
- `fileinfo` (deteksi dan validasi file upload)

---

## 🗄️ 2. Persiapan & Impor Database

1. **Buat Database Baru di cPanel**:
   - Buka menu **MySQL Databases** di cPanel hosting Anda.
   - Buat database baru (contoh: `u12345_db_arsip`).
   - Buat user database baru beserta password yang kuat (contoh: `u12345_userarsip`).
   - Tambahkan user tersebut ke database dengan memberikan centang **ALL PRIVILEGES**.
2. **Impor Skema SQL Produksi**:
   - Buka menu **phpMyAdmin** di cPanel.
   - Pilih database yang baru dibuat di bilah sisi kiri.
   - Klik tab **Import** di bagian atas.
   - Klik **Choose File** dan pilih file: `db/db_arsip_production.sql`.
   - Klik tombol **Import / Go** di bawah.
   - Pastikan seluruh tabel (`admin`, `arsip`, `arsip_rak`, `index`, `kategori`, `petugas`, `riwayat`, `surat_akses`, `user`) berhasil diimpor tanpa error.

---

## 📂 3. Upload File Aplikasi

1. **Kompresi File Proyek**:
   - Zip seluruh file di dalam folder proyek ini (kecuali folder `.git/` atau file dev yang tidak diperlukan).
2. **Upload ke Server Hosting**:
   - Masuk ke menu **File Manager** di cPanel.
   - Arahkan ke folder tujuan (misal: `public_html` untuk domain utama, atau folder subdomain seperti `public_html/arsip`).
   - Klik **Upload** dan unggah file `.zip` yang sudah disiapkan.
   - Setelah selesai, klik kanan file zip dan pilih **Extract**.
   - Pastikan file `.htaccess` di folder `arsip/` dan `gambar/` ikut terunggah (aktifkan opsi *Show Hidden Files / dotfiles* di pengaturan File Manager jika perlu).

---

## ⚙️ 4. Konfigurasi Koneksi Database

Aplikasi mendukung konfigurasi fleksibel melalui file `.env`.

1. Di File Manager cPanel, salin (copy/rename) file `.env.example` menjadi `.env`.
2. Edit file `.env` dan sesuaikan dengan kredensial database hosting Anda:
   ```env
   DB_HOST=localhost
   DB_USER=u12345_userarsip
   DB_PASS=PasswordDatabaseAnda123!
   DB_NAME=u12345_db_arsip
   APP_URL=https://arsip.instansianda.go.id
   ```
3. *Catatan*: Jika hosting Anda tidak mengizinkan file `.env`, Anda dapat langsung menyunting variabel di berkas `koneksi.php`:
   ```php
   $db_host = 'localhost';
   $db_user = 'u12345_userarsip';
   $db_pass = 'PasswordDatabaseAnda123!';
   $db_name = 'u12345_db_arsip';
   ```

---

## 🔒 5. Pengaturan Izin Folder (File Permissions / CHMOD)

Agar fitur upload dokumen dan foto berjalan dengan lancar dan aman, atur izin direktori berikut di File Manager cPanel:

| Folder | Rekomendasi CHMOD | Keterangan |
|---|---|---|
| `/arsip/` | `755` (atau `775`) | Folder penyimpanan dokumen upload |
| `/gambar/admin/` | `755` (atau `775`) | Folder foto profil admin |
| `/gambar/petugas/` | `755` (atau `775`) | Folder foto profil petugas |
| `/gambar/user/` | `755` (atau `775`) | Folder foto profil user |
| Semua file PHP biasa | `644` | Hak baca & eksekusi aman |

> [!IMPORTANT]
> Jangan pernah memberikan izin `777` di server produksi kecuali server Anda benar-benar mengharuskannya. Gunakan `755` sebagai standar aman.

---

## 🛠️ 6. Pengaturan php.ini yang Disarankan di Produksi

Di menu cPanel **MultiPHP INI Editor** (atau via berkas `.user.ini`), atur parameter berikut agar upload berkas berukuran besar tidak gagal:

```ini
upload_max_filesize = 30M
post_max_size = 35M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
display_errors = Off
log_errors = On
```

> [!TIP]
> Mengatur `display_errors = Off` sangat penting di lingkungan produksi agar pesan error teknis database/PHP tidak tampil di hadapan pengunjung jika terjadi gangguan jaringan.

---

## 🔑 7. Akun Login Bawaan & Pengamanan Awal

Setelah deployment selesai, lakukan login awal melalui browser:

* **URL Login**: `https://domain-anda.com/index.php`
* **Role Admin Bawaan**:
  - Username: `admin`
  - Password default: `admin123`

> [!CAUTION]
> **Langkah Wajib Pasca Deployment**:
> 1. Segera masuk ke menu **Profil Saya** -> **Ganti Password** untuk mengganti password default administrator dengan password baru yang kuat (minimal 8 karakter kombinasi huruf dan angka).
> 2. Buat akun Petugas dan User resmi instansi Anda.
> 3. Lakukan uji coba:
>    - Upload satu dokumen arsip baru (format PDF).
>    - Buka fitur **Preview Arsip** dan coba tombol **Download**.
>    - Export data ke Excel menggunakan tombol **Download Data** di halaman Semua Arsip.

---

## ❓ 8. Troubleshooting (Solusi Kendala Umum)

1. **Muncul pesan "Terjadi gangguan koneksi ke basis data"**:
   - Periksa kembali nama database, username, dan password di `.env` atau `koneksi.php`. Pastikan user database sudah memiliki *All Privileges*.
2. **Error "Class 'PhpOffice\PhpSpreadsheet\Spreadsheet' not found" saat export Excel**:
   - Pastikan folder `vendor/` ikut terunggah secara utuh saat deployment.
3. **Upload berkas gagal atau ukuran file 0 bytes**:
   - Periksa izin folder `arsip/` (pastikan CHMOD `755`).
   - Periksa batasan `upload_max_filesize` di `php.ini` hosting Anda.
4. **Halaman CSS terlihat tidak rapi atau cache lama tertahan**:
   - Lakukan hard-refresh di browser (`Ctrl + F5` di Windows atau `Cmd + Shift + R` di Mac). Aplikasi sudah menggunakan asset cache buster `?v=1.0.0`.
