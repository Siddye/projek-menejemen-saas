# Cara Setup Agency PM Platform (Laravel)

Sandbox Claude nggak bisa akses internet buat `composer install`, jadi semua source code ini perlu digabung ke project Laravel yang lo buat sendiri di komputer/laptop lo. Ikuti langkah ini:

## 1. Buat project Laravel baru + install Breeze

```bash
composer create-project laravel/laravel agency-pm
cd agency-pm
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

## 2. Copy semua file dari folder ini ke project Laravel lo

Timpa/tambahkan file-file berikut (sudah disiapkan lengkap di folder `agency-pm/` ini):

```
database/migrations/2024_01_01_000001_create_workspaces_table.php
database/migrations/2024_01_01_000002_create_workspace_members_table.php
database/migrations/2024_01_01_000003_create_projects_table.php
database/migrations/2024_01_01_000004_create_tasks_table.php
database/migrations/2024_01_01_000005_create_task_revisions_table.php
database/seeders/DatabaseSeeder.php

app/Models/User.php              (TIMPA file bawaan Breeze)
app/Models/Workspace.php
app/Models/WorkspaceMember.php
app/Models/Project.php
app/Models/Task.php
app/Models/TaskRevision.php

app/Http/Middleware/CheckWorkspaceMember.php
app/Http/Controllers/WorkspaceController.php
app/Http/Controllers/ProjectController.php
app/Http/Controllers/TaskController.php
app/Http/Controllers/TaskValidationController.php
app/Http/Controllers/DashboardController.php

routes/web.php                   (TIMPA file bawaan, tapi copy baris Breeze `require __DIR__.'/auth.php';` sudah ada di dalamnya)

resources/views/layouts/app.blade.php
resources/views/dashboard/index.blade.php
resources/views/workspaces/index.blade.php
resources/views/workspaces/create.blade.php
resources/views/workspaces/show.blade.php
resources/views/projects/create.blade.php
resources/views/projects/show.blade.php
resources/views/tasks/create.blade.php
resources/views/tasks/show.blade.php
```

> Catatan: `routes/web.php` di sini sudah termasuk route bawaan Breeze (`profile`, `require auth.php`). Kalau lo sudah custom route lain, gabungkan manual.

## 3. Daftarkan middleware `workspace.member`

**Laravel 11/12** — buka `bootstrap/app.php`, tambahkan di dalam `->withMiddleware()`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'workspace.member' => \App\Http\Middleware\CheckWorkspaceMember::class,
    ]);
})
```

**Laravel 10 ke bawah** — buka `app/Http/Kernel.php`, tambahkan di `$middlewareAliases`:

```php
protected $middlewareAliases = [
    // ... bawaan lainnya
    'workspace.member' => \App\Http\Middleware\CheckWorkspaceMember::class,
];
```

## 4. Setup database

Edit `.env`, isi koneksi database (MySQL atau SQLite). Contoh pakai SQLite (paling simpel buat development):

```env
DB_CONNECTION=sqlite
```

```bash
touch database/database.sqlite
```

## 5. Migrate & seed data dummy

```bash
php artisan migrate --seed
```

Ini otomatis bikin workspace **"Digital Agency Studio"** dengan 4 akun:

| Nama | Email | Password | Role |
|---|---|---|---|
| Raffi | raffi@agency.test | password | Owner |
| Rasya Chaniago | rasya@agency.test | password | Graphic Designer |
| Melda Munisa | melda@agency.test | password | Content Creator |
| Popita Sari | popita@agency.test | password | Social Media Specialist |

Plus 1 campaign klien ("Kopi Nusantara") dengan 3 contoh tugas di status berbeda (todo, in_progress, review) — biar langsung kelihatan isi dashboard & kanban board-nya.

## 6. Jalankan

```bash
php artisan serve
```

Buka `http://localhost:8000`, login pakai salah satu akun di atas.

---

## Cara kerja sistem (ringkas)

- **Raffi (Owner)**: bikin workspace, invite anggota + pilih job_title mereka, bikin campaign klien, assign tugas (form input brief otomatis berubah sesuai job_title anggota yang dipilih — JS di `tasks/create.blade.php`), review & approve/minta revisi tugas yang masuk status **Review**.
- **Rasya/Melda/Popita (Member)**: lihat tugas mereka di dashboard, buka detail tugas → lihat brief (Input) dari Raffi → isi field **Output** sesuai pekerjaan mereka (beda-beda: Content Creator isi caption/naskah, Graphic Designer isi link file desain, Social Media Specialist isi link posting + metrik reach/engagement) → update progress bar → ajukan ke Review.
- **Validasi**: kalau Raffi approve → status jadi Done. Kalau minta revisi → status jadi Revisi + catatan tersimpan di `task_revisions`, anggota bisa lihat catatan dan perbaiki lalu ajukan ulang.
- **Dashboard**: tiap user lihat ringkasan tugas aktifnya sendiri; Raffi (Owner) juga lihat panel khusus "Menunggu Review" di atas dashboard.

Field Input/Output per role diatur di `App\Models\Task::inputSchema()` dan `outputSchema()` — tinggal tambah/ubah array di situ kalau mau nambah field baru per role, nggak perlu ubah migration (disimpan sebagai JSON).
