# SYSTEM ARCHITECTURE
# SISTEM NOTA DINAS BPN

# 1. Arsitektur Sistem
    Sistem Nota Dinas BPN menggunakan arsitektur Model View Controller (MVC) yang disediakan oleh framework Laravel.
    Arsitektur Utama:
        Browser → Route → Controller → Model → Database
    Untuk Menampilkan Data:
        Database → Model → Controller → Blade View → Browser

# 2. Teknologi
    Backend  : Laravel, PHP
    Frontend : Blade Template, HTML, CSS, JavaScript
    Database : MySQL
    Development Environment : Laragon
    Output : PDF A4

# 3. Struktur MVC
    Model
    Model bertanggung jawab terhadap data dan relasi database. Model yang digunakan:
        SubSeksi
        JenisLayanan
        Pejabat
        Berkas
        NotaDinas
        NotaDinasBerkas
    View
    View bertanggung jawab terhadap tampilan antarmuka pengguna. View menggunakan Blade Template Laravel.
    Controller
    Controller menangani:
        Request pengguna.
        Validasi data.
        Pemanggilan model.
        Penyimpanan data.
        Pengambilan data.
        Proses pembuatan Nota Dinas.
        Proses finalisasi.
        Proses generate PDF.
        Validasi bahwa berkas yang dipilih untuk satu Nota Dinas berasal dari sub seksi yang sama dengan sub_seksi_id Nota Dinas tersebut.

# 4. Modul Sistem
    Sistem dibagi menjadi:
        Data Berkas
        Jenis Layanan
        Nota Dinas
        Generate PDF

# 5. Modul Berkas
    Modul berkas digunakan untuk:
        Menambahkan berkas.
        Melihat berkas.
        Mencari berkas.
        Memfilter berkas.
        Melihat detail berkas.

# 6. Modul Jenis Layanan
    Jenis layanan berhubungan dengan sub seksi. Alur: Pilih Sub Seksi → Ambil Jenis Layanan → Tampilkan Dropdown

# 7. Modul Nota Dinas
    Modul Nota Dinas digunakan untuk:
        Memilih berkas (dari sub seksi yang sama dengan Nota Dinas yang sedang dibuat).
        Membuat draft Nota Dinas.
        Menampilkan preview.
        Finalisasi Nota Dinas.
        Menghasilkan PDF.

# 8. Modul PDF
    Modul PDF bertugas mengubah data Nota Dinas menjadi dokumen PDF dengan spesifikasi:
        Format PDF.
        Ukuran A4.
        Layout mengikuti contoh Nota Dinas.

# 9. Alur Pembuatan Nota Dinas
    Berkas → Pilih Berkas → Buat Draft → Preview → Finalisasi → PDF

# 10. Status Nota Dinas
    Draft: Nota Dinas masih dapat diperiksa.
    Final: Nota Dinas telah dikunci dan tidak dapat diubah.

# 11. Struktur Folder Laravel
    app/
    ├── Http/
    │   └── Controllers/
    └── Models/
    database/
    ├── migrations/
    └── seeders/
    resources/
    └── views/
    routes/
    └── web.php
    docs/
    ├── prd.md
    ├── architecture.md
    ├── database.md
    ├── ui-flow.md
    └── development-guide.md

# 12. Prinsip Pengembangan
    Controller menangani alur aplikasi.
    Model menangani data dan relasi.
    Blade menangani tampilan.
    Migration menangani struktur database.
    Seeder menangani data awal.
    Logika bisnis utama tidak ditempatkan langsung di Blade.

# 13. Konsep Relasi Data
    Sub Seksi (1) → hasMany → (*) Jenis Layanan
    Jenis Layanan (1) → hasMany → (*) Berkas
    Sub Seksi (1) → hasOne → (1) Pejabat
    Nota Dinas (1) → belongsToMany → (*) Berkas
    Nota Dinas (*) → belongsTo → (1) Sub Seksi
    Nota Dinas (*) → belongsTo → (1) Pejabat

# 14. Keamanan Data
    Data yang sudah menjadi Nota Dinas final tidak boleh diubah melalui antarmuka aplikasi.
    Validasi input dilakukan sebelum data disimpan.
    File .env tidak disimpan di repository Git.

# 15. Batasan Arsitektur
    Sistem tidak menggunakan Authentication, Authorization, Role, Permission, maupun Spatie Permission. Arsitektur difokuskan pada proses pengelolaan berkas dan pembuatan Nota Dinas.
    