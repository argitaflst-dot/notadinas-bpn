# Database Documentation - Nota Dinas BPN

## 1. Informasi Database

Nama database yang digunakan dalam sistem:

`notadinas_bpn`

Database menggunakan MySQL/MariaDB dan digunakan oleh aplikasi Laravel untuk menyimpan data berkas pertanahan dan proses pembuatan Nota Dinas.

---

## 2. Daftar Tabel

Database `notadinas_bpn` saat ini memiliki 9 tabel:

| No | Nama Tabel | Keterangan |
|---|---|---|
| 1 | `seksi` | Menyimpan data seksi/subseksi |
| 2 | `jenis_layanan` | Menyimpan jenis layanan berdasarkan seksi |
| 3 | `berkas` | Menyimpan data berkas pertanahan |
| 4 | `nota_dinas` | Menyimpan data Nota Dinas |
| 5 | `nota_dinas_berkas` | Tabel penghubung Nota Dinas dengan berkas |
| 6 | `migrations` | Tabel bawaan Laravel untuk mencatat migration |
| 7 | `failed_jobs` | Tabel bawaan Laravel untuk mencatat job yang gagal |
| 8 | `password_reset_tokens` | Tabel bawaan Laravel untuk token reset password |
| 9 | `personal_access_tokens` | Tabel bawaan Laravel untuk personal access token |

### Catatan

Tabel `migrations`, `failed_jobs`, `password_reset_tokens`, dan `personal_access_tokens` merupakan tabel pendukung/bawaan Laravel.

Tabel `users` tidak digunakan dan saat ini tidak terdapat pada database aktif `notadinas_bpn`.

---

# 3. Struktur Relasi Database

Relasi utama sistem adalah:

```text
seksi
  │
  │ 1 : N
  ▼
jenis_layanan
  │
  │ 1 : N
  ▼
berkas
  │
  │
  │ N : N
  ▼
nota_dinas_berkas
  ▲
  │
  │ N : 1
  │
nota_dinas
```

Penjelasan:

- Satu `seksi` dapat memiliki banyak `jenis_layanan`.
- Satu `jenis_layanan` dapat digunakan oleh banyak `berkas`.
- Satu `nota_dinas` dapat memiliki banyak `berkas`.
- Satu `berkas` dapat digunakan dalam Nota Dinas.
- Hubungan antara `nota_dinas` dan `berkas` menggunakan tabel penghubung `nota_dinas_berkas`.

---

# 4. Tabel `seksi`

## Fungsi

Tabel `seksi` digunakan untuk menyimpan data seksi/subseksi pada sistem.

Data pada tabel ini digunakan sebagai pilihan pada form input berkas.

## Struktur Kolom

| Nama Kolom | Keterangan |
|---|---|
| `id_seksi` | Primary Key |
| `nama_seksi` | Nama seksi/subseksi |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

## Primary Key

```text
id_seksi
```

## Relasi

Tabel `seksi` memiliki relasi dengan:

- `jenis_layanan`
- `berkas`

Relasi:

```text
seksi 1 : N jenis_layanan
seksi 1 : N berkas
```

---

# 5. Tabel `jenis_layanan`

## Fungsi

Tabel `jenis_layanan` digunakan untuk menyimpan jenis layanan yang tersedia pada setiap seksi.

Jenis layanan ditampilkan berdasarkan seksi yang dipilih pada form input berkas.

## Struktur Kolom

| Nama Kolom | Keterangan |
|---|---|
| `id_jenis_layanan` | Primary Key |
| `id_seksi` | Foreign Key ke `seksi.id_seksi` |
| `nama_layanan` | Nama jenis layanan |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

## Primary Key

```text
id_jenis_layanan
```

## Foreign Key

```text
id_seksi
    ↓
seksi.id_seksi
```

## Relasi

```text
seksi 1 : N jenis_layanan
```

Artinya satu seksi dapat mempunyai banyak jenis layanan.

Contoh data yang saat ini terdapat pada database:

```text
Hapusnya Hak
Pendaftaran SK Hak
Pendaftaran SK Perpanjangan/Pembaruan Hak
Pendaftaran Tanah Pertama Kali Pengakuan/Penegasan Hak
Pendaftaran Tanah Pertama Kali Pengakuan/Penegasan Hak Wakaf
Pendaftaran Tanah Pertama Kali Wakaf untuk Tanah Yang Belum Sertipikat (Tanah Adat)
Pendaftaran Tanah Pertama Kali Wakaf untuk Tanah Yang Belum Sertipikat (Tanah Negara)
Roya
Sertipikat Hak Tanggungan Pengganti Karena Hilang
Sertipikat Pengganti Karena Blanko Lama
Sertipikat Pengganti Karena Hilang
Sertipikat Pengganti Karena Rusak
Wakaf dari Tanah Yang Sudah Bersertipikat
```

---

# 6. Tabel `berkas`

## Fungsi

Tabel `berkas` merupakan tabel utama untuk menyimpan data berkas pertanahan yang diinput melalui halaman Input Berkas.

Data berkas yang dimasukkan melalui form akan disimpan ke tabel ini.

## Struktur Kolom

| Nama Kolom | Keterangan |
|---|---|
| `id_berkas` | Primary Key |
| `id_seksi` | ID seksi |
| `id_jenis_layanan` | ID jenis layanan |
| `no_berkas` | Nomor berkas |
| `tanggal_pendaftaran` | Tanggal pendaftaran |
| `no_hak` | Nomor hak |
| `nib_elektronik` | NIB elektronik |
| `nama_pemohon` | Nama pemohon |
| `tempat_lahir` | Tempat lahir pemohon |
| `tanggal_lahir` | Tanggal lahir pemohon |
| `nomor_akta` | Nomor akta |
| `tanggal_akta` | Tanggal akta |
| `ppat` | PPAT |
| `desa_kelurahan` | Desa/kelurahan |
| `kecamatan` | Kecamatan |
| `luas` | Luas tanah |
| `nib_elektronik_akta` | NIB elektronik akta |
| `status` | Status berkas |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

## Primary Key

```text
id_berkas
```

## Relasi

Berkas mempunyai hubungan dengan:

```text
seksi
jenis_layanan
nota_dinas_berkas
```

Secara konsep:

```text
seksi 1 : N berkas

jenis_layanan 1 : N berkas

nota_dinas N : N berkas
```

---

# 7. Tabel `nota_dinas`

## Fungsi

Tabel `nota_dinas` digunakan untuk menyimpan informasi utama Nota Dinas.

Nota Dinas dibuat berdasarkan berkas yang dipilih oleh pengguna/petugas dari data berkas yang sudah tersimpan.

## Struktur Kolom

| Nama Kolom | Keterangan |
|---|---|
| `id` | Primary Key |
| `nomor` | Nomor Nota Dinas |
| `tahun` | Tahun Nota Dinas |
| `kepada` | Pihak yang dituju |
| `dari` | Pihak pengirim |
| `tanggal` | Tanggal Nota Dinas |
| `keterangan` | Keterangan Nota Dinas |
| `status` | Status Nota Dinas |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

## Primary Key

```text
id
```

---

# 8. Tabel `nota_dinas_berkas`

## Fungsi

Tabel `nota_dinas_berkas` digunakan sebagai tabel penghubung antara tabel `nota_dinas` dan tabel `berkas`.

Tabel ini diperlukan karena satu Nota Dinas dapat berisi lebih dari satu berkas.

## Struktur Kolom

| Nama Kolom | Keterangan |
|---|---|
| `id` | Primary Key |
| `nota_dinas_id` | ID Nota Dinas |
| `berkas_id` | ID berkas |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

## Primary Key

```text
id
```

## Kolom Relasi

```text
nota_dinas_id
    ↓
nota_dinas.id
```

dan secara konsep:

```text
berkas_id
    ↓
berkas.id_berkas
```

### Catatan penting

Pada database saat ini, tabel `berkas` menggunakan primary key:

```text
id_berkas
```

bukan:

```text
id
```

Oleh karena itu, relasi Eloquent antara `nota_dinas_berkas` dan `berkas` harus menggunakan `id_berkas` sebagai owner key.

---

# 9. Relasi `seksi` dengan `jenis_layanan`

Relasi ini digunakan untuk membuat dropdown jenis layanan berdasarkan seksi yang dipilih.

Contoh:

```text
Seksi
Pendaftaran Tanah dan Ruang, Tanah Komunal dan Hubungan Kelembagaan
        │
        ├── Hapusnya Hak
        ├── Pendaftaran SK Hak
        ├── Roya
        ├── Wakaf
        └── ...
```

Pada database:

```text
seksi.id_seksi
       │
       ▼
jenis_layanan.id_seksi
```

---

# 10. Relasi `seksi` dengan `berkas`

Setiap berkas memiliki informasi seksi melalui:

```text
berkas.id_seksi
```

yang mengacu pada:

```text
seksi.id_seksi
```

Relasi:

```text
seksi 1 : N berkas
```

Artinya satu seksi dapat memiliki banyak berkas.

---

# 11. Relasi `jenis_layanan` dengan `berkas`

Setiap berkas memiliki jenis layanan melalui:

```text
berkas.id_jenis_layanan
```

yang mengacu pada:

```text
jenis_layanan.id_jenis_layanan
```

Relasi:

```text
jenis_layanan 1 : N berkas
```

Artinya satu jenis layanan dapat digunakan oleh banyak berkas.

---

# 12. Relasi `nota_dinas` dengan `berkas`

Satu Nota Dinas dapat berisi beberapa berkas.

Contoh:

```text
Nota Dinas 001
    │
    ├── Berkas 001
    ├── Berkas 002
    └── Berkas 003
```

Karena satu berkas juga dapat memiliki kemungkinan untuk digunakan pada Nota Dinas, hubungan tersebut menggunakan tabel perantara:

```text
nota_dinas_berkas
```

Sehingga hubungan secara konsep adalah:

```text
nota_dinas N : N berkas
```

---

# 13. Alur Data

Alur utama penggunaan database:

```text
1. Pilih Seksi
       ↓
2. Pilih Jenis Layanan
       ↓
3. Input Data Berkas
       ↓
4. Simpan ke tabel berkas
       ↓
5. Berkas muncul pada halaman Pilih Berkas
       ↓
6. Pilih berkas yang akan dibuatkan Nota Dinas
       ↓
7. Buat Nota Dinas
       ↓
8. Simpan data Nota Dinas
       ↓
9. Hubungkan Nota Dinas dengan berkas
       ↓
10. Simpan hubungan pada nota_dinas_berkas
```

---

# 14. Contoh Data dan Relasi

Contoh struktur data:

```text
SEKSI
id_seksi = 1
nama_seksi = Pendaftaran Tanah dan Ruang, Tanah Komunal dan Hubungan Kelembagaan
```

Jenis layanan yang memiliki `id_seksi = 1` akan menjadi layanan milik seksi tersebut.

Contoh:

```text
JENIS_LAYANAN

id_jenis_layanan = 1
id_seksi = 1
nama_layanan = Hapusnya Hak
```

Kemudian ketika pengguna memasukkan berkas:

```text
BERKAS

id_berkas = ...
id_seksi = 1
id_jenis_layanan = 1
nama_pemohon = ...
no_berkas = ...
```

Berkas tersebut berarti termasuk ke dalam:

```text
Seksi:
Pendaftaran Tanah dan Ruang, Tanah Komunal dan Hubungan Kelembagaan

Jenis Layanan:
Hapusnya Hak
```

---

# 15. Tabel Bawaan Laravel

## `migrations`

Digunakan Laravel untuk mencatat migration yang sudah dijalankan.

Tabel ini bukan bagian dari proses bisnis Nota Dinas.

---

## `failed_jobs`

Digunakan Laravel untuk menyimpan informasi mengenai job yang gagal dijalankan.

Tabel ini bukan bagian dari proses bisnis utama Nota Dinas.

---

## `password_reset_tokens`

Tabel pendukung Laravel untuk menyimpan token reset password.

Pada sistem saat ini tidak terdapat tabel `users` aktif di database.

---

## `personal_access_tokens`

Tabel pendukung Laravel yang biasanya digunakan untuk personal access token.

Tabel ini bukan bagian dari proses bisnis utama Nota Dinas.

---

# 16. Tabel yang Tidak Digunakan

Tabel `users` tidak terdapat pada database aktif `notadinas_bpn`.

Sistem saat ini tidak menggunakan tabel `users` sebagai bagian dari database bisnis.

Oleh karena itu, tabel berikut bukan bagian dari struktur database aktif:

```text
users
```

---

# 17. Ringkasan Database

### Tabel bisnis utama

```text
seksi
jenis_layanan
berkas
nota_dinas
nota_dinas_berkas
```

### Tabel pendukung Laravel

```text
migrations
failed_jobs
password_reset_tokens
personal_access_tokens
```

### Jumlah

```text
Total tabel database : 9

Tabel bisnis         : 5
Tabel pendukung      : 4
```

### Relasi utama

```text
seksi
  │
  ├── 1 : N ── jenis_layanan
  │
  └── 1 : N ── berkas

jenis_layanan
  │
  └── 1 : N ── berkas

nota_dinas
  │
  └── N : N ── berkas
              melalui
              nota_dinas_berkas
```

---

# 18. Model Laravel yang Berhubungan dengan Database

Model yang saat ini digunakan untuk tabel bisnis:

```text
App\Models\Seksi
App\Models\JenisLayanan
App\Models\Berkas
App\Models\NotaDinas
```

Mapping model dengan tabel:

| Model | Tabel |
|---|---|
| `Seksi` | `seksi` |
| `JenisLayanan` | `jenis_layanan` |
| `Berkas` | `berkas` |
| `NotaDinas` | `nota_dinas` |

---

# 19. Kesimpulan

Database `notadinas_bpn` digunakan sebagai pusat penyimpanan data dalam Sistem Pembuatan Nota Dinas.

Proses bisnis utama dimulai dari data `seksi`, kemudian `jenis_layanan`, lalu `berkas`. Berkas yang telah tersimpan dapat dipilih untuk dimasukkan ke dalam Nota Dinas.

Data Nota Dinas disimpan pada tabel `nota_dinas`, sedangkan hubungan antara Nota Dinas dan berkas disimpan pada tabel `nota_dinas_berkas`.

Dengan struktur tersebut, sistem dapat memisahkan data berkas dengan data Nota Dinas serta memungkinkan satu Nota Dinas memiliki beberapa berkas.