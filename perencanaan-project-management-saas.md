# Perencanaan & Tahapan Pembangunan
## Project Management SaaS Platform Berbasis Laravel

**Mata Kuliah:** Pemrograman Web III
**Kelompok:**
- Raffi (25781097) — Project Manager / Owner
- Rasya Chaniago (25781093) — Graphic Designer
- Melda Munisa (25781091) — Content Creator
- Popita Sari (25781096) — Social Media Specialist

---

## 1. Gambaran Umum Sistem

Aplikasi web berbasis Laravel yang berfungsi sebagai platform manajemen proyek dan validasi tugas untuk tim kecil (agensi/startup). Setiap tim memiliki **workspace** sendiri, di dalamnya terdapat **proyek-proyek**, dan setiap proyek berisi **tugas-tugas** yang dibagikan ke anggota dengan alur validasi sebelum dinyatakan selesai.

### Role dalam Sistem

| Role Sistem | Hak Akses |
|---|---|
| **Owner** | Kelola workspace, invite/hapus anggota, buat proyek, assign tugas, validasi (approve/revisi) tugas, lihat dashboard |
| **Admin** *(opsional)* | Sama seperti Owner kecuali hapus workspace |
| **Member** | Lihat proyek & tugas miliknya, update status tugas, ajukan tugas untuk review |

Role Owner di studi kasus dipegang oleh **Raffi**. Rasya, Melda, dan Popita berperan sebagai **Member**, dibedakan lewat kolom `job_title` (Graphic Designer, Content Creator, Social Media Specialist) — ini label pekerjaan, bukan hak akses sistem.

---

## 2. Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Framework | Laravel (versi terbaru) |
| Autentikasi | Laravel Breeze |
| Database | MySQL |
| Templating | Blade |
| Styling | Bootstrap / Tailwind CSS |
| Chart (dashboard) | Chart.js *(opsional)* |

---

## 3. Rancangan Database (ERD)

### 3.1 Tabel `users` *(bawaan Breeze)*
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | varchar | |
| email | varchar, unique | |
| password | varchar | |
| created_at, updated_at | timestamp | |

### 3.2 Tabel `workspaces`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | varchar | Nama workspace, misal "Digital Agency Studio" |
| owner_id | bigint, FK → users.id | Pembuat/pemilik workspace |
| created_at, updated_at | timestamp | |

### 3.3 Tabel `workspace_members`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| workspace_id | bigint, FK → workspaces.id | |
| user_id | bigint, FK → users.id | |
| role | enum('owner','admin','member') | Hak akses sistem |
| job_title | varchar, nullable | Label pekerjaan: "Graphic Designer", dst |
| created_at, updated_at | timestamp | |

### 3.4 Tabel `projects`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| workspace_id | bigint, FK → workspaces.id | |
| name | varchar | |
| description | text, nullable | |
| start_date | date | |
| deadline | date | |
| created_at, updated_at | timestamp | |

### 3.5 Tabel `tasks`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| project_id | bigint, FK → projects.id | |
| assigned_to | bigint, FK → users.id | Anggota yang mengerjakan |
| title | varchar | |
| description | text, nullable | |
| priority | enum('low','medium','high') | |
| deadline | date | |
| status | enum('todo','in_progress','review','revisi','done') | Default: 'todo' |
| created_at, updated_at | timestamp | |

### 3.6 Tabel `task_revisions`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| task_id | bigint, FK → tasks.id | |
| note | text | Catatan perbaikan dari Owner |
| created_by | bigint, FK → users.id | |
| created_at, updated_at | timestamp | |

### 3.7 Relasi Antar Tabel
```
users (1) ---- (N) workspace_members (N) ---- (1) workspaces
workspaces (1) ---- (N) projects
projects (1) ---- (N) tasks
users (1) ---- (N) tasks           [sebagai assigned_to]
tasks (1) ---- (N) task_revisions
```

---

## 4. Tahapan Pengembangan

### Tahap 0 — Persiapan Project
1. Install Laravel baru: `composer create-project laravel/laravel nama-project`
2. Konfigurasi `.env` (database, app name)
3. Buat database MySQL kosong, sesuaikan `.env`
4. Install Laravel Breeze: `composer require laravel/breeze --dev` → `php artisan breeze:install`
5. Jalankan `npm install && npm run dev`
6. Jalankan `php artisan migrate` untuk tabel bawaan (users, dll)
7. Inisialisasi Git repository, buat `.gitignore`

**Output tahap ini:** Project Laravel jalan, halaman login/register bawaan Breeze sudah bisa diakses.

---

### Tahap 1 — Desain & Migrasi Database
1. Buat migration untuk tiap tabel (urutan sesuai dependency):
   - `workspaces`
   - `workspace_members`
   - `projects`
   - `tasks`
   - `task_revisions`
2. Buat Model Eloquent untuk tiap tabel, lengkapi dengan relasi (`hasMany`, `belongsTo`)
3. Buat Seeder untuk data dummy (1 workspace, 4 user, beberapa proyek & tugas) agar memudahkan testing
4. Jalankan `php artisan migrate --seed`

**Output tahap ini:** Struktur database lengkap, bisa diverifikasi lewat `php artisan tinker` atau tool seperti phpMyAdmin/TablePlus.

---

### Tahap 2 — Autentikasi & Profil
1. Pastikan login/register Breeze berfungsi
2. Tambahkan field tambahan di form register jika perlu (misal nomor WA, foto profil)
3. Buat halaman dashboard kosong sebagai landing setelah login (`/dashboard`)
4. Buat Middleware dasar `auth` sudah otomatis dari Breeze — pastikan semua route sistem di-wrap middleware ini

**Output tahap ini:** User bisa daftar, login, logout, dan diarahkan ke dashboard.

---

### Tahap 3 — Workspace & Manajemen Anggota
1. **Controller:** `WorkspaceController`, `WorkspaceMemberController`
2. **Routes:**
   - `GET /workspaces` — daftar workspace milik user
   - `GET /workspaces/create` & `POST /workspaces` — buat workspace baru
   - `GET /workspaces/{id}` — detail workspace (daftar proyek di dalamnya)
   - `POST /workspaces/{id}/members` — invite anggota (input email, pilih role + job_title)
   - `DELETE /workspaces/{id}/members/{userId}` — hapus anggota
3. **Middleware kustom:** `CheckWorkspaceMember` — pastikan user yang akses adalah anggota workspace tsb
4. **Logika penting:**
   - Saat workspace dibuat, otomatis masukkan pembuatnya ke `workspace_members` dengan role `owner`
   - Invite anggota: cari user berdasarkan email, jika ada → masukkan ke `workspace_members`

**Output tahap ini:** Raffi bisa membuat workspace "Digital Agency Studio" dan menambahkan Rasya, Melda, Popita sebagai member dengan job_title masing-masing.

---

### Tahap 4 — Manajemen Proyek
1. **Controller:** `ProjectController`
2. **Routes (nested di bawah workspace):**
   - `GET /workspaces/{id}/projects` — daftar proyek
   - `GET /workspaces/{id}/projects/create` & `POST ...` — buat proyek
   - `GET /projects/{id}` — detail proyek (daftar tugas)
   - `PUT /projects/{id}` & `DELETE /projects/{id}` — edit/hapus
3. **Otorisasi:** gunakan Laravel Policy (`ProjectPolicy`) — hanya role `owner`/`admin` yang boleh create/edit/delete

**Output tahap ini:** Raffi bisa membuat proyek "Campaign Media Sosial — Klien Kopi Nusantara" di dalam workspace.

---

### Tahap 5 — Manajemen Tugas
1. **Controller:** `TaskController`
2. **Routes (nested di bawah project):**
   - `GET /projects/{id}/tasks` — daftar tugas (bisa ditampilkan sebagai Kanban board)
   - `POST /projects/{id}/tasks` — buat tugas baru (pilih assigned_to dari anggota workspace, priority, deadline)
   - `PUT /tasks/{id}` — edit tugas
   - `PUT /tasks/{id}/status` — update status (dipakai member untuk ubah To Do → In Progress → Review)
3. **Otorisasi:**
   - Owner: bisa create/edit semua tugas
   - Member: hanya bisa update status tugas miliknya sendiri (`assigned_to == auth()->id()`)
4. **Tampilan:** board dengan 5 kolom (To Do, In Progress, Review, Revisi, Done) — bisa pakai drag-and-drop (JS) atau tombol ubah status sederhana dulu

**Output tahap ini:** Raffi bisa assign tugas ke Melda (konten), Rasya (desain), dan Popita (jadwal posting + laporan), masing-masing bisa lihat & update tugasnya sendiri.

---

### Tahap 6 — Validasi Tugas (Review & Revisi)
1. **Controller:** `TaskValidationController`
2. **Routes:**
   - `POST /tasks/{id}/submit-review` — member ajukan tugas (status → `review`)
   - `POST /tasks/{id}/approve` — owner setujui (status → `done`)
   - `POST /tasks/{id}/request-revision` — owner minta revisi (status → `revisi`, simpan catatan ke `task_revisions`)
3. **Tampilan:**
   - Halaman khusus Owner: daftar tugas berstatus `review` yang perlu diperiksa
   - Member bisa lihat riwayat catatan revisi pada tugasnya

**Output tahap ini:** Alur validasi penuh — Melda submit review → Raffi approve/minta revisi → jika revisi, Melda perbaiki dan submit ulang.

---

### Tahap 7 — Dashboard Progres
1. **Controller:** `DashboardController`
2. **Query yang dibutuhkan:**
   - Total tugas per status (group by `status`) dalam satu proyek/workspace
   - Tugas yang `deadline < today()` dan `status != 'done'` → ditandai "terlambat"
   - Jumlah proyek aktif dalam workspace
3. **Tampilan:**
   - Card ringkasan (total tugas, selesai, sedang dikerjakan, terlambat)
   - Chart sederhana (pie/bar) pakai Chart.js — opsional

**Output tahap ini:** Raffi bisa melihat ringkasan progres campaign secara real-time dari satu halaman.

---

### Tahap 8 — Testing & Finalisasi
1. Uji alur end-to-end: register → login → buat workspace → invite anggota → buat proyek → assign tugas → update status → validasi → cek dashboard
2. Perbaiki validasi form (required fields, format tanggal, dll)
3. Tambahkan pesan error/sukses yang jelas (flash message)
4. Rapikan tampilan (responsive, konsisten antar halaman)
5. Siapkan data seeder final untuk keperluan demo/presentasi
6. Dokumentasikan fitur yang sudah jadi untuk laporan akhir

---

## 5. Struktur Routing Ringkas

```
/register, /login, /logout              → Breeze (bawaan)
/dashboard                              → Dashboard utama

/workspaces                             → index, create, store
/workspaces/{id}                        → show
/workspaces/{id}/members                → store (invite), destroy (remove)

/workspaces/{id}/projects               → index, create, store
/projects/{id}                          → show, update, destroy

/projects/{id}/tasks                    → index, store
/tasks/{id}                             → update
/tasks/{id}/status                      → update (ubah status)
/tasks/{id}/submit-review               → ajukan review
/tasks/{id}/approve                     → setujui
/tasks/{id}/request-revision            → minta revisi
```

---

## 6. Urutan Prioritas Pengerjaan (Ringkasan)

```
Tahap 0: Setup Project
   ↓
Tahap 1: Database & Migration
   ↓
Tahap 2: Autentikasi
   ↓
Tahap 3: Workspace & Member
   ↓
Tahap 4: Manajemen Proyek
   ↓
Tahap 5: Manajemen Tugas
   ↓
Tahap 6: Validasi Tugas
   ↓
Tahap 7: Dashboard Progres
   ↓
Tahap 8: Testing & Finalisasi
```

Setiap tahap bergantung pada tahap sebelumnya (tidak bisa buat Task tanpa Project, tidak bisa buat Project tanpa Workspace), sehingga urutan ini sebaiknya diikuti secara berurutan, tidak diacak.
