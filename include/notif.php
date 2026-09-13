<?php if (isset($_GET['msg']) || isset($_GET['alert'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // Pesan yang menggunakan parameter ?msg=
            const msg = "<?= $_GET['msg'] ?? '' ?>";

            const pesan = {
                // CRUD Surat
                surat_tambah: ["Berhasil!", "Surat berhasil ditambahkan!", "success"],
                surat_edit: ["Berhasil!", "Surat berhasil diperbarui!", "success"],
                surat_hapus: ["Berhasil!", "Surat berhasil dihapus!", "success"],

                // User
                user_tambah: ["Berhasil!", "User berhasil ditambahkan!", "success"],
                user_edit: ["Berhasil!", "Data user berhasil diperbarui!", "success"],
                user_hapus: ["Berhasil!", "User berhasil dihapus!", "success"],

                // Petugas
                petugas_tambah: ["Berhasil!", "Petugas berhasil ditambahkan!", "success"],
                petugas_edit: ["Berhasil!", "Data petugas berhasil diperbarui!", "success"],
                petugas_hapus: ["Berhasil!", "Petugas berhasil dihapus!", "success"],

                // Kategori
                kategori_tambah: ["Berhasil!", "Kategori berhasil ditambahkan!", "success"],
                kategori_edit: ["Berhasil!", "Kategori berhasil diperbarui!", "success"],
                kategori_hapus: ["Berhasil!", "Kategori berhasil dihapus!", "success"],

                // Index
                index_tambah: ["Berhasil!", "Index berhasil ditambahkan!", "success"],
                index_edit: ["Berhasil!", "Index berhasil diperbarui!", "success"],
                index_hapus: ["Berhasil!", "Index berhasil dihapus!", "success"],

                // Rak
                rak_tambah: ["Berhasil!", "Rak berhasil ditambahkan!", "success"],
                rak_edit: ["Berhasil!", "Data rak berhasil diperbarui!", "success"],
                rak_hapus: ["Berhasil!", "Rak berhasil dihapus!", "success"],

                // Arsip
                arsip_tambah: ["Berhasil!", "Arsip berhasil ditambahkan!", "success"],
                arsip_edit: ["Berhasil!", "Arsip berhasil diperbarui!", "success"],
                arsip_hapus: ["Berhasil!", "Arsip berhasil dihapus!", "success"],

                // Profile update
                profile_edit: ["Berhasil!", "Profil berhasil diperbarui!", "success"],
                profile_user: ["Berhasil!", "Profil user berhasil diperbarui!", "success"],
                profile_petugas: ["Berhasil!", "Profil petugas berhasil diperbarui!", "success"],
            };

            if (pesan[msg]) {
                Swal.fire(pesan[msg][0], pesan[msg][1], pesan[msg][2]);
            }

            // Notifikasi khusus Password menggunakan ?alert=
            const alert = "<?= $_GET['alert'] ?? '' ?>";

            if (alert === "sukses") {
                Swal.fire("Berhasil!", "Password berhasil diperbarui!", "success");
            }
            if (alert === "weak") {
                Swal.fire("Peringatan!", "Password minimal 8 karakter dan kombinasi huruf + angka!", "warning");
            }
            if (alert === "nomatch") {
                Swal.fire("Gagal!", "Konfirmasi password tidak sama!", "error");
            }

        });
    </script>
<?php endif; ?>