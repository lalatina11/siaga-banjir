-----

# 🌊 Siaga Banjir - Monitoring System

[](https://laravel.com)
[](https://www.php.net/)

**Siaga Banjir** adalah aplikasi berbasis web yang dikembangkan sebagai proyek tugas mata kuliah **Web Programming 3**. Sistem ini dirancang untuk memantau dan memberikan informasi terkait kondisi tingkat kerawanan banjir di wilayah tertentu secara *real-time*.

## 👥 Anggota Kelompok 1

Berikut adalah tim pengembang di balik proyek ini:

| No | Nama Lengkap | NIM |
|:---:|:---|:---:|
| 1 | **Ires Agil Karisma** | 19240730 |
| 2 | **Candra Rahmadan** | 19240731 |
| 3 | **Farin Adel Kasela** | 1924xxxx |
| 4 | **Syaiful Aqmal** | 1924xxxx |
| 5 | **M. Hadzasy Syahrul Ghufron** | 1924xxxx |

---

--

## 🚀 Panduan Instalasi (Setup Guide)

Ikuti langkah-masing di bawah ini untuk menjalankan proyek di lingkungan lokal Anda. Pastikan Anda sudah menginstal **PHP**, **Composer**, dan **MySQL/PostgreSQL**.

### 1\. Kloning Repositori

Langkah pertama, unduh source code proyek ini ke mesin lokal Anda:

```bash
git clone https://github.com/lalatina11/siaga-banjir.git
cd siaga-banjir
```

### 2\. Konfigurasi Environment

Salin file contoh environment dan sesuaikan konfigurasi database Anda di dalam file `.env`:

```bash
cp .env.example .env
```

### 3\. Instalasi Dependensi

Jalankan perintah berikut untuk menginstal semua library PHP yang diperlukan via Composer:

```bash
composer install
```

### 4\. Setup Database & Aplikasi

Jalankan perintah otomatis untuk membuat _application key_, menjalankan migrasi database, dan melakukan _seeding_ (jika ada):

```bash
composer run post-create-project-cmd
```

### 5\. Menjalankan Server

Nyalakan server pengembangan lokal:

```bash
composer run dev
```

Atau jika menggunakan perintah standar Laravel:

```bash
php artisan serve
```

### 6\. Akses Aplikasi

Buka browser favorit Anda dan masukkan URL berikut:

> [http://localhost:8000](https://www.google.com/search?q=http://localhost:8000)

---

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel
- **Bahasa Pemrograman:** PHP
- **Database:** MySQL / PostgreSQL
- **Styling:** Tailwind CSS / Bootstrap (sesuaikan jika ada)

## 📝 Catatan Tambahan

Pastikan server database Anda (XAMPP/Docker/Local) sudah aktif sebelum menjalankan langkah ke-4 untuk menghindari error koneksi database.

---

_Dibuat untuk memenuhi tugas mata kuliah Web Programming 3._
