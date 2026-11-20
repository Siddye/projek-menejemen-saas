# 🚀 Digital Agency Studio — Project Management SaaS Platform

> **Tugas Besar Mata Kuliah: Pemrograman Web III**  
> Platform manajemen proyek dan validasi tugas berbasis peran *(Role-Based Access Control)* untuk tim agensi digital kecil dengan antarmuka modern **Glassmorphism**.

---

## 👥 Tim Pengembang (Kelompok)

| No | Foto / Profil | Nama | NPM | Peran Sistem & Tanggung Jawab |
|:---:|:---:|---|---|---|
| **1** | 👔 | **Raffi Casidy** | **25781097** | **Project Manager & Owner** (Pengelola Workspace, Assign Tugas, Validasi Mutu & Approval) |
| **2** | 🎨 | **Rasya Chaniago** | **25781093** | **Graphic Designer** (Desain Aset Visual, Brand Guideline, Siklus Revisi Desain) |
| **3** | 📊 | **Popita Sari** | **25781096** | **Social Media Specialist** (Jadwal Tayang, Distribusi Konten, Analisis Performa) |
| **4** | ✍️ | **Melda Munisa** | **25781091** | **Content Creator** (Ide Kreatif Konten, Copywriting, Penulisan Caption) |

---

## 🌟 Gambaran Umum & Masalah yang Diselesaikan

Di agensi kreatif skala kecil, koordinasi kampanye klien sering kali tersebar di grup chat informal. Hal ini memicu hilangnya brief instruksi, sulitnya melacak progres riil pengerjaan, dan ketiadaan alur verifikasi resmi sebelum materi tayang ke klien.

**Project Management SaaS Platform** hadir dengan solusi:
1. **Multi-Tenancy Workspace:** Setiap agensi memiliki ruang kerja terisolasi dengan data proyek yang aman.
2. **Dynamic Role-Based Task Schema:** Form instruksi brief dan output pekerjaan beradaptasi otomatis sesuai profesi anggota (*Content Creator*, *Graphic Designer*, atau *Social Media Specialist*) menggunakan skema data JSON.
3. **5-Column Interactive Kanban Board:** Pemantauan status pengerjaan secara real-time dari kolom **To Do**, **In Progress**, **Review**, **Revisi**, hingga **Done**.
4. **Alur Validasi Mutu Terpusat:** Anggota mengajukan hasil pekerjaan (status `Review`), dan Owner memvalidasi dengan opsi **Setujui (Approve)** atau **Minta Revisi** disertai catatan transparan yang tersimpan dalam riwayat revisi.
5. **Modern Glassmorphism UI:** Tampilan bergaya desktop frame dengan panel *frosted glass*, ambient aura, sidebar vertikal *deep teal* (`#0e3746`), dan kartu visual informatif.

---

## 🛠️ Tech Stack & Arsitektur

- **Backend:** Laravel 12 (PHP 8.2+)
- **Autentikasi & Keamanan:** Laravel Breeze + Middleware Otorisasi Bertingkat
- **Database:** MySQL (5 Tabel Utama: `workspaces`, `workspace_members`, `projects`, `tasks`, `task_revisions`)
- **Frontend App:** Blade Templating + Bootstrap 5.3 + Bootstrap Icons (CDN) + Plus Jakarta Sans
- **Build Tool:** Vite + Tailwind CSS (Authentication Scaffolding)
- **Testing:** PHPUnit (29 Unit & Feature Tests — 100% Passing)

---

## 🔑 Akun Demo (Studi Kasus)

Semua akun di bawah ini telah disiapkan secara otomatis melalui seeder:

| Nama | Alamat Email | Password | Role Sistem | Job Title |
|---|---|---|---|---|
| **Raffi Casidy** | `raffi@agency.test` | `password` | **Owner** | Project Manager |
| **Rasya Chaniago** | `rasya@agency.test` | `password` | Member | Graphic Designer |
| **Melda Munisa** | `melda@agency.test` | `password` | Member | Content Creator |
| **Popita Sari** | `popita@agency.test` | `password` | Member | Social Media Specialist |

> 💡 **Quick Login:** Di halaman login dan navbar atas tersedia tombol **"Uji Coba Cepat"** untuk berganti akun secara instan tanpa perlu logout atau mengetik ulang password.

---

## 💻 Panduan Instalasi & Menjalankan Proyek

### 1. Prasyarat
Pastikan komputer Anda sudah terpasang:
- PHP >= 8.2
- Composer
- Node.js & NPM
- XAMPP / MySQL

---

### 2. Langkah-Langkah Setup

```bash
# 1. Clone repository ini
git clone https://github.com/Siddye/projek-menejemen-saas.git
cd projek-menejemen-saas

# 2. Install dependensi PHP & Node.js
composer install
npm install
npm run build

# 3. Salin file environment & generate App Key
cp .env.example .env
php artisan key:generate
```

---

### 3. Konfigurasi Database (MySQL)

1. Buka XAMPP Control Panel dan aktifkan **Apache** serta **MySQL**.
2. Buka `phpMyAdmin` (`http://localhost/phpmyadmin`) dan buat database baru bernama:
   ```text
   project management
   ```
3. Pastikan konfigurasi di file `.env` sudah sesuai:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE="project management"
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Jalankan migrasi dan seeder data awal:
   ```bash
   php artisan migrate:fresh --seed
   ```

---

### 4. Jalankan Server Lokal

```bash
php artisan serve
```
Akses aplikasi melalui browser di:  
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🧪 Pengujian Otomatis (Testing)

Aplikasi dilengkapi dengan test suite end-to-end yang menguji workflow workspace, hak akses 403, pembuatan tugas dinamis, dan siklus validasi:

```bash
php artisan test
```

**Hasil Pengujian:**
```text
   PASS  Tests\Unit\ExampleTest
   PASS  Tests\Feature\Auth\AuthenticationTest
   PASS  Tests\Feature\Auth\EmailVerificationTest
   PASS  Tests\Feature\Auth\PasswordConfirmationTest
   PASS  Tests\Feature\Auth\PasswordResetTest
   PASS  Tests\Feature\Auth\PasswordUpdateTest
   PASS  Tests\Feature\Auth\RegistrationTest
   PASS  Tests\Feature\ExampleTest
   PASS  Tests\Feature\ProfileTest
   PASS  Tests\Feature\ProjectManagementWorkflowTest

  Tests:    29 passed (76 assertions)
  Duration: 2.16s
```

---

## 📂 Struktur Dokumen Pendukung Presentasi

Di dalam repository ini telah disertakan dokumen lengkap untuk kebutuhan laporan dan presentasi:
- [`Role.md`](./Role.md) — Skenario detail peran tim dan studi kasus Kopi Nusantara.
- [`perencanaan-project-management-saas.md`](./perencanaan-project-management-saas.md) — Dokumen perencanaan arsitektur, database, dan tahapan implementasi.
- [`script-video-demo-per-role.md`](./script-video-demo-per-role.md) — Naskah video demonstrasi aplikasi terpisah rapi per anggota (4 orang).
- [`daftar-file-penjelasan-video.md`](./daftar-file-penjelasan-video.md) — Panduan bedah kode per baris untuk materi rekaman.

---

## 📜 Lisensi & Hak Cipta
Dikembangkan untuk pemenuhan tugas akademik mata kuliah **Pemrograman Web III** © 2026.

