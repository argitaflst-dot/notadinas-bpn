# PRODUCT REQUIREMENTS DOCUMENT SISTEM NOTA DINAS BPN 

# 1. Informasi Produk
    Nama Sistem : Sistem Informasi Nota Dinas BPN 
    Jenis Sistem : Aplikasi Berbasis Website
    Framework : Laravel
    Database : Mysql
    Environtment : Laragon 
    Output Utama : Nota Dinas dalam format PDF ukuran A4

# 2. Deskripsi Sistem
    Sistem Nota Dinas BPN merupakan aplikasi berbasis web yang digunakan untuk membantu proses pengelolaan data berkas dan pembuatan Nota Dinas secara otomatis. 
    Sistem memungkinkan petugas untuk memasukkan data berkas, memilih sub seksi, memilih jenis layanan yang sesuai dengan sub seksi, serta menentukan berkas yang akan digunakan untuk membuat Nota Dinas. Tidak semua berkas yang masuk harus dibuatkan Nota Dinas. Petugas dapat memilih satu atau beberapa berkas dari daftar berkas untuk dibuatkan Nota Dinas.
    Setelah Nota Dinas dibuat dan difinalisasi, dokumen tersebut dianggap sebagai dokumen final dan tidak dapat diubah kembali. Sistem menghasilkan Nota Dinas dalam bentuk PDF dengan ukuran kertas A4 sesuai format Nota Dinas yang digunakan oleh BPN.

# 3. Latar Belakang 
    Proses pembuatan Nota Dinas membutuhkan pengelolaan data berkas dan penyusunan informasi ke dalam format dokumen yang telah ditentukan. Apabila proses dilakukan secara manual, petugas perlu memasukkan kembali data dari berkas ke dalam dokumen Nota Dinas. Sistem ini dibuat untuk mengurangi penginputan data secara berulang dengan memanfaatkan data berkas yang telah disimpan di dalam sistem. Dengan demikian, petugas cukup memilih berkas yang akan digunakan untuk Nota Dinas dan sistem akan menggunakan data tersebut untuk membentuk Nota Dinas.

# 4. Tujuan Sistem
   Sistem dibuat dengan tujuan:
        Mempermudah petugas dalam mengelola data berkas.
        Mengelompokkan berkas berdasarkan sub seksi.
        Menampilkan jenis layanan berdasarkan sub seksi yang dipilih.
        Menentukan KKS berdasarkan sub seksi.
        Memudahkan petugas memilih berkas yang akan dibuatkan Nota Dinas.
        Mengurangi penginputan data secara berulang.
        Membuat Nota Dinas secara otomatis.
        Menyediakan preview Nota Dinas sebelum difinalisasi.
        Mengunci Nota Dinas yang telah difinalisasi.
        Menghasilkan Nota Dinas dalam format PDF ukuran A4.

# 5. Penggunaan Sistem
    Sistem digunakan oleh petugas yang mengelola berkas dan membuat Nota Dinas. Pada versi sistem ini tidak terdapat:
        Login
        Register
        User management
        Role
        Permission
        Spatie Laravel Permission
    Seluruh fungsi aplikasi dapat digunakan oleh petugas yang mengakses sistem.

# 6. Struktur Sub Seksi 
    Sistem memiliki satu bagian utama: Penetapan Hak dan Pendaftaran. Bagian tersebut memiliki empat sub seksi:
        1.Pendaftaran Tanah dan Ruang, Tanah Komunal dan Hubungan Kelembagaan
        2.Penetapan Hak Tanah dan Ruang
        3.Penetapan dan Pengelolaan Tanah Pemerintah
        4.Pemeliharaan Hak Tanah, Ruang dan Pembinaan PPAT

# 7.Fitur Sistem
    7.1 Input Berkas
        Petugas dapat memasukkan data berkas melalui form. Data yang diperlukan antara lain:
            Sub seksi
            Jenis layanan
            Nomor berkas
            Tanggal pendaftaran
            Nomor hak
            NIB elektronik
            Nama pemohon
            Tempat lahir
            Tanggal lahir
            Nomor akta
            Tanggal akta
            PPAT
            Desa/Kelurahan
            Kecamatan
            Luas
            Keterangan
    7.2 Pemilihan Seksi 
        Petugas memilih sub seksi terlebih dahulu. Setelah sub seksi dipilih, sistem menampilkan jenis layanan yang tersedia untuk sub seksi tersebut.
    
    7.3 Pemilihan Jenis Layanan
        Jenis layanan ditampilkan berdasarkan sub seksi yang telah dipilih. Petugas tidak memilih jenis layanan yang tidak sesuai dengan sub seksi.
    7.4 KKS
        KKS ditentukan berdasarkan sub seksi sesuai dengan data yang telah ditentukan. KKS akan digunakan sebagai salah satu informasi dalam proses pembuatan Nota Dinas.
    7.5 Daftar Berkas
        Sistem menampilkan data berkas yang telah tersimpan. Petugas dapat:
            Melihat daftar berkas.
            Mencari berkas.
            Memfilter berkas.
            Melihat detail berkas.
            Memilih berkas untuk dibuatkan Nota Dinas.
    7.6 Pemilihan Berkas Untuk Nota Dinas
        Tidak semua berkas harus dibuatkan Nota Dinas. Petugas dapat memilih satu atau beberapa berkas dari daftar berkas. Berkas yang dipilih akan digunakan sebagai data dalam pembuatan Nota Dinas.
    7.7 Pembuatan Nota Dinas
        Setelah petugas memilih berkas, sistem membuat draft Nota Dinas. Data yang berasal dari berkas akan dimasukkan secara otomatis ke dalam Nota Dinas.
    7.8 Preview Nota Dinas
        Sebelum difinalisasi, sistem menampilkan preview Nota Dinas. Petugas dapat memeriksa isi Nota Dinas sebelum melakukan finalisasi.
    7.9 Finalisasi Nota Dinas
        Petugas dapat melakukan finalisasi Nota Dinas. Setelah difinalisasi:
            Nota Dinas tidak dapat diedit.
            Data Nota Dinas dianggap final.
            Nota Dinas dapat dicetak.
            Nota Dinas dapat dibuat menjadi PDF.
    7.10 Generate PDF
        Sistem menghasilkan Nota Dinas dalam bentuk PDF dengan ukuran A4. Dokumen mengikuti format Nota Dinas yang telah ditentukan.

# 8. Alur Utama Sistem
    Berikut adalah alur utama dari sistem:
        1.Input Berkas
        2.Pilih Sub Seksi
        3.Pilih Jenis Layanan
        4.KKS Ditentukan
        5.Isi Data Berkas
        6.Simpan Berkas
        7.Daftar Berkas
        8.Pilih Berkas
        9.Buat Nota Dinas
        10.Preview Nota Dinas
        11.Finalisasi
        12.Generate PDF A4

# 9.Aturan Bisnis
    BR-01 :Setiap berkas harus memiliki sub seksi.
    BR-02 :Jenis layanan harus sesuai dengan sub seksi yang dipilih.
    BR-03 :Jenis layanan ditampilkan berdasarkan sub seksi.
    BR-04 :KKS ditentukan berdasarkan sub seksi.
    BR-05 :Tidak semua berkas harus dibuatkan Nota Dinas.
    BR-06 :Petugas dapat memilih satu atau beberapa berkas untuk satu Nota Dinas.
    BR-07 :Satu berkas dapat dicatat sebagai bagian dari Nota Dinas.
    BR-08 :Nota Dinas yang masih berupa draft dapat diperiksa sebelum difinalisasi.
    BR-09 :Nota Dinas yang telah difinalisasi tidak dapat diubah.
    BR-10 :Nota Dinas final dapat menghasilkan dokumen PDF.
    BR-11 :PDF Nota Dinas menggunakan ukuran kertas A4.

# 10. Status Nota Dinas
    Nota Dinas memiliki dua status:
        - Draft: Nota Dinas masih dalam proses pemeriksaan.
        - Final: Nota Dinas telah disetujui untuk menjadi dokumen akhir dan tidak dapat diedit.
    Alur status: Draft ➔ Final

# 11. Output Sistem
    Output utama sistem adalah:
        Data berkas yang tersimpan.
        Daftar berkas.
        Data Nota Dinas.
        Preview Nota Dinas.
        Nota Dinas final.
        File PDF Nota Dinas ukuran A4.

# 12. Batasan Sistem
    Sistem versi ini tidak mencakup:
        Login.
        Register.
        Manajemen user.
        Role.
        Permission.
        Approval bertingkat.
        Notifikasi.
        Integrasi sistem eksternal.
    Fokus utama sistem adalah pengelolaan data berkas dan pembuatan Nota Dinas.

# 13. Kriteria Keberhasilan
    Sistem dianggap berhasil apabila:
        Petugas dapat memasukkan data berkas.
        Petugas dapat memilih sub seksi.
        Jenis layanan berubah sesuai sub seksi.
        KKS dapat ditentukan sesuai sub seksi.
        Data berkas dapat tersimpan.
        Petugas dapat memilih berkas tertentu.
        Sistem dapat membuat Nota Dinas dari berkas yang dipilih.
        Nota Dinas dapat dipreview.
        Nota Dinas dapat difinalisasi.
        Nota Dinas final tidak dapat diedit.
        Sistem dapat menghasilkan PDF ukuran A4.











