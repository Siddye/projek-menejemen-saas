# 🏆 SCRIPT VIDEO FINALIS — PROJECT MANAGEMENT SAAS PLATFORM
**Mata Kuliah:** Pemrograman Web III  
**Nama Tim / Brand:** Digital Agency Studio  
**Studi Kasus:** Kampanye Media Sosial Klien Kopi Nusantara  
**Format:** Video Presentasi & Live Demo Sistem (4 Orang / 4 Role)  
**Total Durasi:** ± 10 – 12 Menit  

---

## 👥 IDENTITAS KELOMPOK & ROLE

| No | Nama Mahasiswa | NPM | Role Sistem | Job Title | Tugas dalam Video Final |
|---|---|---|---|---|---|
| **1** | **Raffi Casidy** | **25781097** | **Owner** | Project Manager & Tech Lead | Pembuka, Pengenalan Konsep, Demo Owner, Bedah Coding Arsitektur, Testing Otomatis & Penutup |
| **2** | **Melda Munisa** | **25781091** | **Member** | Content Creator | Demo Alur Pembuatan Konten, Dual-Panel Brief/Output, Slider Progres, Otomatisasi Status & Submit Review |
| **3** | **Popita Sari** | **25781096** | **Member** | Social Media Specialist | Demo Keamanan Antar-Anggota (Read-Only), Tugas Jadwal & Metrik, Alur Approval Selesai (Done) |
| **4** | **Rasya Chaniago** | **25781093** | **Member** | Graphic Designer | Demo Brief Desain Visual, Alur Menerima Revisi Catatan Evaluasi Owner, Perbaikan & Resubmit |

---

## ⏱️ RUNDOWN ALUR VIDEO FINAL

```text
[00:00 - 02:00] RAFFI CASIDY       : Pembukaan, Latar Belakang Masalah, UI Login & Dashboard Owner
[02:00 - 04:00] MELDA MUNISA       : Demo Role Content Creator (Brief, Output, Slider Progres, Auto Status)
[04:00 - 06:00] POPITA SARI        : Demo Role Sosmed Specialist (Proteksi Tugas, Jadwal Tayang, Approval Done)
[06:00 - 08:00] RASYA CHANIAGO     : Demo Role Graphic Designer (Brief Desain, Panel Riwayat Revisi, Resubmit)
[08:00 - 11:30] RAFFI CASIDY       : BEDAH CODING SUMBER DI VS CODE + LIVE RUNNING TEST TERMINAL (POIN PLUS)
[11:30 - 12:00] RAFFI CASIDY       : Kesimpulan Proyek & Penutup
```

---

---

# 👔 BAGIAN 1: RAFFI CASIDY (OWNER & PROJECT MANAGER)
**Fokus:** Salam Pembuka, Pengenalan Anggota & Masalah Agensi, Demo Login Glassmorphism, Dashboard Owner & Review Queue.  
**Tampilan Layar:** Browser (`http://127.0.0.1:8000/login`) ➔ Dashboard Owner (`/dashboard`)  
**Durasi:** ± 2 Menit  

---

### [Langkah 1.1] Pembukaan & Latar Belakang Masalah
**[Visual di Layar]**  
*Buka browser di halaman login `http://127.0.0.1:8000/login`. Tunjukkan antarmuka glassmorphism modern, panel kiri hero dark teal, form login, dan 4 tombol Quick Login di bawah.*

**[Narasi yang Diucapkan Raffi]:**  
> *"Assalamu’alaikum warahmatullahi wabarakatuh. Selamat pagi/siang kepada Bapak/Ibu dosen pengampu dan rekan-rekan sekalian.*  
> 
> *Kami dari kelompok Pemrograman Web III akan mempresentasikan hasil proyek final kami yang berjudul **Project Management SaaS Platform** dengan studi kasus agensi kreatif **Digital Agency Studio**.*  
> 
> *Kelompok kami beranggotakan empat orang:*  
> 1. *Saya sendiri, **Raffi Casidy** (25781097), sebagai Project Manager sekaligus Owner workspace,*  
> 2. *Rekan saya **Melda Munisa** (25781091), sebagai Content Creator,*  
> 3. *Rekan saya **Popita Sari** (25781096), sebagai Social Media Specialist, dan*  
> 4. *Rekan saya **Rasya Chaniago** (25781093), sebagai Graphic Designer.*  
> 
> *Masalah yang melatarbelakangi proyek ini adalah: pada agensi skala kecil, koordinasi tugas kampanye klien sering kali tercecer di grup chat informal. Akibatnya, brief instruksi hilang, progres pengerjaan sulit dipantau, dan tidak ada standar alur verifikasi resmi sebelum materi dipublikasikan ke klien.*  
> 
> *Melalui platform ini, kami membangun ekosistem berbasis peran: setiap agensi memiliki ruang kerja *(multi-tenancy)*, form tugas adaptif sesuai profesi, papan visual Kanban 5 kolom, dan alur validasi mutu resmi.*  
> 
> *Dari sisi UI, aplikasi mengusung tema **Modern Glassmorphism** dengan palet warna dark teal `#0e3746` dan background ambient gradient.*  
> 
> *Untuk mempermudah demo, di bagian bawah form login telah kami sediakan fitur **Quick Login Demo** yang langsung terhubung ke empat akun studi kasus kami. Mari kita masuk terlebih dahulu sebagai **Raffi**, sang Project Manager."*

---

### [Langkah 1.2] Dashboard Owner & Fitur Eksklusif Review Queue
**[Visual di Layar]**  
*Klik tombol quick-login **Raffi**. Browser masuk ke `/dashboard`. Arahkan mouse ke kartu kampanye Kopi Nusantara, kartu antrean validasi (Review Queue), dan navigasi sidebar.*

**[Narasi yang Diucapkan Raffi]:**  
> *"Saat ini kita telah berada di Dashboard Utama.*  
> 
> *Sebagai Owner, dashboard menyajikan ringkasan strategis kampanye yang sedang berjalan, yaitu **'Campaign Media Sosial Kopi Nusantara'**, lengkap dengan persentase progres kumulatif dan deretan avatar tim yang bertugas.*  
> 
> *Keunggulan utama pada akun Owner adalah panel **'Validasi Tugas Anggota / Review Queue'**. Panel ini **hanya akan muncul pada akun Owner** ketika ada anggota tim yang telah menyelesaikan tugas dan mengajukannya untuk direview. Dari sini, Project Manager bisa langsung mengetahui tugas mana saja yang membutuhkan persetujuan tanpa harus membuka proyek satu per satu.*  
> 
> *Selain itu, saat Owner membuat tugas baru di proyek (`/projects/1/tasks/create`), sistem kami menerapkan **Form Adaptif Dinamis**: isian brief otomatis berganti mengikuti spesialisasi anggota yang dipilih.*  
> 
> *Sekarang, rekan-rekan saya akan mendemonstrasikan secara langsung bagaimana setiap anggota mengerjakan tugas di rolenya masing-masing. Kita mulai dari rekan saya, **Melda Munisa**, sebagai Content Creator."*

---

---

# ✍️ BAGIAN 2: MELDA MUNISA (CONTENT CREATOR)
**Fokus:** Tampilan Dashboard Member yang Bersih, Layout Dual-Panel (Brief vs Output), Slider Progres Interaktif, Otomatisasi Status, dan Pengajuan Review.  
**Tampilan Layar:** Browser (Quick Login Melda ➔ Detail Tugas `/tasks/1`)  
**Durasi:** ± 2 Menit  

---

### [Langkah 2.1] Dashboard Khusus Member
**[Visual di Layar]**  
*Gunakan dropdown 'Ganti Role Demo' di pojok kanan atas navbar, klik **Melda Munisa**. Layar beralih ke dashboard Melda. Tunjukkan badge peran hijau **Content Creator / Member**.*

**[Narasi yang Diucapkan Melda]:**  
> *"Halo semuanya! Saya **Melda Munisa** (25781091), bertindak sebagai Content Creator di Digital Agency Studio.*  
> 
> *Ketika saya masuk menggunakan akun saya, antarmuka dashboard langsung menyesuaikan:*  
> *Menu dan panel kontrol administratif milik Owner disembunyikan. Dashboard saya terfokus menampilkan tugas-tugas yang didelegasikan kepada saya, diurutkan berdasarkan tenggat waktu terdekat.*  
> 
> *Di sini terlihat saya memiliki tugas berjudul **'Buat 10 ide konten & caption feed Instagram'** dengan status awal masih **To Do**."*

---

### [Langkah 2.2] Mengerjakan Tugas: Layout Dual-Panel & Auto-Status Update
**[Visual di Layar]**  
*Klik tugas Melda (`/tasks/1`).*  
*- Sorot panel kiri (Brief dari Owner).*  
*- Di panel kanan (Output), ketikkan draf caption (misal: 'Draf 10 Caption Peluncuran Kopi Kemasan Nusantara: Slide 1 - Rasakan sensasi kopi asli Indonesia...').*  
*- Masukkan link naskah Google Docs.*  
*- Geser slider progres dari 0% ke **60%**, lalu klik **'Simpan Hasil & Progres'**.*  
*- Arahkan kursor ke badge status di atas yang otomatis berubah menjadi **In Progress** (biru).*

**[Narasi yang Diucapkan Melda]:**  
> *"Saat membuka detail tugas, kami disajikan tata letak **Dual-Panel** yang sangat intuitif bagi tim kreatif:*  
> - *Di sisi kiri, terdapat **Brief Lengkap dari Owner**, berisi topik peluncuran produk kopi, tone of voice santai anak muda, dan tautan referensi visual.*  
> - *Di sisi kanan, terdapat **Form Hasil Kerja** spesifik profesi Content Creator untuk mengisi naskah caption dan tautan dokumen Google Docs.*  
> 
> *Sekarang saya masukkan draf caption-nya dan saya geser **Slider Progres** ini ke **60%**, lalu saya klik Simpan.*  
> 
> *Perhatikan: status tugas secara otomatis berpindah dari **To Do menjadi In Progress** begitu ada progres kerja! Tidak ada tombol ubah status manual yang merepotkan."*

---

### [Langkah 2.3] Mengajukan Tugas ke Review Owner
**[Visual di Layar]**  
*Geser kembali slider progres ke **100%**. Klik tombol **'Ajukan Tugas ke Review Owner ↑'**. Pada dialog konfirmasi browser, klik OK. Tunjukkan status berubah menjadi **Review** (kuning) dan form input dikunci.*

**[Narasi yang Diucapkan Melda]:**  
> *"Setelah seluruh naskah selesai, saya naikkan slider progres menjadi **100%**, lalu saya menekan tombol **'Ajukan Tugas ke Review Owner'**.*  
> 
> *Status tugas sekarang resmi berpindah ke fase **Review**, dan form input saya dikunci sementara untuk mencegah perubahan data selagi ditinjau oleh Project Manager.*  
> 
> *Selanjutnya, rekan saya **Popita Sari** akan mendemonstrasikan tugas di bidang Social Media Specialist."*

---

---

# 📊 BAGIAN 3: POPITA SARI (SOCIAL MEDIA SPECIALIST)
**Fokus:** Keamanan Akses Antar-Anggota (Tugas Anggota Lain Read-Only), Tugas Jadwal & Strategi Sosmed, dan Simulasi Persetujuan (Approval ke Status Done).  
**Tampilan Layar:** Browser (Quick Login Popita ➔ Tugas `/tasks/3` ➔ Disetujui Raffi di `/dashboard`)  
**Durasi:** ± 2 Menit  

---

### [Langkah 3.1] Keamanan Akses Antar-Anggota & Tugas Sosmed
**[Visual di Layar]**  
*Ganti role ke **Popita Sari** via dropdown navbar.*  
*- Buka proyek `/projects/1`, klik tugas milik Rasya (`/tasks/2`). Tunjukkan bahwa halaman bersifat **Read-Only** (tidak ada form edit maupun tombol ajukan review).*  
*- Kembali ke `/projects/1`, buka tugas Popita sendiri: **'Susun jadwal posting 2 minggu'** (`/tasks/3`).*

**[Narasi yang Diucapkan Popita]:**  
> *"Halo semuanya! Saya **Popita Sari** (25781096), bertindak sebagai Social Media Specialist.*  
> 
> *Pertama, saya ingin memperlihatkan proteksi privasi pada sistem kami: ketika saya mencoba membuka tugas milik anggota lain — seperti tugas Rasya atau Melda — sistem mengunci halaman tersebut.*  
> *Form pengeditan dan tombol ajukan review tidak dirender sama sekali. Artinya, **setiap anggota hanya berhak mengerjakan tugas miliknya sendiri**.*  
> 
> *Sekarang kita buka tugas milik saya: **'Susun jadwal posting 2 minggu'**.*  
> *Sesuai profesi saya, field output yang disediakan adalah tautan spreadsheet kalender posting dan catatan analisis strategi tayang.*  
> *Tugas saya ini sudah berprogres 100% dan posisinya saat ini berada pada status **Review**."*

---

### [Langkah 3.2] Alur Persetujuan (Approve ke Status Done)
**[Visual di Layar]**  
*- Beralih role ke **Raffi (Owner)** via dropdown navbar.*  
*- Masuk ke `/tasks/3` (tugas Popita).*  
*- Di panel validasi Owner, klik tombol hijau **'Setujui Tugas (Approve & Done)'**. Klik OK.*  
*- Tunjukkan badge status berubah menjadi **Done** (hijau emerald). Buka `/projects/1` dan perlihatkan kartu Popita sudah masuk ke kolom **Done**.*

**[Narasi yang Diucapkan Popita]:**  
> *"Di sisi Project Manager, Raffi memeriksa tautan kalender posting yang saya lampirkan. Karena jadwal posting sudah selaras dengan tanggal peluncuran produk kopi klien, Raffi cukup mengklik tombol hijau **'Setujui Tugas (Approve & Done)'**.*  
> 
> *Seketika status tugas berubah menjadi **Done**, dan di papan Kanban kartu tugas saya resmi masuk ke kolom hijau selesai. Progres keseluruhan kampanye pun ikut meningkat secara otomatis.*  
> 
> *Lalu, bagaimana jika hasil kerja anggota belum sesuai standar agensi dan memerlukan perbaikan? Rekan saya, **Rasya Chaniago**, akan memperlihatkan alur revisinya."*

---

---

# 🎨 BAGIAN 4: RASYA CHANIAGO (GRAPHIC DESIGNER)
**Fokus:** Brief Desain Visual, Alur Menerima Revisi Catatan Evaluasi dari Owner, Panel Transparansi Revisi, dan Pengajuan Ulang (Resubmit).  
**Tampilan Layar:** Browser (Quick Login Rasya ➔ Tugas `/tasks/2` ➔ Menerima Catatan Revisi)  
**Durasi:** ± 2 Menit  

---

### [Langkah 4.1] Tugas Desain Visual & Pengajuan Awal
**[Visual di Layar]**  
*Ganti role ke **Rasya Chaniago** via dropdown navbar. Buka tugas Rasya: **'Desain 10 visual feed Instagram'** (`/tasks/2`).*

**[Narasi yang Diucapkan Rasya]:**  
> *"Halo semuanya! Saya **Rasya Chaniago** (25781093), berperan sebagai Graphic Designer di tim ini.*  
> 
> *Pada tugas saya, brief yang diberikan Project Manager mencakup tautan Brand Guideline, palet warna kopi, dan dimensi feed Instagram 1080x1080.*  
> 
> *Setelah aset visual selesai dirancang di Figma, saya memasukkan link desainnya dan mengajukan tugas ke status **Review** agar diperiksa oleh Raffi."*

---

### [Langkah 4.2] Menerima Catatan Revisi Transparan & Resubmit
**[Visual di Layar]**  
*- Switch ke akun **Raffi (Owner)**, buka `/tasks/2`.*  
*- Klik tombol merah **'Minta Revisi...'**, ketik catatan: 'Warna feed ke-3 dan ke-7 terlalu gelap. Harap sesuaikan dengan palet krem hangat kopi kemasan terbaru.', klik **Kirim Instruksi Revisi**.*  
*- Switch kembali ke **Rasya Chaniago** (`/tasks/2`).*  
*- Tunjukkan badge status menjadi merah **Revisi**, lalu scroll ke bawah dan sorot panel **'Riwayat Catatan Revisi'**.*

**[Narasi yang Diucapkan Rasya]:**  
> *"Nah, sekarang mari kita lihat alur ketika hasil kerja memerlukan perbaikan.*  
> 
> *Saat Raffi memeriksa desain saya dan mendapati warnanya belum sesuai guideline klien, Raffi mengklik tombol **'Minta Revisi'** dan menyertakan catatan evaluasi.*  
> 
> *Begitu saya membuka kembali halaman tugas saya sebagai Rasya, status tugas langsung ditandai dengan badge merah **Revisi**.*  
> 
> *Fitur unggulan di sini adalah transparansinya: di bagian bawah halaman tugas, terdapat panel **Riwayat Catatan Revisi** lengkap dengan nama pengirim dan waktu pengirimannya.*  
> *Instruksi Raffi tertulis jelas: 'Warna feed ke-3 dan ke-7 terlalu gelap, sesuaikan dengan palet krem hangat'.*  
> 
> *Dengan catatan tertulis ini, desainer tidak akan salah arah dalam merevisi. Tombol pengajuan review otomatis aktif kembali, sehingga setelah file di Figma diperbarui, saya bisa langsung mengajukannya ulang hingga disetujui.*  
> 
> *Sekarang, Project Manager sekaligus developer backend kami, **Raffi Casidy**, akan membongkar seluruh source code dan logika kodingan di balik sistem ini!"*

---

---

# 💻 BAGIAN 5: RAFFI CASIDY (BEDAH CODING & TESTING OTOMATIS)
**Fokus:** Bedah Source Code Mendalam di VS Code (Database, Model, Dynamic Schema Match, Routing & Middleware 403, Controller Logic, dan Eksekusi Automated Testing PHPUnit).  
**Tampilan Layar:** Visual Studio Code & Terminal PowerShell  
**Durasi:** ± 3,5 Menit  

---

### [Koding 5.1] Bedah Skema Database & Relasi Model
**[Visual di Layar]**  
*Pindah dari browser ke VS Code. Buka file `database/migrations/2024_01_01_000004_create_tasks_table.php` dan `app/Models/Task.php`.*

**[Narasi Raffi]:**  
> *"Terima kasih rekan-rekan. Sekarang kita masuk ke sesi teknis: **Bedah Kodingan Sumber (Source Code Walkthrough)**.*  
> 
> *Pertama, mari kita lihat skema database di **`database/migrations/create_tasks_table.php`**.*  
> *Kunci dari fleksibilitas sistem kami ada di baris 26 dan 27:*  
> ```php
> $table->json('input_data')->nullable();
> $table->json('output_data')->nullable();
> ```  
> *Kami menggunakan kolom bertipe data **JSON**. Dengan tipe data JSON ini, kita tidak perlu membuat tabel terpisah untuk setiap profesi, melainkan parameter brief dan output anggota disimpan secara dinamis di MySQL.*  
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
**[Visual di Layar]**  
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
> *Kami memanfaatkan sintaks modern **PHP 8 `match` expression**. Saat dropdown anggota dipilih di tampilan Blade, JavaScript membaca atribut data role, dan sistem backend merender serta memvalidasi struktur field yang tepat untuk profesi tersebut."*

---

### [Koding 5.3] Bedah Keamanan: Nested Routing & Middleware Otorisasi (403)
**[Visual di Layar]**  
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
> *Middleware ini memanfaatkan **Route Model Binding** untuk mengambil instance workspace, lalu mengecek apakah user yang login terdaftar sebagai anggota. Jika user mencoba memanipulasi ID di URL browser, server langsung mencegatnya dengan respons HTTP **403 Forbidden**!"*

---

### [Koding 5.4] Bedah Logika Controller: Validasi & Approval
**[Visual di Layar]**  
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
> *Di sini ada dua logika penting:*  
> 1. *Proteksi server: hanya penanggung jawab (`assigned_to`) yang boleh mengedit tugas.*  
> 2. *Otomatisasi status: begitu slider progres digeser lebih dari 0%, status otomatis naik dari `todo` menjadi `in_progress`.*  
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
>   *Ini otomatis menyimpan instruksi perbaikan ke tabel `task_revisions` yang tadi diterima oleh Rasya."*

---

### [Koding 5.5] Pembuktian Pengujian Otomatis (29 Tests PASS!)
**[Visual di Layar]**  
*Buka file `tests/Feature/ProjectManagementWorkflowTest.php`. Tunjukkan skenario test end-to-end. Kemudian buka terminal terintegrasi VS Code dan jalankan perintah `php artisan test`.*

**[Narasi Raffi]:**  
> *"Terakhir, sebagai bukti bahwa seluruh kodingan ini teruji dan bebas bug, kami menyusun file **`tests/Feature/ProjectManagementWorkflowTest.php`** yang menguji seluruh alur kerja dari autentikasi, isolasi hak akses 403, hingga siklus validasi tugas.*  
> 
> *Mari kita jalankan pengujian otomatis di terminal:*  
> *(Ketik di terminal dan tekan Enter)*  
> ```bash
> php artisan test
> ```  
> *(Tunjukkan hasil terminal yang hijau)*  
> *Bisa kita lihat bersama di layar terminal: **seluruh 29 unit & feature tests dengan 76 assertions berjalan 100% SUKSES tanpa ada satu pun error atau failure!**"*

---

### [Penutup 5.6] Kesimpulan & Salam Penutup
**[Visual di Layar]**  
*Kembali ke tampilan browser dashboard atau slide profil kelompok.*

**[Narasi Raffi]:**  
> *"Demikian presentasi final dari kelompok kami: mulai dari demonstrasi fitur tiap role oleh Melda, Popita, dan Rasya, hingga bedah kodingan dan pengujian otomatis backend yang saya paparkan.*  
> 
> *Aplikasi ini membuktikan bagaimana arsitektur MVC Laravel yang terstruktur mampu menghasilkan platform SaaS manajemen proyek yang aman, responsif, dan siap pakai bagi agensi digital.*  
> 
> *Terima kasih banyak atas perhatian Bapak/Ibu dosen pengampu mata kuliah Pemrograman Web III. Wassalamu’alaikum warahmatullahi wabarakatuh."*
