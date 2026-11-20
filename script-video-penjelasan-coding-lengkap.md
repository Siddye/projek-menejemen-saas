# 🎬 SCRIPT VIDEO PRESENTASI WEB & PENJELASAN CODING LENGKAP
**Mata Kuliah:** Pemrograman Web III  
**Judul Proyek:** Project Management SaaS Platform (Digital Agency Studio)  
**Total Durasi Target:** ± 10 – 14 Menit  
**Pembagian Peran:** 4 Orang (Raffi Casidy, Rasya Chaniago, Melda Munisa, Popita Sari)  

> **💡 Catatan Khusus:** Sesuai kriteria penilaian, script ini menyertakan **bedah kode sumber (source code walkthrough)** secara mendalam di setiap peran, dengan porsi coding arsitektural dan pengujian terberat dibawakan oleh **Raffi (Project Manager & Backend Lead)**.

---

## ⏱️ RANGKUMAN RUNDOWN & PEMBAGIAN TUGAS

```text
[00:00 - 03:00] RAFFI CASIDY       : Intro, Arsitektur Routing, Middleware Otorisasi, & Quick-Login
[03:00 - 05:45] RASYA CHANIAGO     : Database Migrations (5 Tabel), Model Eloquent, & UI Glassmorphism
[05:45 - 08:30] MELDA MUNISA       : WorkspaceController, ProjectController, Guard Otorisasi, & View Blade
[08:30 - 11:15] POPITA SARI        : Dynamic Task JSON Schema (Match Expr), TaskController, & Dashboard Eager Loading
[11:15 - 14:00] RAFFI CASIDY       : TaskValidationController, Testing PHPUnit (29 Tests Passing), & Closing
```

---

---

# 👔 BAGIAN 1: RAFFI CASIDY (25781097)
### Role: Project Manager, Workspace Owner & Backend Architect
**Fokus Penjelasan:** Latar Belakang Masalah, Arsitektur Web, Routing (`routes/web.php`), Middleware Otorisasi (`CheckWorkspaceMember`), dan Mekanisme Route Quick-Login.  
**Durasi:** ± 3 Menit  

---

### [Langkah 1.1] Pembukaan & Gambaran Arsitektur Sistem
**[Visual Layar]**  
*Mulai dari tampilan awal web di browser (`http://127.0.0.1:8000/login`) dengan desain glassmorphism, lalu beralih ke editor VS Code membuka diagram/arsitektur di `perencanaan-project-management-saas.md`.*

**[Dialog Narasi Raffi]:**  
> *"Halo semuanya! Selamat datang di video presentasi dan bedah kodingan dari kelompok kami untuk mata kuliah Pemrograman Web III.*  
> 
> *Nama saya **Raffi Casidy** (NPM: 25781097), bertindak sebagai Project Manager sekaligus Owner pada sistem ini. Anggota kelompok kami terdiri dari:*  
> 1. *Saya sendiri, Raffi Casidy,*  
> 2. *Rasya Chaniago sebagai Graphic Designer,*  
> 3. *Melda Munisa sebagai Content Creator, dan*  
> 4. *Popita Sari sebagai Social Media Specialist.*  
> 
> *Aplikasi yang kami bangun adalah **Project Management SaaS Platform** untuk tim agensi digital kecil. Masalah yang kami selesaikan adalah ketidakteraturan delegasi tugas dan validasi mutu kampanye klien jika hanya mengandalkan grup chat. Lewat aplikasi ini, agensi memiliki ruang kerja terisolasi *(multi-tenancy)*, papan Kanban visual, form tugas adaptif, dan siklus verifikasi pekerjaan resmi.*  
> 
> *Sekarang, saya akan langsung membedah fondasi arsitektur routing dan sistem pengamanan akses di sisi backend."*

---

### [Langkah 1.2] Bedah Kodingan: Routing & Nested Routes (`routes/web.php`)
**[Visual Layar]**  
*Buka file `routes/web.php` di VS Code. Sorot baris 11–23 (Quick Login) dan baris 34–60 (Grup Route Middleware).*

**[Dialog Narasi Raffi]:**  
> *"Mari kita buka file **`routes/web.php`**.*  
> 
> *Pertama, perhatikan di baris 15 sampai 23:*  
> ```php
> Route::get('/quick-login/{email}', function (string $email) {
>     $user = \App\Models\User::where('email', $email)->first();
>     if ($user) {
>         \Illuminate\Support\Facades\Auth::login($user);
>         return redirect()->route('dashboard')->with('success', "Berhasil masuk sebagai {$user->name}");
>     }
>     return redirect()->route('login')->with('error', 'User tidak ditemukan.');
> })->name('quick-login');
> ```  
> *Route ini kami buat khusus untuk kebutuhan pengujian demo dosen dan tim, di mana sistem langsung mengautentikasi user via `Auth::login($user)` tanpa perlu mengetik ulang password.*  
> 
> *Kedua, di baris 25 ke bawah, seluruh rute fungsional kami bungkus di dalam grup middleware **`auth`**. Perhatikan di baris 39, kami menerapkan **Nested Route** dan Middleware kustom bernama **`workspace.member`**:*  
> ```php
> Route::middleware('workspace.member')->group(function () {
>     Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
>     Route::post('/workspaces/{workspace}/members', [WorkspaceController::class, 'addMember'])->name('workspaces.members.store');
>     Route::delete('/workspaces/{workspace}/members/{member}', [WorkspaceController::class, 'removeMember'])->name('workspaces.members.destroy');
> 
>     // Project nested di bawah workspace
>     Route::get('/workspaces/{workspace}/projects/create', [ProjectController::class, 'create'])->name('projects.create');
>     Route::post('/workspaces/{workspace}/projects', [ProjectController::class, 'store'])->name('projects.store');
> });
> ```  
> *Pola nested routing ini memastikan bahwa entitas proyek selalu terikat secara hierarkis pada workspace induknya, sehingga tidak mungkin ada proyek tanpa kepemilikan workspace."*

---

### [Langkah 1.3] Bedah Kodingan: Middleware Proteksi Tenant (`app/Http/Middleware/CheckWorkspaceMember.php`)
**[Visual Layar]**  
*Buka file `app/Http/Middleware/CheckWorkspaceMember.php` di VS Code. Sorot baris 16–27.*

**[Dialog Narasi Raffi]:**  
> *"Sekarang kita buka middleware-nya di **`app/Http/Middleware/CheckWorkspaceMember.php`**.*  
> 
> *Di sinilah letak keamanan multi-tenancy kami diimplementasikan:*  
> ```php
> public function handle(Request $request, Closure $next): Response
> {
>     $workspace = $request->route('workspace');
> 
>     if ($workspace instanceof Workspace) {
>         if (!$workspace->isMember($request->user())) {
>             abort(403, 'Anda bukan anggota workspace ini.');
>         }
>     }
> 
>     return $next($request);
> }
> ```  
> *Middleware ini memanfaatkan fitur **Route Model Binding** dari Laravel untuk menginjeksi instance model `$workspace`. Kemudian, kami memanggil method pembantu `isMember($request->user())`.*  
> 
> *Jika seorang user yang sudah login mencoba mengakses URL workspace yang bukan miliknya dengan mengetik URL di browser, server secara otomatis membatalkannya dengan respons HTTP **403 Forbidden**.*  
> 
> *Selanjutnya, rekan saya **Rasya Chaniago** akan menjelaskan perancangan skema database migration dan model Eloquent yang menjadi fondasi penyimpanan data kami."*

---

---

# 🎨 BAGIAN 2: RASYA CHANIAGO (25781093)
### Role: Graphic Designer & Database/UI Architect
**Fokus Penjelasan:** Skema Migrasi Database (5 Tabel), Model Eloquent & Relasinya, serta Sistem Desain Antarmuka Glassmorphism.  
**Durasi:** ± 2,5 Menit  

---

### [Langkah 2.1] Bedah Kodingan: Migration Skema Database
**[Visual Layar]**  
*Buka folder `database/migrations/` di VS Code. Tunjukkan 5 file migrasi utama, lalu buka file migration `create_tasks_table.php` dan `create_workspace_members_table.php`.*

**[Dialog Narasi Rasya]:**  
> *"Halo semuanya! Saya **Rasya Chaniago** (NPM: 25781093), berperan sebagai Graphic Designer di tim agensi ini sekaligus yang merancang struktur database dan desain antarmuka aplikasi.*  
> 
> *Fondasi penyimpanan sistem kami terdiri dari 5 tabel terintegrasi yang kami definisikan melalui Laravel Migration:*  
> 1. *`workspaces` untuk menyimpan nama studio dan foreign key `owner_id` ke tabel `users`.*  
> 2. *`workspace_members` sebagai tabel perantara many-to-many.*  
> 3. *`projects` untuk menyimpan kampanye klien, deskripsi brief, tanggal mulai, dan deadline.*  
> 4. *`tasks` sebagai tabel penugasan kerja.*  
> 5. *`task_revisions` untuk mencatat log instruksi perbaikan dari Owner.*  
> 
> *Mari kita perhatikan file **`create_tasks_table.php`** baris 15 sampai 32:*  
> ```php
> Schema::create('tasks', function (Blueprint $table) {
>     $table->id();
>     $table->foreignId('project_id')->constrained()->cascadeOnDelete();
>     $table->foreignId('assigned_to')->constrained('users')->cascadeOnDelete();
>     $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
>     $table->string('job_title');
>     $table->string('title');
>     $table->text('description')->nullable();
>     $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
>     $table->date('deadline')->nullable();
>     $table->enum('status', ['todo', 'in_progress', 'review', 'revisi', 'done'])->default('todo');
>     $table->json('input_data')->nullable();
>     $table->json('output_data')->nullable();
>     $table->unsignedTinyInteger('progress')->default(0);
>     $table->timestamps();
> });
> ```  
> *Poin penting di sini adalah penggunaan kolom berjenis **JSON** pada `input_data` dan `output_data`. Dengan tipe JSON ini, kita tidak perlu membuat tabel terpisah untuk setiap profesi, melainkan data brief dan hasil kerja dapat disimpan secara fleksibel sesuai keahlian masing-masing."*

---

### [Langkah 2.2] Bedah Kodingan: Model Eloquent & Relasi Data
**[Visual Layar]**  
*Buka `app/Models/Workspace.php` dan `app/Models/Task.php` di VS Code.*

**[Dialog Narasi Rasya]:**  
> *"Sekarang kita beralih ke layer Model Eloquent di **`app/Models/Workspace.php`**.*  
> 
> *Di model ini, kami mendefinisikan relasi `owner()` yang merupakan `belongsTo` ke User, serta relasi `members()` dan `projects()` sebagai `hasMany`.*  
> 
> *Perhatikan baris 31 sampai 39 pada model Workspace:*  
> ```php
> public function isMember(User $user): bool
> {
>     return $this->members()->where('user_id', $user->id)->exists();
> }
> 
> public function memberOf(User $user): ?WorkspaceMember
> {
>     return $this->members()->where('user_id', $user->id)->first();
> }
> ```  
> *Dua method pembantu ini sangat esensial karena digunakan oleh seluruh middleware dan controller untuk memverifikasi hak akses pengguna secara efisien.*  
> 
> *Sedangkan di model **`app/Models/Task.php`**, kami menambahkan property `$casts`:*  
> ```php
> protected $casts = [
>     'input_data' => 'array',
>     'output_data' => 'array',
>     'deadline' => 'date',
> ];
> ```  
> *Cast ini membuat kolom JSON secara otomatis dikonversi menjadi array PHP native saat diakses, dan kembali menjadi format JSON saat disimpan ke database."*

---

### [Langkah 2.3] Sistem Desain Antarmuka Glassmorphism (`resources/views/layouts/app.blade.php`)
**[Visual Layar]**  
*Buka `resources/views/layouts/app.blade.php`. Tunjukkan bagian tag `<style>` baris 17–70, lalu perlihatkan tampilan dashboard di browser.*

**[Dialog Narasi Rasya]:**  
> *"Dari sisi User Interface, kami merancang tema **Modern Glassmorphism** dengan palet warna dark teal `#0e3746` pada sidebar vertikal.*  
> 
> *Di file layout utama **`resources/views/layouts/app.blade.php`**, kami memanfaatkan CSS variabel dan efek visual modern:*  
> - *Container utama `.app-window-frame` menggunakan `backdrop-filter: blur(30px)` dan border semi-transparan `rgba(255, 255, 255, 0.9)`.*  
> - *Main canvas `.app-main-canvas` mengusung background putih frosted `rgba(255, 255, 255, 0.88)` dengan sudut melengkung 32 piksel.*  
> - *Typography didukung oleh font Google **Plus Jakarta Sans** dan icon library **Bootstrap Icons**.*  
> 
> *Hasilnya adalah dashboard yang tampak seperti aplikasi desktop premium, modern, dan sangat nyaman dipandang.*  
> 
> *Selanjutnya, rekan saya **Melda Munisa** akan menjelaskan logika WorkspaceController dan ProjectController."*

---

---

# ✍️ BAGIAN 3: MELDA MUNISA (25781091)
### Role: Content Creator & Business Logic Specialist
**Fokus Penjelasan:** Logika Controller Workspace (`WorkspaceController`), Manajemen Proyek (`ProjectController`), Guard `authorizeOwner()`, dan Tampilan View Blade.  
**Durasi:** ± 2,5 Menit  

---

### [Langkah 3.1] Bedah Kodingan: Logika WorkspaceController
**[Visual Layar]**  
*Buka file `app/Http/Controllers/WorkspaceController.php` di VS Code. Sorot method `store()`, `addMember()`, dan `authorizeOwner()`.*

**[Dialog Narasi Melda]:**  
> *"Halo semuanya! Saya **Melda Munisa** (NPM: 25781091), bertindak sebagai Content Creator di tim ini.*  
> 
> *Saya akan menjelaskan bagaimana logika bisnis workspace dan proyek dikelola pada layer controller.*  
> 
> *Mari kita buka file **`app/Http/Controllers/WorkspaceController.php`** pada method **`store()`** baris 24 sampai 45:*  
> ```php
> public function store(Request $request)
> {
>     $data = $request->validate([
>         'name' => 'required|string|max:255',
>         'agency_name' => 'nullable|string|max:255',
>     ]);
> 
>     $workspace = Workspace::create([
>         'name' => $data['name'],
>         'agency_name' => $data['agency_name'] ?? null,
>         'owner_id' => auth()->id(),
>     ]);
> 
>     WorkspaceMember::create([
>         'workspace_id' => $workspace->id,
>         'user_id' => auth()->id(),
>         'role' => 'owner',
>     ]);
> 
>     return redirect()->route('workspaces.show', $workspace);
> }
> ```  
> *Perhatikan bahwa saat workspace baru dibuat, sistem secara otomatis memasukkan user pembuatnya ke tabel `workspace_members` dengan `role = 'owner'`. Ini menjamin tidak akan pernah ada workspace tanpa pemilik.*  
> 
> *Selanjutnya pada method **`addMember()`** baris 54, kami menerapkan validasi ketat:*  
> 1. *Email harus terdaftar di sistem (`exists:users,email`).*  
> 2. *Job title harus merupakan salah satu dari: `content_creator`, `graphic_designer`, atau `social_media_specialist`.*  
> 3. *Terdapat pengecekan `$workspace->isMember($user)` untuk mencegah anggota ganda.*  
> 
> *Dan untuk perlindungan aksi sensitif, di baris 92 kami membuat method privat **`authorizeOwner()`**:*  
> ```php
> private function authorizeOwner(Workspace $workspace): void
> {
>     $member = $workspace->memberOf(auth()->user());
>     abort_unless($member && $member->isOwner(), 403, 'Aksi ini hanya untuk Owner.');
> }
> ```  
> *Method ini memastikan hanya Owner yang dapat menambah atau menghapus anggota."*

---

### [Langkah 3.2] Bedah Kodingan: Logika ProjectController & Kanban Grouping
**[Visual Layar]**  
*Buka file `app/Http/Controllers/ProjectController.php` di VS Code. Sorot method `store()` dan `show()`.*

**[Dialog Narasi Melda]:**  
> *"Sekarang kita buka file **`app/Http/Controllers/ProjectController.php`**.*  
> 
> *Pada method **`store()`** di baris 18, perhatikan validasi tanggal yang kami gunakan:*  
> ```php
> $data = $request->validate([
>     'name' => 'required|string|max:255',
>     'client_name' => 'required|string|max:255',
>     'brief' => 'nullable|string',
>     'start_date' => 'nullable|date',
>     'deadline' => 'nullable|date|after_or_equal:start_date',
> ]);
> ```  
> *Aturan `after_or_equal:start_date` memastikan secara otomatis bahwa deadline proyek tidak boleh mendahului tanggal mulai proyek.*  
> 
> *Lalu pada method **`show()`** di baris 36:*  
> ```php
> public function show(Project $project)
> {
>     $project->load(['tasks.assignee', 'workspace']);
>     $tasksByStatus = $project->tasks->groupBy('status');
> 
>     return view('projects.show', compact('project', 'tasksByStatus'));
> }
> ```  
> *Di sini kami menggunakan Eloquent Collection `groupBy('status')` yang langsung memecah daftar tugas ke dalam 5 kelompok status: `todo`, `in_progress`, `review`, `revisi`, dan `done`.*  
> 
> *Di file view **`resources/views/projects/show.blade.php`**, variabel `$tasksByStatus` ini di-looping untuk merender kolom Kanban board secara visual dengan kartu-kartu ber-progress bar.*  
> 
> *Selanjutnya, rekan saya **Popita Sari** akan menjelaskan bagaimana tugas dibuat secara dinamis dan diproses di TaskController."*

---

---

# 📊 BAGIAN 4: POPITA SARI (25781096)
### Role: Social Media Specialist & Data Flow Specialist
**Fokus Penjelasan:** Dynamic JSON Schema (`inputSchema` & `outputSchema`), Logika Pengerjaan Tugas (`TaskController`), dan Agregasi Dashboard (`DashboardController`).  
**Durasi:** ± 2,5 Menit  

---

### [Langkah 4.1] Bedah Kodingan: Dynamic Schema via Match Expression (`app/Models/Task.php`)
**[Visual Layar]**  
*Buka file `app/Models/Task.php` di VS Code. Sorot method `inputSchema()` baris 76–98 dan `outputSchema()` baris 101–120.*

**[Dialog Narasi Popita]:**  
> *"Halo semuanya! Saya **Popita Sari** (NPM: 25781096), bertindak sebagai Social Media Specialist di tim agensi ini.*  
> 
> *Saya akan membedah salah satu fitur kodingan paling unik di sistem kami: **Dynamic Task Schema**.*  
> 
> *Mari kita buka file **`app/Models/Task.php`** pada method **`inputSchema()`** di baris 76:*  
> ```php
> public static function inputSchema(string $jobTitle): array
> {
>     return match ($jobTitle) {
>         'content_creator' => [
>             'content_type' => ['label' => 'Jenis Konten', 'type' => 'select', 'options' => ['Reels / TikTok', 'Carousel Feed', 'Single Post Feed', 'Story']],
>             'topic' => ['label' => 'Topik / Pilar Konten', 'type' => 'text'],
>             'tone_of_voice' => ['label' => 'Tone of Voice', 'type' => 'text'],
>             'reference_url' => ['label' => 'Link Referensi', 'type' => 'url'],
>         ],
>         'graphic_designer' => [
>             'design_type' => ['label' => 'Jenis Desain', 'type' => 'select', 'options' => ['Feed 1:1', 'Story 9:16', 'Banner Banner Ads', 'Packaging Mockup']],
>             'dimensions' => ['label' => 'Dimensi / Ukuran', 'type' => 'text'],
>             'brand_guideline_url' => ['label' => 'Link Brand Guideline', 'type' => 'url'],
>             'color_notes' => ['label' => 'Catatan Warna / Asset', 'type' => 'text'],
>         ],
>         'social_media_specialist' => [
>             'platform' => ['label' => 'Platform', 'type' => 'select', 'options' => ['Instagram', 'TikTok', 'LinkedIn', 'Twitter/X']],
>             'target_date' => ['label' => 'Target Tanggal Posting', 'type' => 'date'],
>             'campaign_goal' => ['label' => 'Goal Campaign', 'type' => 'text'],
>         ],
>         default => [],
>     };
> }
> ```  
> *Kami memanfaatkan sintaks **PHP 8 `match` expression**.*  
> *Ketika Owner memilih anggota di halaman form penugasan, JavaScript di frontend membaca atribut data role, dan sistem backend memvalidasi serta merender field yang sesuai dengan keahlian anggota tersebut.*  
> 
> *Hal yang sama berlaku untuk method **`outputSchema()`**, di mana Content Creator mengumpulkan teks caption, Graphic Designer mengumpulkan link file desain, dan saya sebagai Sosmed Specialist mengumpulkan link jadwal posting serta catatan performa reach dan engagement."*

---

### [Langkah 4.2] Bedah Kodingan: Siklus Pengerjaan Tugas (`TaskController.php`)
**[Visual Layar]**  
*Buka file `app/Http/Controllers/TaskController.php` di VS Code. Sorot method `updateWork()` baris 64–92 dan `submitReview()` baris 95–102.*

**[Dialog Narasi Popita]:**  
> *"Sekarang kita buka file **`app/Http/Controllers/TaskController.php`**.*  
> 
> *Perhatikan method **`updateWork()`** pada baris 64 yang digunakan anggota saat mengerjakan tugas:*  
> ```php
> public function updateWork(Request $request, Task $task)
> {
>     abort_unless($task->assigned_to === auth()->id(), 403, 'Bukan tugas Anda.');
> 
>     $progress = (int) $request->input('progress', 0);
>     $outputData = $request->input('output', []);
> 
>     $update = [
>         'progress' => $progress,
>         'output_data' => $outputData,
>     ];
> 
>     if ($task->status === 'todo' && $progress > 0) {
>         $update['status'] = 'in_progress';
>     }
> 
>     $task->update($update);
> 
>     return back()->with('success', 'Hasil pekerjaan dan progres berhasil disimpan.');
> }
> ```  
> *Ada dua hal penting di sini:*  
> 1. *Proteksi server: `abort_unless($task->assigned_to === auth()->id(), 403)`. Pengguna tidak akan pernah bisa mengubah tugas milik anggota lain.*  
> 2. *Otomatisasi status: Jika status tugas masih `todo` tetapi input slider progres dinaikkan lebih dari 0%, sistem otomatis mengubah statusnya menjadi `in_progress` tanpa butuh tombol manual.*  
> 
> *Ketika pekerjaan rampung, anggota memanggil method **`submitReview()`** di baris 95:*  
> ```php
> public function submitReview(Task $task)
> {
>     abort_unless($task->assigned_to === auth()->id(), 403, 'Bukan tugas Anda.');
> 
>     $task->update([
>         'status' => 'review',
>         'progress' => 100,
>     ]);
> 
>     return back()->with('success', 'Tugas diajukan untuk direview oleh Owner.');
> }
> ```  
> *Status langsung berubah menjadi `review` dan progres dipaksa menjadi 100% untuk menunggu persetujuan Owner."*

---

### [Langkah 4.3] Bedah Kodingan: Agregasi Dashboard & Optimasi Eager Loading (`DashboardController.php`)
**[Visual Layar]**  
*Buka file `app/Http/Controllers/DashboardController.php` di VS Code. Sorot baris 11–29.*

**[Dialog Narasi Popita]:**  
> *"Terakhir, mari kita lihat bagaimana Dashboard merangkum semua data di **`app/Http/Controllers/DashboardController.php`**.*  
> 
> *Kami menerapkan teknik **Eager Loading** untuk mencegah terjadinya N+1 Query Problem:*  
> ```php
> $memberships = $user->workspaceMembers()
>     ->with(['workspace.projects.tasks.assignedUser'])
>     ->get();
> ```  
> *Dan untuk panel antrean validasi khusus Owner di dashboard, kami menuliskan query:*  
> ```php
> $pendingReviews = Task::whereHas('project', function ($q) use ($ownedWorkspaceIds) {
>         $q->whereIn('workspace_id', $ownedWorkspaceIds);
>     })
>     ->where('status', 'review')
>     ->with(['project', 'assignee'])
>     ->get();
> ```  
> *Query ini secara efisien memfilter seluruh tugas berstatus review yang hanya berada di workspace milik Owner.*  
> 
> *Selanjutnya, Project Manager kami, **Raffi Casidy**, akan menutup presentasi dengan menjelaskan controller validasi dan pembuktian automated testing!"*

---

---

# 👔 BAGIAN 5: RAFFI CASIDY (25781097) — PENUTUP
### Role: Project Manager & Backend Architect
**Fokus Penjelasan:** Logika Validasi & Approval (`TaskValidationController`), Eksekusi Pengujian Otomatis (`php artisan test`), dan Kesimpulan Akhir.  
**Durasi:** ± 2,5 Menit  

---

### [Langkah 5.1] Bedah Kodingan: Logika Validasi & Riwayat Revisi (`TaskValidationController.php`)
**[Visual Layar]**  
*Buka file `app/Http/Controllers/TaskValidationController.php` di VS Code. Sorot baris 10–35.*

**[Dialog Narasi Raffi]:**  
> *"Kembali lagi bersama saya, Raffi Casidy.*  
> 
> *Sekarang kita masuk ke tahap akhir siklus kerja agensi, yaitu alur verifikasi pekerjaan di **`app/Http/Controllers/TaskValidationController.php`**.*  
> 
> *Di controller ini terdapat dua fungsi utama:*  
> 1. *Method **`approve()`** pada baris 10:*  
> ```php
> public function approve(Task $task)
> {
>     $this->authorizeOwner($task);
>     $task->update(['status' => 'done', 'progress' => 100]);
>     return back()->with('success', 'Tugas disetujui dan dinyatakan selesai.');
> }
> ```  
> *Jika pekerjaan anggota sudah memenuhi standar agensi, Owner mengklik Approve, dan status tugas di-update menjadi `done`.*  
> 
> 2. *Method **`requestRevision()`** pada baris 19:*  
> ```php
> public function requestRevision(Request $request, Task $task)
> {
>     $this->authorizeOwner($task);
> 
>     $data = $request->validate([
>         'note' => 'required|string',
>     ]);
> 
>     $task->update(['status' => 'revisi']);
> 
>     $task->revisions()->create([
>         'created_by' => auth()->id(),
>         'note' => $data['note'],
>     ]);
> 
>     return back()->with('success', 'Tugas dikembalikan untuk revisi.');
> }
> ```  
> *Jika ada kekurangan, Owner wajib menyertakan catatan perbaikan. Sistem mengubah status tugas menjadi `revisi`, dan secara otomatis menyimpan catatan tersebut ke tabel `task_revisions` lewat relasi Eloquent.*  
> *Anggota dapat membaca instruksi revisi ini secara transparan di antarmuka tugas dan memperbaikinya kembali."*

---

### [Langkah 5.2] Pembuktian Kodingan: Feature Test Otomatis (`ProjectManagementWorkflowTest.php`)
**[Visual Layar]**  
*Buka file `tests/Feature/ProjectManagementWorkflowTest.php` di VS Code, tunjukkan skenario test baris 81–163. Kemudian buka terminal dan jalankan perintah `php artisan test` hingga muncul hasil 29 tests passed berwarna hijau.*

**[Dialog Narasi Raffi]:**  
> *"Untuk membuktikan bahwa seluruh logika kodingan yang kami rancang bukan sekadar teori, kami telah menyusun skenario pengujian komprehensif di **`tests/Feature/ProjectManagementWorkflowTest.php`**.*  
> 
> *Di file test ini, kami menguji 4 skenario vital:*  
> 1. *Rendering dashboard multi-role,*  
> 2. *Pencegahan hak akses: Member tidak dapat membuat proyek (menghasilkan respons 403),*  
> 3. *Owner membuat tugas dan mendelegasikannya ke anggota,*  
> 4. *Serta alur penuh siklus tugas: dari `todo` ➔ `in_progress` ➔ `review` ➔ `revisi` ➔ `review` kembali ➔ hingga `done`.*  
> 
> *Sekarang mari kita jalankan perintah pengujian di terminal:*  
> *(Ketik dan enter di terminal)*  
> ```bash
> php artisan test
> ```  
> *(Tunjukkan layar terminal)*  
> *Dapat kita lihat bersama: seluruh **29 tests dengan 76 assertions berjalan 100% sukses tanpa ada satu pun error atau failure**.*  
> *Hal ini membuktikan keandalan sistem kami dari layer database, model, middleware, controller, hingga antarmuka Blade."*

---

### [Langkah 5.3] Penutup & Kesimpulan
**[Visual Layar]**  
*Kembali ke tampilan utama dashboard browser atau slide presentasi kelompok.*

**[Dialog Narasi Raffi]:**  
> *"Sebagai kesimpulan, **Project Management SaaS Platform** ini telah memenuhi seluruh kriteria fungsional dan teknis yang ditugaskan pada mata kuliah Pemrograman Web III.*  
> 
> *Melalui penerapan arsitektur MVC Laravel yang bersih, validasi ketat di sisi server, form dinamis adaptif berbasis JSON, serta estetika UI Glassmorphism, aplikasi ini siap menjadi solusi nyata bagi operasional agensi kreatif.*  
> 
> *Sekian presentasi dan bedah kodingan dari kelompok kami: saya Raffi Casidy, bersama Rasya Chaniago, Melda Munisa, dan Popita Sari. Mohon maaf apabila ada kekurangan. Terima kasih banyak atas perhatian Bapak/Ibu dosen pengampu. Wassalamualaikum warahmatullahi wabarakatuh."*

---

## 💡 TIPS REKAMAN & SCREEN RECORDING:
1. **Layout Layar:** Bagi layar menjadi 2 jendela jika memungkinkan (kiri VS Code untuk menyorot baris kode, kanan browser untuk memperlihatkan efek visualnya secara nyata).
2. **Kualitas Font di VS Code:** Perbesar font VS Code *(Ctrl + +)* sebanyak 2x agar baris kodingan terbaca sangat jelas dan tajam di rekaman video.
3. **Eksekusi Test:** Pastikan menjalankan `php artisan test` di akhir segmen Raffi sebagai penutup yang memukau dosen penguji!
