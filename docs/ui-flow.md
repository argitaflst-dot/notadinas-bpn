# UI FLOW
# SISTEM NOTA DINAS BPN

# 1. Tujuan
    Dokumen ini menjelaskan urutan layar yang dilalui petugas dari mulai input berkas sampai Nota Dinas jadi PDF, dan memetakan tiap layar ke Blade view yang akan dibuat.

# 2. Alur Utama
    Input Berkas
    Pilih Sub Seksi
    Pilih Jenis Layanan
    Isi Data Berkas
    Simpan Berkas
    Daftar Berkas ("Pilih Berkas")
    Pilih Satu/Beberapa Berkas
    Buat Nota Dinas (Draft)
    Preview Nota Dinas
    Finalisasi
    Generate PDF A4
    Menu Sidebar: Input Berkas, Pilih Berkas, Riwayat.
    Catatan: PRD section 7.1 menyebut ada modul Dashboard, namun sidebar di mockup hanya berisi tiga menu utama. Perlu konfirmasi apakah Dashboard diperlukan atau tidak.

# 3. Layar: Input Berkas
    Komponen antarmuka terdiri dari:
    Seksi & Jenis Layanan: Dua dropdown (Sub seksi 4 pilihan; Jenis layanan berubah sesuai sub seksi).
    Data Berkas: No. berkas, Tanggal Pendaftaran, No Hak, NIB Elektronik.
    Data Pemohon: Nama pemohon, Tempat lahir, Tanggal lahir, Nomor akta, Tanggal akta, PPAT, Desa/Kelurahan, Kecamatan, Luas, Keterangan.
    Setelah disimpan, data masuk ke tabel berkas dan muncul di layar Daftar Berkas.

# 4. Layar: Pilih Berkas (Daftar Berkas)
    Struktur layar:
    Menampilkan daftar berkas yang sudah tersimpan (mendukung pencarian & filter).
    Petugas mencentang satu atau beberapa berkas.
    Aturan: Berkas yang dicentang harus berasal dari sub seksi yang sama.
    Tombol "Buat Nota Dinas" digunakan untuk memproses berkas yang dicentang menuju tahap Preview.

# 5. Layar: Preview Nota Dinas
    Komponen antarmuka:
    Header: Nomor Nota Dinas (format "NO. X TAHUN Y"), Kepada, Dari, Tanggal.
    Tabel Berkas: No, No Berkas, Tanggal Pendaftaran, No Hak, NIB Elektronik, Pemohon, Tempat/Tanggal Lahir, Nomor Akta, Tanggal Akta, PPAT, Desa/Kelurahan, Kecamatan, Luas, Ket.
    Footer: Nama & NIP pejabat penandatangan (otomatis berdasarkan sub_seksi_id).


# 6. Finalisasi
    Petugas klik tombol kunci/finalisasi di layar Preview. Status nota_dinas berubah dari Draft menjadi Final. Setelah final, data tidak bisa diedit dan siap di-generate jadi PDF.

# 7. Generate PDF
    Output berupa file PDF berukuran A4 yang layout-nya mengikuti format Preview Nota Dinas.

# 8. Layar: Riwayat
    Tabel list Nota Dinas berisi: No. Nota Dinas, Dari (sub seksi), Tanggal, Jumlah Berkas, Status (badge "Final"). Tersedia fitur pencarian, filter, dan ikon aksi (untuk lihat/cetak PDF).

# 9. Hubungan Figma dengan Coding
    Layar Figma
    Blade View
    Input Berkas
    resources/views/berkas/create.blade.php
    Pilih Berkas (Daftar Berkas)
    resources/views/berkas/index.blade.php
    Preview Nota Dinas
    resources/views/nota-dinas/preview.blade.php
    Riwayat
    resources/views/nota-dinas/index.blade.php


# 10. Checklist Konfirmasi (Figma/Tim)
    Konfirmasi keberadaan layar Dashboard.
    Validasi struktur layar "Pilih Berkas".
    Verifikasi kelengkapan field form Input Berkas.
    Fungsi ikon aksi pada layar Riwayat.
