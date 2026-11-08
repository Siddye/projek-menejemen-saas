# Daftar File untuk Penjelasan Video
Pasangan dari [script-video-presentasi.md](./script-video-presentasi.md). Isi tiap segmen script di bawah ini berasal dari file-file tersebut, jadi tinggal buka file → screenshot / screen-record bagiannya.

Semua path relatif terhadap root proyek.

---

## SEGMENT 1 — Pembukaan & Gambaran Umum (Raffi)

| File | Baris | Yang ditunjukin / dibicarain |
|---|---|---|
| `perencanaan-project-management-saas.md` | 13–40 | Gambaran umum sistem, tabel role, tabel tech stack |
| `Role.md` | 1–10 | Studi kasus tim agensi: Raffi/Rasya/Melda/Popita, workspace "Digital Agency Studio", proyek "Kopi Nusantara" |
| `resources/views/layouts/app.blade.php` | 13–15 | Bootstrap 5 + Bootstrap Icons via CDN (bukti styling-nya) |
| `resources/views/layouts/app.blade.php` | 713–714 | Bootstrap bundle JS |
| `package.json` | 5–20 | Vite sebagai build tool, devDependencies Breeze (tailwind, alpinejs, axios) |
| `.env` | 23–28 | `DB_CONNECTION=mysql`, database `project management` |
| `app/Models/WorkspaceMember.php` | 25–39 | Beda `role` (hak akses) vs `job_title` (label pekerjaan) + `jobTitleLabel()` |
| `database/migrations/2024_01_01_000002_create_workspace_members_table.php` | — | Enum `role`: owner/admin/member |

**Halaman web buat direkam:** `/login`, `/register` (Breeze bawaan).

---

## SEGMENT 2 — Struktur Database & Model (Rasya)

### Migration (5 tabel)

| File | Isi |
|---|---|
| `database/migrations/2024_01_01_000001_create_workspaces_table.php` | `name`, `agency_name`, `owner_id` FK → users |
| `database/migrations/2024_01_01_000002_create_workspace_members_table.php` | pivot + `role` enum + `job_title` nullable |
| `database/migrations/2024_01_01_000003_create_projects_table.php` | `workspace_id`, `name`, `client_name`, `brief`, `start_date`, `deadline` |
| `database/migrations/2024_01_01_000004_create_tasks_table.php` | `assigned_to`, `created_by`, `job_title`, `priority`, `status`, `input_data`, `output_data`, `progress` |
| `database/migrations/2024_01_01_000005_create_task_revisions_table.php` | `task_id`, `note`, `created_by` |
| `database/migrations/0001_01_01_000000_create_users_table.php` | users + password_reset_tokens + sessions (bawaan) |

### Model & relasi

| File | Baris | Yang dibicarain |
|---|---|---|
| `app/Models/Workspace.php` | 14 | `$fillable`: name, agency_name, owner_id |
| `app/Models/Workspace.php` | 16–29 | `owner()` belongsTo, `members()` hasMany, `projects()` hasMany |
| `app/Models/Workspace.php` | 31–39 | `isMember()` dan `memberOf()` — dasar semua cek hak akses |
| `app/Models/WorkspaceMember.php` | 15–23 | relasi `workspace()` dan `user()` balik ke model |
| `app/Models/User.php` | 37–50 | `workspaceMembers()`, `ownedWorkspaces()`, `assignedTasks()` |
| `app/Models/Project.php` | 14–21 | fillable + `$casts` tanggal |
| `app/Models/Project.php` | 23–31 | `workspace()` / `tasks()` |
| `app/Models/Project.php` | 33–44 | `progressPercent()` (tugas done / total) dan `isLate()` level proyek |
| `app/Models/Task.php` | 14–24 | fillable + `$casts` `input_data`/`output_data` jadi array (JSON) |
| `app/Models/Task.php` | 26–44 | `project()`, `assignee()`, `creator()`, `revisions()` |
| `app/Models/TaskRevision.php` | — | simpan catatan revisi dari Owner |
| `database/seeders/DatabaseSeeder.php` | — | data demo: 4 user, 1 workspace, proyek, tugas |

**Perintah buat direkam:** `php artisan migrate:fresh --seed`, lalu cek tabel di phpMyAdmin atau `php artisan tinker`.

---

## SEGMENT 3 — Autentikasi, Workspace & Proyek (Melda)

| File | Baris | Yang dibicarain |
|---|---|---|
| `routes/web.php` | 11–23 | Redirect `/` ke login + route `quick-login/{email}` buat demo ganti role |
| `routes/auth.php` | — | Route bawaan Breeze: login, register, forgot-password, dll |
| `app/Http/Controllers/Auth/RegisteredUserController.php` | — | Register bawaan Breeze |
| `routes/web.php` | 34–47 | Group route workspace + pemasangan middleware `workspace.member` |
| `app/Http/Middleware/CheckWorkspaceMember.php` | 16–28 | Logika middleware: route model binding → `isMember()` → `abort(403)` |
| `bootstrap/app.php` | 13–16 | Pendaftaran alias `workspace.member` di `withMiddleware` (alias `workspace.owner` juga terdaftar tapi tidak dipakai di route) |
| `app/Http/Controllers/WorkspaceController.php` | 24–45 | `store()`: buat workspace + otomatis masukkan owner ke members |
| `app/Http/Controllers/WorkspaceController.php` | 54–77 | `addMember()`: validasi `exists:users,email` + `job_title`, cek `isMember()` biar nggak dobel |
| `app/Http/Controllers/WorkspaceController.php` | 79–90 | `removeMember()`: owner nggak bisa dihapus |
| `app/Http/Controllers/WorkspaceController.php` | 92–96 | `authorizeOwner()` privat — lapis keamanan kedua |
| `app/Http/Controllers/ProjectController.php` | 18–34 | `store()`: validasi `deadline after_or_equal:start_date` |
| `app/Http/Controllers/ProjectController.php` | 36–42 | `show()`: `$project->tasks->groupBy('status')` buat board |
| `app/Http/Controllers/ProjectController.php` | 44–75 | `edit/update/destroy` semua di-guard `authorizeOwner` |
| `resources/views/workspaces/index.blade.php` | — | Daftar workspace milik user |
| `resources/views/workspaces/show.blade.php` | — | Detail workspace: proyek + anggota + form invite |
| `resources/views/projects/create.blade.php` | — | Form buat proyek/campaign |
| `resources/views/projects/show.blade.php` | 93–106 | Render 5 kolom status board (`$statuses`, `status-dot`, warna) |
| `resources/views/projects/show.blade.php` | 121–170 | Kartu tugas + aksen warna + bar progres |

**Halaman web buat direkam:** `/workspaces` → `/workspaces/create` → `/workspaces/1` (invite anggota) → `/workspaces/1/projects/create` → `/projects/1` (board).

---

## SEGMENT 4 — Manajemen Tugas & Alur Validasi (Popita)

| File | Baris | Yang dibicarain |
|---|---|---|
| `app/Models/Task.php` | 76–98 | `inputSchema()` — match expression field brief per `job_title` |
| `app/Models/Task.php` | 101–120 | `outputSchema()` — match expression field hasil kerja per `job_title` |
| `app/Http/Controllers/TaskController.php` | 12–20 | `create()`: ambil anggota ber-role member buat dropdown assignee |
| `app/Http/Controllers/TaskController.php` | 22–54 | `store()`: validasi, cari member, isi `input_data` sesuai skema, status awal `todo` |
| `app/Http/Controllers/TaskController.php` | 64–92 | `updateWork()`: cek `assigned_to`, simpan `progress` + `output_data`, auto `todo → in_progress` |
| `app/Http/Controllers/TaskController.php` | 95–102 | `submitReview()`: status → `review`, progress dipaksa 100 |
| `app/Http/Controllers/TaskController.php` | 104–108 | Guard "ini bukan tugas Anda" (abort 403) |
| `app/Http/Controllers/TaskValidationController.php` | 10–17 | `approve()`: status → `done` |
| `app/Http/Controllers/TaskValidationController.php` | 19–35 | `requestRevision()`: status → `revisi` + `revisions()->create(['note' => ...])` |
| `app/Http/Controllers/TaskValidationController.php` | 37–42 | `authorizeOwner()`: task → project → workspace → cek role owner |
| `app/Http/Controllers/DashboardController.php` | 11–29 | Eager loading `with()`, `myTasks` per status belum selesai, `pendingReviews` via `whereHas` |
| `app/Models/Task.php` | 46–73 | `isLate()`, `statusLabel()`, `statusColor()` |
| `resources/views/tasks/create.blade.php` | — | Form tugas yang field-nya dinamis dari skema input |
| `resources/views/tasks/show.blade.php` | — | Halaman tugas: isi brief, form progres/output, riwayat revisi |
| `resources/views/tasks/review-queue.blade.php` | — | Antrean review khusus Owner |
| `resources/views/dashboard/index.blade.php` | — | Card ringkasan, tugas saya, antrean review, penanda terlambat |

**Halaman web buat direkam (urutan demo alur):**
1. Login sebagai Melda (`/quick-login/...`) → buka tugas → isi progres & output → ajukan review
2. Login sebagai Raffi → `/dashboard` → antrean review → buka tugas → request revisi (tulis catatan)
3. Login Melda lagi → lihat catatan revisi → perbaiki → submit
4. Login Raffi → approve → status Done → cek dashboard berubah

---

## SEGMENT 5 — Penutup (Raffi)

| File | Baris | Yang dibicarain |
|---|---|---|
| `perencanaan-project-management-saas.md` | 115–237 | Checklist Tahap 0–8 yang sudah selesai |
| `perencanaan-project-management-saas.md` | 262–285 | Diagram urutan prioritas pengerjaan |
| `tests/Feature/ProjectManagementWorkflowTest.php` | — | **Test custom kelompok**: uji alur end-to-end workspace → proyek → tugas → validasi (Tahap 8) |
| `tests/Feature/Auth/` + `tests/Feature/ProfileTest.php` | — | Test bawaan Breeze: register, login, password reset, profil |
| `phpunit.xml` | — | Konfigurasi PHPUnit |

---

## Catatan: File yang Ada tapi Tidak Dipakai (jangan dibanggakan dulu di video)

| File | Masalah |
|---|---|
| `app/Policies/ProjectPolicy.php` | Defined tapi tidak pernah dipanggil — tidak ada `$this->authorize()` / `can:` di controller mana pun |
| `app/Policies/TaskPolicy.php` | Sama seperti di atas |
| `app/Http/Controllers/WorkspaceMemberController.php` | Tidak terdaftar di `routes/web.php`; memanggil `$workspace->isOwner()` / `isAdmin()` yang tidak ada di `app/Models/Workspace.php` → fatal error kalau dipanggil |
| `app/Http/Middleware/CheckWorkspaceOwner.php` | Tidak dipakai di route mana pun + memanggil method yang sama (`isOwner`/`isAdmin`) |
| `agency-pm/` | Folder salinan deliverable terpisah, bukan kode yang jalan |
| `database/database.sqlite` | Sisa konfigurasi lama; `.env` sekarang pakai MySQL |

Kalau mau policy-nya jadi "hidup" dan bisa dibanggakan di video, tinggal bilang — guatin refactor `authorizeOwner()` pakai Policy + method `isOwner()`/`isAdmin()` di Workspace model.
