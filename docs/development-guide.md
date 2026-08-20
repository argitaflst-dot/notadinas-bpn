# DEVELOPMENT GUIDE
# SISTEM NOTA DINAS BPN

# 1. Tujuan
    Dokumen ini digunakan sebagai panduan kerja tim selama pengembangan sistem.

# 2. Branch Utama
    Branch utama adalah main, yang digunakan untuk kode yang sudah dianggap stabil.

# 3. Branch Fitur
    Setiap anggota membuat branch untuk fitur yang dikerjakan dengan format: feature/nama-fitur.
    Contoh: feature/input-berkas, feature/nota-dinas, dll.

# 4. Alur Kerja Git
    Sebelum Membuat Branch:
        git checkout main
        git pull origin main
        Membuat Branch:
        git checkout -b feature/nama-fitur
    Commit:
        Gunakan format commit yang deskriptif, contoh:
        feat: tambah form input berkas
        fix: perbaiki validasi input berkas
        style: perbaiki tampilan
    Push:
        git add .
        git commit -m "pesan commit"
        git push origin feature/nama-fitur
        Pull Request:
        Buat Pull Request dari branch fitur menuju main setelah fitur selesai.

# 5. File Environment
    File .env tidak boleh di-commit. Gunakan .env.example sebagai referensi konfigurasi.

# 6. Database
    Struktur database wajib dibuat menggunakan migration. Data awal menggunakan seeder. Dilarang membuat tabel secara manual di database.

# 7. Instalasi Project
    Setelah clone repository, ikuti langkah berikut:
        composer install
        npm install
        copy .env.example .env
        php artisan key:generate
        php artisan migrate
        php artisan db:seed
        php artisan serve

# 8. Aturan Coding
    Controller: Menangani request dan alur aplikasi.
    Model: Menangani data dan relasi.
    Blade: Menangani tampilan.
    Migration: Struktur database.
    Seeder: Data awal.
    Logika bisnis tidak boleh ditulis secara berlebihan di dalam file Blade.

# 9. Aturan Finalisasi Nota Dinas
    Nota Dinas dengan status final tidak boleh diubah. Controller wajib melakukan pengecekan status sebelum menerima proses edit/update.

# 10. Testing
    Sebelum melakukan Pull Request, developer harus memastikan:
    Form dapat dibuka.
    Validasi berjalan sesuai aturan bisnis.
    Data dapat disimpan dan ditampilkan.
    Relasi database berfungsi.
    Tidak terdapat error pada aplikasi (Laravel debug).
    Tampilan sudah sesuai dengan desain Figma.
