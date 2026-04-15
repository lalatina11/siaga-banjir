---

# 🌊 Siaga Banjir - Monitoring System

**Siaga Banjir** adalah platform monitoring berbasis web yang dirancang untuk memantau tingkat kerawanan banjir secara _real-time_. Proyek ini dikembangkan untuk memenuhi tugas mata kuliah **Web Programming 3**.

---

## 👥 Tim Pengembang (Kelompok 1)

| No  | Nama Lengkap                   |   NIM    |
| :-: | :----------------------------- | :------: |
|  1  | **Ires Agil Karisma**          | 19240730 |
|  2  | **Candra Rahmadan**            | 19240731 |
|  3  | **Farin Adel Kasela**          | 1924xxxx |
|  4  | **Syaiful Aqmal**              | 1924xxxx |
|  5  | **M. Hadzasy Syahrul Ghufron** | 1924xxxx |

---

## 🛠️ Prasyarat Sistem (Prerequisites)

Pastikan lingkungan pengembangan Anda telah terinstal:

- **PHP** (Versi 8.3+)
- **Composer**
- **Node.js & NPM** (atau pnpm/yarn/bun)
- **SQLite**

---

## 🚀 Panduan Instalasi (Setup Guide)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek secara lokal:

### 1\. Kloning Repositori

```bash
git clone https://github.com/lalatina11/siaga-banjir.git
cd siaga-banjir
```

### 2\. Konfigurasi Environment

Salin file environment contoh dan sesuaikan jika diperlukan (default menggunakan SQLite):

```bash
cp .env.example .env
```

### 3\. Instalasi Dependensi

```bash
composer install
npm install
```

### 4\. Inisialisasi Database & Key

Jalankan perintah otomatis untuk men-generate key aplikasi dan melakukan migrasi database:

```bash
composer run post-create-project-cmd
```

### 5\. Menjalankan Server

Terdapat dua opsi untuk menjalankan aplikasi:

**Opsi 1: Menggunakan Composer Script (Disarankan)**
Jalankan perintah berikut:

```bash
composer run dev
```

**Opsi 2: Menjalankan Backend & Frontend Terpisah**
Jika ingin memantau proses secara detail, gunakan dua terminal:

- **Terminal 1 (Laravel):**

```
php artisan serve
```

- **Terminal 2 (Vite/Assets):**

```
npm run dev
```

### 6\. Akses Aplikasi

Buka browser dan kunjungi:
👉 **[http://localhost:8000](https://www.google.com/search?q=http://localhost:8000)**

---

## 📝 Catatan Penting

- Aplikasi ini dikonfigurasi menggunakan **SQLite** agar mudah dalam proses setup awal.
- Pastikan port `8000` tidak sedang digunakan oleh aplikasi lain.

---
