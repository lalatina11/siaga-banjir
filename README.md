Tentu, ini versi yang lebih rapi, modern, dan profesional. Saya telah memperbaiki bagian _badges_, menyusun ulang langkah-langkah instalasi agar lebih logis, serta menambahkan bagian fitur dan prasyarat sistem yang lebih jelas.

---

# 🌊 Siaga Banjir - Monitoring System

**Siaga Banjir** adalah platform monitoring berbasis web yang dirancang untuk memantau tingkat kerawanan banjir secara _real-time_. Proyek ini dikembangkan untuk memenuhi tugas mata kuliah **Web Programming 3**.

---

## 👥 Tim Pengembang (Kelompok 1)

| No  | Nama Lengkap                   |   NIM    |        Peran        |
| :-: | :----------------------------- | :------: | :-----------------: |
|  1  | **Ires Agil Karisma**          | 19240730 | Fullstack Developer |
|  2  | **Candra Rahmadan**            | 19240731 | Fullstack Developer |
|  3  | **Farin Adel Kasela**          | 1924xxxx |   UI/UX Designer    |
|  4  | **Syaiful Aqmal**              | 1924xxxx |  Quality Assurance  |
|  5  | **M. Hadzasy Syahrul Ghufron** | 1924xxxx |    Documentation    |

---

## ✨ Fitur Utama

- 📍 **Monitoring Real-Time:** Pantau status debit air dan tingkat kerawanan secara instan.
- 📊 **Visualisasi Data:** Penyajian data dalam bentuk yang mudah dipahami.
- 📱 **Responsive Design:** Tampilan optimal di perangkat mobile maupun desktop.
- 🔒 **Secure System:** Implementasi keamanan standar Laravel.

---

## 🛠️ Prasyarat Sistem (Prerequisites)

Sebelum memulai, pastikan perangkat Anda telah terinstal:

- **PHP** (Versi 8.2 atau lebih baru)
- **Composer**
- **Node.js & NPM** (Bisa juga menggunakan pnpm, yarn, atau bun)
- **SQLite**

---

## 🚀 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal:

### 1\. Kloning Repositori

```bash
git clone https://github.com/lalatina11/siaga-banjir.git
cd siaga-banjir
```

### 2\. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`. Secara default, proyek ini menggunakan **SQLite**, pastikan konfigurasi `DB_CONNECTION` sudah sesuai.

```bash
cp .env.example .env
```

### 3\. Instalasi Dependensi

Instal library PHP (Composer) dan package frontend (NPM):

```bash
composer install
npm install
```

### 4\. Inisialisasi Aplikasi & Database

Jalankan perintah berikut untuk men-generate key dan menyiapkan migrasi database:

```bash
php artisan key:generate
php artisan migrate --seed
```

_Atau gunakan shortcut composer jika tersedia:_ `composer run post-create-project-cmd`

### 5\. Menjalankan Aplikasi

Anda perlu menjalankan dua terminal secara bersamaan:

**Terminal 1 (Backend):**

```bash
php artisan serve
```

**Terminal 2 (Frontend Assets):**

```bash
npm run dev
```

### 6\. Akses

Buka browser Anda dan akses melalui URL:
👉 **[http://localhost:8000](https://www.google.com/search?q=http://localhost:8000)**

---

## 🧰 Tech Stack

- **Backend:** Laravel 13 (PHP)
- **Frontend:** Tailwind CSS
- **Database:** SQLite
- **Build Tool:** Vite

---

\<p align="center"\>
\<i\>Dibuat dengan ❤️ oleh Kelompok 1 - Web Programming 3\</i\>
\</p\>
