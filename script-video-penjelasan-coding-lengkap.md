# 🎬 SCRIPT VIDEO PRESENTASI: DEMO FITUR TIAP ROLE + BEDAH CODING (KHUSUS RAFFI)
**Mata Kuliah:** Pemrograman Web III  
**Judul Proyek:** Project Management SaaS Platform (Digital Agency Studio)  
**Total Durasi:** ± 10 – 12 Menit  

---

## 👥 STRUKTUR PEMBAGIAN TUGAS

| No | Nama | Peran | Tugas di Video | Apa yang Ditampilkan di Layar |
|---|---|---|---|---|
| **1** | **Raffi Casidy** (25781097) | **Owner & Project Manager** | **Pembukaan & Demo Owner** | Browser: Login Glassmorphism, Dashboard Owner, Review Queue, Kanban Board, & Form Tugas Dinamis. |
| **2** | **Melda Munisa** (25781091) | **Content Creator (Member)** | **Demo Fitur Konten** | Browser: Dashboard Member, Dual-Panel Brief/Output, Slider Progres, Auto Status (`todo` ➔ `in_progress`), Submit Review. |
| **3** | **Popita Sari** (25781096) | **Social Media Specialist (Member)** | **Demo Fitur Sosmed & Approval** | Browser: Keamanan antar-member (read-only tugas orang lain), tugas jadwal & analytics, alur disetujui Owner (`Done`). |
| **4** | **Rasya Chaniago** (25781093) | **Graphic Designer (Member)** | **Demo Fitur Desain & Alur Revisi** | Browser: Brief aset visual, menerima catatan revisi Owner di panel Riwayat Revisi, perbaikan & resubmit. |
| **5** | **Raffi Casidy** (25781097) | **Lead Programmer / Developer** | **BEDAH CODING LENGKAP & TESTING** | **VS Code & Terminal:** Bedah Database & Model, Routing & Middleware Guard, Dynamic Schema, Validation Controller, & Run `php artisan test` (29 passed). |

---

## ⏱️ RUNDOWN WAKTU

```text
[00:00 - 02:00] RAFFI CASIDY       : Intro, Konsep Sistem, Login UI, & Dashboard Owner
[02:00 - 04:00] MELDA MUNISA       : Demo Fitur Content Creator (Brief, Output, Slider, Auto Status)
[04:00 - 06:00] POPITA SARI        : Demo Fitur Sosmed Specialist, Guard Antar-Anggota, & Alur Approved (Done)
[06:00 - 08:00] RASYA CHANIAGO     : Demo Fitur Graphic Designer, Menerima Catatan Revisi, & Resubmit
[08:00 - 11:30] RAFFI CASIDY       : BEDAH CODING LENGKAP DI VS CODE & RUNNING TEST (POIN PLUS!)
[11:30 - 12:00] RAFFI CASIDY       : Kesimpulan & Penutup
```

---

---

# 👔 BAGIAN 1: RAFFI CASIDY — PEMBUKAAN & DEMO OWNER
**Fokus:** Konsep Sistem Agensi, UI Login Modern, Dashboard Owner, Fitur Review Queue, dan Pembuatan Tugas Dinamis.  
**Tampilan Layar:** Browser (`http://127.0.0.1:8000/login`) ➔ Dashboard Owner  
**Durasi:** ± 2 Menit  

---

### [Aksi 1.1] Intro & Tampilan Login
**[Visual Layar]**  
*Tampilkan halaman login browser `http://127.0.0.1:8000/login`. Tunjukkan desain glassmorphism modern, sidebar login gelap, dan kotak Quick Login di bawah.*

**[Narasi Raffi]:**  
> *"Halo semuanya! Selamat datang di video presentasi kelompok kami untuk mata kuliah Pemrograman Web III.*  
> 
> *Nama saya **Raffi Casidy** (NPM: 25781097), bertindak sebagai Project Manager dan Owner workspace. Di kelompok ini, saya bekerja bersama 3 rekan saya:*  
> 1. *Melda Munisa sebagai Content Creator,*  
> 2. *Popita Sari sebagai Social Media Specialist, dan*  
> 3. *Rasya Chaniago sebagai Graphic Designer.*  
> 
> *Aplikasi yang kami bangun adalah **Project Management SaaS Platform**, platform kolaborasi agensi digital untuk mengelola kampanye klien. Sistem ini memecahkan masalah koordinasi tugas yang berantakan di grup chat lewat alur kerja terstruktur dan verifikasi mutu resmi.*  
> 
> *Antarmuka aplikasi dirancang dengan tema **Modern Glassmorphism** berpalet dark teal. Untuk kemudahan pengujian, kami menyediakan fitur **Quick Login Demo** dengan 4 akun studi kasus tim kami. Mari kita masuk menggunakan akun saya sebagai Owner."*

---

### [Aksi 1.2] Dashboard Owner & Fitur Eksklusif Review Queue
**[Visual Layar]**  
*Klik tombol quick login **Raffi**. Masuk ke `/dashboard`. Arahkan kursor ke kartu proyek Kopi Nusantara, kartu 'Validasi Tugas Anggota' (Review Queue), dan Kanban board proyek.*

**[Narasi Raffi]:**  
> *"Di dashboard Raffi sebagai Owner, ada komponen istimewa yang menjadi keunggulan sistem kami: widget **'Validasi Tugas Anggota / Review Queue'**.*  
> 
> *Panel ini **hanya muncul pada akun Owner** ketika ada tugas anggota yang sudah diajukan untuk direview. Project Manager tidak perlu mencari tugas satu per satu; dari sini Owner bisa langsung memvalidasi hasil kerja tim.*  
> 
> *Selain itu, saat Owner membuat tugas baru di proyek (`/projects/1/tasks/create`), sistem kami menerapkan **Form Adaptif**: ketika memilih Melda, form meminta topik dan tone of voice; ketika memilih Rasya, form berganti meminta dimensi dan brand guideline; dan ketika memilih Popita, form meminta platform serta jadwal posting.*  
> 
> *Sekarang, rekan-rekan saya akan mendemonstrasikan bagaimana setiap anggota tim mengerjakan tugas sesuai rolenya masing-masing. Dimulai dari **Melda Munisa** sebagai Content Creator."*

---

---

# ✍️ BAGIAN 2: MELDA MUNISA — FITUR CONTENT CREATOR
**Fokus:** Tampilan Khusus Member, Layout Dual-Panel (Brief vs Output), Slider Progres, Otomatisasi Status, dan Pengajuan Review.  
**Tampilan Layar:** Browser (Login Melda ➔ Detail Tugas Melda `/tasks/1`)  
**Durasi:** ± 2 Menit  

---

### [Aksi 2.1] Login Melda & Antarmuka Terfokus
**[Visual Layar]**  
*Gunakan dropdown 'Ganti Role Demo' di navbar kanan atas, klik **Melda Munisa**. Masuk ke dashboard Melda. Tunjukkan badge peran **Content Creator / Member** dan daftar tugas milik Melda.*

**[Narasi Melda]:**  
> *"Halo, saya **Melda Munisa** (NPM: 25781091) sebagai Content Creator.*  
> 
> *Ketika saya masuk menggunakan akun saya, antarmuka dashboard langsung menyesuaikan:*  
> *Menu dan widget administratif milik Owner disembunyikan. Dashboard saya terfokus menampilkan tugas-tugas yang memang ditugaskan kepada saya, diurutkan dari deadline terdekat.*  
> 
> *Di sini terlihat saya memiliki tugas berjudul **'Buat 10 ide konten & caption feed Instagram'** dengan status awal masih **To Do**."*

---

### [Aksi 2.2] Mengerjakan Tugas: Dual-Panel & Otomatisasi Status
**[Visual Layar]**  
*Klik tugas Melda (`/tasks/1`).*  
*- Tunjukkan panel kiri (Brief dari Owner Raffi).*  
*- Di panel kanan (Output), ketik teks caption contoh, masukkan link Google Docs.*  
*- Geser slider progres dari 0% ke **60%**, lalu klik **Simpan Hasil & Progres**.*  
*- Tunjukkan badge status di atas yang otomatis berubah menjadi **In Progress** (biru).*

**[Narasi Melda]:**  
> *"Saat membuka tugas, saya disajikan tata letak **Dual-Panel** yang sangat memudahkan pekerjaan kreatif:*  
> - *Di sebelah kiri, ada **Brief Lengkap dari Owner**, mulai dari topik kopi kemasan baru, gaya bahasa atau tone of voice santai anak muda, hingga link referensi.*  
> - *Di sebelah kanan, ada **Form Hasil Kerja** khusus Content Creator untuk mengisi draf caption dan link naskah.*  
> 
> *Sekarang saya masukkan draf caption-nya dan saya geser **Slider Progres** ini ke **60%**, lalu saya klik Simpan.*  
> 
> *Perhatikan: status tugas secara otomatis berubah dari **To Do menjadi In Progress** begitu ada progres kerja! Tidak perlu klik tombol ganti status manual yang membingungkan."*

---

### [Aksi 2.3] Mengajukan Tugas ke Review Owner
**[Visual Layar]**  
*Geser slider ke **100%**, klik tombol **'Ajukan Tugas ke Review Owner ↑'**. Klik OK pada konfirmasi dialog. Tunjukkan status berubah jadi **Review** (kuning).*

**[Narasi Melda]:**  
> *"Setelah seluruh naskah selesai, saya naikkan progres menjadi **100%**, lalu mengklik tombol **'Ajukan Tugas ke Review Owner'**.*  
> 
> *Status tugas sekarang berpindah ke fase **Review**, dan form pengerjaan dikunci sementara selagi menunggu evaluasi dari Project Manager.*  
> 
> *Selanjutnya, rekan saya **Popita Sari** akan mendemonstrasikan tugas di bidang Social Media Specialist."*

---

---

# 📊 BAGIAN 3: POPITA SARI — FITUR SOSMED & ALUR APPROVED (DONE)
**Fokus:** Keamanan Akses Antar-Anggota (Tugas Orang Lain Terkunci), Tugas Spesialisasi Sosmed, dan Simulasi Approval ke Status Selesai (Done).  
**Tampilan Layar:** Browser (Login Popita ➔ Tugas Popita `/tasks/3` ➔ Disetujui Owner)  
**Durasi:** ± 2 Menit  

---

### [Aksi 3.1] Keamanan Akses Antar-Anggota & Tugas Sosmed
**[Visual Layar]**  
*Beralih role ke **Popita Sari** via dropdown navbar.*  
*- Buka proyek `/projects/1`, coba klik tugas milik Rasya (`/tasks/2`). Tunjukkan form input tidak ada / read-only.*  
*- Buka tugas milik Popita sendiri: **'Susun jadwal posting 2 minggu'** (`/tasks/3`).*

**[Narasi Popita]:**  
> *"Halo semuanya! Saya **Popita Sari** (NPM: 25781096) sebagai Social Media Specialist.*  
> 
> *Pertama, saya ingin memperlihatkan fitur proteksi privasi tugas: ketika saya membuka tugas milik Rasya atau Melda, halaman bersifat **Read-Only**.*  
> *Sistem tidak merender form input maupun tombol pengajuan. Artinya, **setiap anggota tim hanya berhak mengerjakan tugas miliknya sendiri**.*  
> 
> *Sekarang kita buka tugas milik saya: **'Susun jadwal posting 2 minggu'**.*  
> *Sesuai profesi saya, form output yang disediakan adalah tautan spreadsheet jadwal posting dan catatan strategi tayang.*  
> *Tugas saya ini sudah selesai dikerjakan, berprogres 100%, dan posisinya sedang menunggu persetujuan di status **Review**."*

---

### [Aksi 3.2] Persetujuan Tugas (Approval ke Status Done)
**[Visual Layar]**  
*Ganti role kembali ke **Raffi (Owner)** via dropdown. Masuk ke `/tasks/3`. Klik tombol hijau **'Setujui Tugas (Approve & Done)'**. Klik OK. Tunjukkan status berubah menjadi **Done** (hijau) dan kartu Popita di `/projects/1` pindah ke kolom **Done**.*

**[Narasi Popita]:**  
> *"Di sisi Project Manager, Raffi memeriksa hasil jadwal posting yang saya lampirkan. Karena jadwal sudah rapi dan sesuai target kampanye klien, Raffi mengklik tombol hijau **'Setujui Tugas (Approve & Done)'**.*  
> 
> *Seketika status tugas berubah menjadi **Done**, dan di papan Kanban kartu tugas saya resmi masuk ke kolom hijau selesai. Progres keseluruhan proyek pun otomatis meningkat!*  
> 
> *Lalu, bagaimana jika hasil kerja belum sesuai dan butuh perbaikan? Rekan saya, **Rasya Chaniago**, akan memperlihatkan alur revisinya."*

---

---

# 🎨 BAGIAN 4: RASYA CHANIAGO — FITUR DESAIN & ALUR REVISI
**Fokus:** Tugas Graphic Designer (Brand Guideline & Dimensi), Menerima Catatan Revisi Transparan dari Owner, Perbaikan & Resubmit.  
**Tampilan Layar:** Browser (Login Rasya ➔ Tugas Rasya `/tasks/2` ➔ Menerima Revisi)  
**Durasi:** ± 2 Menit  

---

### [Aksi 4.1] Tugas Desain Visual & Pengajuan Awal
**[Visual Layar]**  
*Beralih role ke **Rasya Chaniago** via dropdown navbar. Buka tugas Rasya: **'Desain 10 visual feed Instagram'** (`/tasks/2`).*

**[Narasi Rasya]:**  
> *"Halo semuanya! Saya **Rasya Chaniago** (NPM: 25781093) selaku Graphic Designer di tim ini.*  
> 
> *Pada tugas saya, brief yang diberikan Project Manager berisi link Brand Guideline, palet warna kopi, dan dimensi feed Instagram 1080x1080.*  
> 
> *Saya memasukkan tautan file desain Figma hasil kerja saya, lalu menaikkan progres ke 100% dan mengajukan tugas ke status **Review**."*

---

### [Aksi 4.2] Menerima Catatan Revisi Transparan & Resubmit
**[Visual Layar]**  
*- Switch ke akun **Raffi (Owner)**, buka `/tasks/2`.*  
*- Klik tombol merah **'Minta Revisi...'**, ketik catatan: 'Warna feed ke-3 dan ke-7 terlalu gelap. Harap sesuaikan dengan palet krem hangat kopi kemasan terbaru.', klik **Kirim Instruksi Revisi**.*  
*- Switch kembali ke **Rasya Chaniago** (`/tasks/2`). Tunjukkan badge status menjadi merah **Revisi**, dan sorot panel **'Riwayat Catatan Revisi'** di bagian bawah.*

**[Narasi Rasya]:**  
> *"Nah, sekarang mari kita lihat alur ketika tugas memerlukan perbaikan.*  
> 
> *Ketika Raffi memeriksa desain saya dan mendapati warnanya kurang sesuai, Raffi mengklik tombol **'Minta Revisi'** dan menuliskan catatan perbaikan.*  
> 
> *Begitu saya membuka kembali halaman tugas saya sebagai Rasya, status tugas langsung ditandai dengan badge merah **Revisi**.*  
> 
> *Fitur unggulan di sini adalah transparansinya: di bagian bawah, muncul panel **Riwayat Catatan Revisi** lengkap dengan nama pengirim dan waktunya.*  
> *Catatan Raffi terbaca jelas: 'Warna feed ke-3 dan ke-7 terlalu gelap, sesuaikan dengan palet krem hangat'.*  
> 
> *Dengan catatan tertulis ini, desainer tidak akan salah arah. Tombol ajukan review otomatis terbuka kembali, sehingga setelah saya memperbarui desain di Figma, saya bisa mengajukan ulang hingga disetujui.*  
> 
> *Sekarang, Project Manager sekaligus pengembang backend kami, **Raffi Casidy**, akan membongkar seluruh source code dan logika kodingan di balik aplikasi ini!"*

---

---

# 💻 BAGIAN 5: RAFFI CASIDY — BEDAH CODING LENGKAP & TESTING (POIN PLUS!)
**Fokus:** Bedah Source Code Mendalam di VS Code (Database, Model, Dynamic Match Schema, Routing & Middleware 403, Controller Logic, dan Eksekusi Automated Test PHPUnit).  
**Tampilan Layar:** VS Code (Code Editor) & Terminal PowerShell  
**Durasi:** ± 3,5 Menit  

---

### [Koding 5.1] Bedah Skema Database & Relasi Model
**[Visual Layar]**  
*Buka VS Code. Buka file `database/migrations/2024_01_01_000004_create_tasks_table.php` dan `app/Models/Task.php`.*

**[Narasi Raffi]:**  
> *"Terima kasih rekan-rekan. Sekarang, kita masuk ke bagian terpenting: **Bedah Kodingan Sumber (Source Code Walkthrough)**.*  
> 
> *Pertama, mari kita lihat skema database di **`database/migrations/create_tasks_table.php`**.*  
> *Kunci dari fleksibilitas sistem kami ada di baris 26 dan 27:*  
> ```php
> $table->json('input_data')->nullable();
> $table->json('output_data')->nullable();
> ```  
> *Kami menggunakan kolom bertipe data **JSON**. Dengan tipe data JSON ini, kita tidak perlu membuat tabel terpisah untuk setiap profesi, melainkan parameter brief dan output anggota disimpan dinamis di database MySQL.*  
> 
> *Di model **`app/Models/Task.php`**, kami menambahkan property `$casts`:*  
> ```php
> protected $casts = [
>     'input_data' => 'array',
>     'output_data' => 'array',
>     'deadline' => 'date',
> ];
> ```  
> *Casting ini secara otomatis mengonversi data JSON menjadi array PHP saat dipanggil, dan meng-encode-nya kembali ke JSON saat disimpan ke database."*

---

### [Koding 5.2] Bedah Fitur Dynamic Schema via PHP 8 Match Expression
**[Visual Layar]**  
*Buka `app/Models/Task.php` baris 76 sampai 120. Sorot method `inputSchema()`.*

**[Narasi Raffi]:**  
> *"Bagaimana form brief bisa otomatis berubah sesuai profesi anggota? Kuncinya ada di method **`Task::inputSchema()`** baris 76:*  
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
>             'design_type' => ['label' => 'Jenis Desain', 'type' => 'select', 'options' => ['Feed 1:1', 'Story 9:16', 'Banner Ads', 'Packaging Mockup']],
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
> *Kami memanfaatkan fitur modern **PHP 8 `match` expression**. Saat dropdown anggota dipilih di tampilan Blade, JavaScript membaca atribut data role, dan sistem backend merender serta memvalidasi struktur field yang tepat untuk profesi tersebut."*

---

### [Koding 5.3] Bedah Keamanan: Nested Routing & Middleware Otorisasi (403)
**[Visual Layar]**  
*Buka `routes/web.php` baris 39–47, lalu buka `app/Http/Middleware/CheckWorkspaceMember.php`.*

**[Narasi Raffi]:**  
> *"Kedua, mari kita bedah sisi keamanan akses di **`routes/web.php`** dan Middleware.*  
> 
> *Di file rute, kami menerapkan **Nested Routes** yang diproteksi oleh middleware kustom `workspace.member`:*  
> ```php
> Route::middleware('workspace.member')->group(function () {
>     Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
>     Route::get('/workspaces/{workspace}/projects/create', [ProjectController::class, 'create'])->name('projects.create');
> });
> ```  
> 
> *Mari kita buka middleware-nya di **`app/Http/Middleware/CheckWorkspaceMember.php`**:*  
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
> *Middleware ini memanfaatkan **Route Model Binding** untuk mengambil instance workspace, lalu mengecek apakah user yang login terdaftar sebagai anggota. Jika user iseng mencoba mengubah ID di URL browser, server langsung mencegatnya dengan respons HTTP **403 Forbidden**!"*

---

### [Koding 5.4] Bedah Logika Controller: Validasi & Approval
**[Visual Layar]**  
*Buka `app/Http/Controllers/TaskController.php` method `updateWork()` (baris 64), lalu buka `app/Http/Controllers/TaskValidationController.php` method `approve()` dan `requestRevision()`.*

**[Narasi Raffi]:**  
> *"Ketiga, kita buka **`TaskController.php`** pada method **`updateWork()`**:*  
> ```php
> abort_unless($task->assigned_to === auth()->id(), 403, 'Bukan tugas Anda.');
> 
> if ($task->status === 'todo' && $progress > 0) {
>     $update['status'] = 'in_progress';
> }
> ```  
> *Di sini ada dua logika emas:*  
> 1. *Proteksi server: hanya penanggung jawab (`assigned_to`) yang boleh mengedit.*  
> 2. *Otomatisasi status: begitu slider progres digeser > 0%, status otomatis naik dari `todo` menjadi `in_progress`.*  
> 
> *Lalu di **`TaskValidationController.php`**, Owner memvalidasi pekerjaan:*  
> - *Method **`approve()`** mengupdate status menjadi `done` dan progress 100.*  
> - *Method **`requestRevision()`** mengubah status menjadi `revisi` dan mengeksekusi:*  
>   ```php
>   $task->revisions()->create([
>       'created_by' => auth()->id(),
>       'note' => $data['note'],
>   ]);
>   ```  
>   *Ini otomatis menyimpan instruksi perbaikan ke tabel `task_revisions` yang tadi dibaca oleh Rasya."*

---

### [Koding 5.5] Pembuktian Mutlak: Menjalankan Automated Test (29 Tests PASS!)
**[Visual Layar]**  
*Buka file `tests/Feature/ProjectManagementWorkflowTest.php`. Tunjukkan skenario test end-to-end. Kemudian buka terminal terintegrasi VS Code dan ketik `php artisan test`.*

**[Narasi Raffi]:**  
> *"Terakhir, sebagai bukti bahwa seluruh kodingan ini teruji dan bebas bug, kami menyusun file **`tests/Feature/ProjectManagementWorkflowTest.php`** yang menguji seluruh alur kerja dari autentikasi, isolasi hak akses 403, hingga alur validasi tugas.*  
> 
> *Mari kita jalankan pengujian otomatis di terminal:*  
> *(Ketik di terminal dan tekan Enter)*  
> ```bash
> php artisan test
> ```  
> *(Tunjukkan hasil terminal)*  
> *Bisa kita lihat bersama di layar terminal: **seluruh 29 unit & feature tests dengan 76 assertions berjalan 100% SUKSES tanpa ada satu pun error atau failure!**"*

---

### [Penutup 5.6] Kesimpulan
**[Visual Layar]**  
*Kembali ke tampilan browser dashboard atau slide nama kelompok.*

**[Narasi Raffi]:**  
> *"Demikian presentasi lengkap dari kelompok kami: mulai dari demonstrasi fitur tiap role oleh Melda, Popita, dan Rasya, hingga bedah kodingan dan pengujian otomatis backend yang saya paparkan.*  
> 
> *Aplikasi ini membuktikan bagaimana arsitektur MVC Laravel yang terstruktur mampu menghasilkan platform SaaS manajemen proyek yang aman, responsif, dan siap pakai.*  
> 
> *Terima kasih banyak atas perhatian Bapak/Ibu dosen pengampu. Wassalamualaikum warahmatullahi wabarakatuh."*

---

## 🎯 KEUNGGULAN SCRIPT INI UNTUK PRESENTASI ANDA:
1. **Raffi Dapat Poin Plus Maksimal:** Membedah tuntas 5 file kodingan utama + menjalankan unit test secara live.
2. **Anggota Lain Santai & Natural:** Rasya, Melda, dan Popita tidak pusing menghafal baris kodingan, mereka hanya mendemokan fitur di browser sesuai jobdesc-nya.
3. **Alur Mengalir:** Saling oper peran dari Raffi ➔ Melda ➔ Popita ➔ Rasya ➔ kembali ke Raffi untuk kodingan & penutup.
