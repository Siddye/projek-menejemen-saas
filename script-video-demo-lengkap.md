# Script Video Demo Fitur Aplikasi — Project Management SaaS Platform
**Durasi Target:** 6 – 10 Menit  
**Model Presentasi:** Bisa dibawakan oleh 1 orang (Presenter Utama) atau bergantian 4 orang (Raffi, Rasya, Melda, Popita).  
**Studi Kasus:** Digital Agency Studio — Kampanye Media Sosial Klien Kopi Nusantara.  

---

## 🎬 Panduan Teknis & Checklist Sebelum Rekam

1. **Jalankan Aplikasi:**
   ```bash
   cd "C:/xampp/htdocs/Project Management SaaS Platform"
   php artisan migrate:fresh --seed
   php artisan serve --port=8000
   ```
2. **Siapkan Browser:**
   - Buka `http://127.0.0.1:8000` (posisi awal di halaman `/login`).
   - Browser full-screen, zoom 90% atau 100% agar frame glassmorphism terlihat proporsional dan elegan.
   - Sembunyikan bookmark bar dan matikan notifikasi desktop.
3. **Format Script:**
   - **[Visual]** = Aksi kursor, klik, scroll, dan perpindahan halaman yang direkam.
   - **[Narasi]** = Kata-kata persis yang diucapkan oleh presenter/voiceover.

---

## ⏱️ TIMELINE & RANGKUMAN SEGMEN

| No | Segmen | Durasi | Fokus Fitur |
|---|---|---|---|
| 1 | **Pembukaan & Desain Login Modern** | 00:00 - 01:15 | Glassmorphism UI, Pengenalan Kasus, Quick Login Demo |
| 2 | **Dashboard Owner & Multi-Tenancy** | 01:15 - 02:45 | Dark Sidebar, Card Metric, Review Queue, Multi-Workspace |
| 3 | **Workspace & Manajemen Tim** | 02:45 - 04:00 | Detail Workspace, RBAC Tim, Guard Anti-Duplikasi Anggota |
| 4 | **Proyek & 5-Column Kanban Board** | 04:00 - 05:15 | Deadline Alert, Visual Kanban Board, Card Badges |
| 5 | **Form Tugas Dinamis Sesuai Profesi** | 05:15 - 06:30 | Skema Input JSON Adaptif (Desainer, Penulis, Sosmed) |
| 6 | **Workflow Pengerjaan Anggota (Member)** | 06:30 - 07:45 | Dual-Panel Brief/Output, Slider Progres, Auto Status |
| 7 | **Alur Validasi & Revisi Owner** | 07:45 - 09:15 | Request Revision, History Catatan, Approval ke Done |
| 8 | **Uji Keamanan (403) & Test Otomatis** | 09:15 - 10:00 | Proteksi Server-Side, Bukti 29/29 Test Passing, Penutup |

---

## 📜 SCRIPT LENGKAP DEMO APLIKASI

---

### SEGMEN 1: Pembukaan & Tampilan Login Modern (00:00 - 01:15)

**[Visual]**  
*Layar menampilkan halaman login (`http://127.0.0.1:8000/login`). Kursor mengarah ke logo brand dan kartu login bernuansa glassmorphism dengan background gradient ambient.*

**[Narasi - Raffi / Presenter]:**  
> *"Halo semuanya! Selamat datang di video demonstrasi **Project Management SaaS Platform**, aplikasi berbasis web yang kami bangun menggunakan framework **Laravel 12**, arsitektur multi-tenancy, dan antarmuka modern bertema **Glassmorphism** dengan palet warna dark teal.*  
> 
> *Aplikasi ini dirancang khusus untuk memecahkan kendala klasik tim agensi digital: yaitu koordinasi tugas klien yang berantakan di grup chat, sulitnya memantau progres riil, serta ketiadaan standarisasi alur verifikasi pekerjaan.*  
> 
> *Pada halaman awal ini, Anda dapat melihat halaman autentikasi elegan dengan panel hero di sebelah kiri dan form login di sebelah kanan. Untuk mempermudah proses presentasi dan pengujian, kami menyediakan fitur **Quick Login Demo** di bagian bawah, yang langsung memuat 4 profil tim studi kasus kami:*  
> 1. *Raffi sebagai **Owner & Project Manager**,*  
> 2. *Rasya Chaniago sebagai **Graphic Designer**,*  
> 3. *Melda Munisa sebagai **Content Creator**, dan*  
> 4. *Popita Sari sebagai **Social Media Specialist**.*  
> 
> *Mari kita mulai dengan masuk sebagai **Raffi**, sang Project Manager."*

---

### SEGMEN 2: Dashboard Owner & Manajemen Workspace (01:15 - 02:45)

**[Visual]**  
*Klik tombol quick-login **Raffi**. Layar bertransisi mulus ke `/dashboard`. Tunjukkan sidebar dark teal di sebelah kiri, top navigation bar dengan badge peran, card proyek aktif ber-progress bar, card antrean validasi, grid tugas, dan daftar workspace.*

**[Narasi - Raffi / Presenter]:**  
> *"Sekarang kita sudah berada di Dashboard Utama. Perhatikan di sudut kiri, kami memiliki sidebar melayang dengan warna deep teal `#0e3746` yang clean dan minimalis, serta navigasi ikonik putih aktif.*  
> 
> *Di bagian atas, terdapat top-bar yang menampilkan identitas studio, tombol pencarian, notifikasi, profil, serta dropdown cepat **'Ganti Role Demo'** untuk beralih akun kapan saja.*  
> 
> *Pada dashboard Raffi sebagai Owner, sistem langsung menampilkan:*  
> 1. *Pertama, **Featured Active Campaign**: Proyek 'Campaign Media Sosial Kopi Nusantara' lengkap dengan persentase progres, avatar anggota tim yang terlibat, dan info deadline.*  
> 2. *Kedua, widget eksklusif **'Validasi Tugas Anggota / Review Queue'**. Panel ini **hanya muncul pada akun Owner** ketika ada anggota tim yang mengajukan tugas selesai. Dari sini Owner bisa langsung tahu tugas mana yang butuh persetujuan tanpa harus mencarinya manual.*  
> 3. *Di bawahnya ada **Grid Tugas Saya** dengan thumbnail gradien warna-warni dan indikator status dot, serta daftar seluruh **Workspace Tim** yang dimiliki.*  
> 
> *Sekarang mari kita klik menu **Workspace** di sidebar."*

---

### SEGMEN 3: Detail Workspace & Kontrol Hak Akses Tim (02:45 - 04:00)

**[Visual]**  
*Buka `/workspaces` lalu klik **Digital Agency Studio** (`/workspaces/1`). Perlihatkan kolom kiri (daftar campaign klien) dan kolom kanan (daftar anggota tim + form tambah anggota).*

**[Narasi - Melda / Presenter]:**  
> *"Di halaman detail workspace ini, kita melihat penerapan konsep **Multi-Tenancy** dan **Role-Based Access Control (RBAC)**.*  
> 
> *Pada kolom kanan, tercantum seluruh anggota studio lengkap dengan badge spesialisasinya: Raffi sebagai Owner, Rasya sebagai Graphic Designer, Melda sebagai Content Creator, dan Popita sebagai Sosmed Specialist.*  
> 
> *Owner memiliki otoritas penuh untuk mengundang anggota baru melalui form **'+ Tambah Anggota ke Tim'** cukup dengan memasukkan email dan memilih role profesinya.*  
> 
> *Sistem kami dilengkapi guard validasi di backend: jika Owner mencoba memasukkan user yang sudah terdaftar — misalnya email Raffi sendiri — sistem otomatis menolak dengan notifikasi kesalahan: **'User sudah jadi anggota workspace ini'**. Selain itu, tombol hapus anggota hanya aktif untuk member biasa dan dilarang menghapus akun Owner workspace demi menjaga integritas data."*

---

### SEGMEN 4: Detail Proyek & 5-Column Kanban Board (04:00 - 05:15)

**[Visual]**  
*Klik proyek **Campaign Media Sosial - Peluncuran Produk** (`/projects/1`). Arahkan kursor ke card ringkasan proyek (nama klien Kopi Nusantara, brief klien, progres bar) lalu scroll ke **Kanban Board** 5 kolom: To Do, In Progress, Review, Revisi, Done.*

**[Narasi - Rasya / Presenter]:**  
> *"Sekarang kita masuk ke ruang kerja proyek klien Kopi Nusantara. Di bagian atas terdapat ringkasan brief klien, tenggat waktu dengan deteksi otomatis status terlambat jika melewati deadline, serta progres bar kumulatif.*  
> 
> *Fitur visual utama kami adalah **Interactive Kanban Board 5 Kolom**:*  
> - *Kolom abu-abu untuk **To Do**,*  
> - *Biru untuk **In Progress**,*  
> - *Kuning amber untuk **Review**,*  
> - *Merah untuk **Revisi**, dan*  
> - *Hijau emerald untuk **Done**.*  
> 
> *Setiap kartu tugas di dalam lane memiliki identitas yang sangat kaya: role pill berwarna, badge prioritas (High, Medium, Low), inisial penanggung jawab, tanggal tenggat, mini progress-bar, dan penanda revisi jika tugas tersebut dikembalikan oleh Owner.*  
> 
> *Sebagai contoh, tugas Popita saat ini berada di kolom Review, tugas Rasya berada di kolom In Progress dengan progres 40%, dan tugas Melda berada di To Do."*

---

### SEGMEN 5: Pembuatan Tugas dengan Form Adaptif Per Profesi (05:15 - 06:30)

**[Visual]**  
*Klik tombol **'+ Buat Tugas Baru'** (`/projects/1/tasks/create`). Tunjukkan dropdown 'Pilih Anggota Tim (Assignee)'. Ganti pilihan anggota dari Melda -> Rasya -> Popita. Tunjukkan bagaimana card 'Brief Kerja Khusus' di bawahnya berganti input-field secara otomatis via JavaScript & model schema.*

**[Narasi - Raffi / Presenter]:**  
> *"Ini adalah salah satu inovasi terkuat di sistem kami: **Dynamic Role-Based Task Form**.*  
> 
> *Biasanya aplikasi to-do list hanya memberi satu kolom deskripsi umum. Di sistem kami, field brief kerja otomatis menyesuaikan bidang keahlian anggota yang dipilih:*  
> - *Ketika memilih **Melda (Content Creator)**: Form otomatis memunculkan field khusus konten, seperti **Jenis Konten**, **Topik Bahasan**, **Tone of Voice**, dan **Link Referensi**.*  
> - *Jika kita ubah ke **Rasya (Graphic Designer)**: Form langsung berganti meminta **Jenis Desain**, **Dimensi/Format**, **Brand Guideline URL**, dan **Catatan Warna**.*  
> - *Dan jika dialihkan ke **Popita (Social Media Specialist)**: Form berganti meminta **Platform Publikasi**, **Target Jadwal Posting**, dan **Goal Metrik**.*  
> 
> *Semua data spesifik ini disimpan secara dinamis ke dalam kolom JSON `input_data` di database MySQL. Fleksibel, terstruktur, dan tidak memerlukan tabel terpisah untuk tiap profesi!"*

---

### SEGMEN 6: Alur Kerja Anggota Tim (Content Creator - Melda) (06:30 - 07:45)

**[Visual]**  
*Gunakan dropdown 'Ganti Role Demo' di navbar kanan atas, klik **Melda Munisa**. Dashboard berganti ke tampilan Melda (tidak ada panel review queue Owner). Buka tugas milik Melda: **'Buat 10 ide konten & caption feed Instagram'** (`/tasks/1`).*  
*Tunjukkan layout Dual-Panel: Sisi Kiri (Brief Input dari Owner), Sisi Kanan (Form Output & Slider Progres milik Melda). Geser slider progres ke 60%, isi naskah caption contoh, lalu klik Simpan. Tunjukkan status otomatis berubah jadi In Progress.*

**[Narasi - Melda / Presenter]:**  
> *"Sekarang kita berganti peran menjadi **Melda**, sang Content Creator.*  
> 
> *Perhatikan bahwa tampilan antarmuka langsung beradaptasi: tombol-tombol administratif milik Owner tidak lagi terlihat, dan dashboard Melda murni fokus pada daftar tugas pribadinya.*  
> 
> *Saat membuka tugasnya, Melda disajikan tata letak **Dual-Panel** yang sangat nyaman:*  
> - *Panel kiri menampilkan **Brief Kerja Asli dari Owner** sehingga instruksi selalu jelas di depan mata.*  
> - *Panel kanan adalah **Form Hasil Kerja (Output Anggota)**. Melda dapat mengetikkan draf caption atau menyertakan tautan Google Docs.*  
> 
> *Di sini terdapat **Slider Progres Interaktif**. Ketika Melda menggeser progres menjadi 60% dan menekan Simpan, sistem secara cerdas langsung mengupdate status tugas dari **To Do menjadi In Progress** secara otomatis tanpa perlu tombol manual tambahan!*  
> 
> *Dan jika kita membuka tugas anggota lain — misalnya tugas milik Rasya — form input ini terkunci dan tidak bisa diedit karena proteksi kepemilikan tugas di server."*

---

### SEGMEN 7: Alur Validasi, Pengajuan Review, dan Revisi (07:45 - 09:15)

**[Visual]**  
1. *Pada akun Melda, naikkan progres ke 100%, klik tombol **'Ajukan Tugas ke Review Owner'**. Status berubah menjadi 'Review' ber-badge kuning.*  
2. *Ganti role kembali ke **Raffi (Owner)** melalui dropdown navbar. Buka `/dashboard` (tugas Melda kini muncul di panel Validasi). Buka tugas tersebut.*  
3. *Tunjukkan panel khusus Owner: Tombol **'Setujui Tugas (Approve & Done)'** dan tombol **'Minta Revisi...'**.*  
4. *Klik 'Minta Revisi...', ketikkan catatan: 'Tolong tone caption pada slide 3 dan 5 dibuat lebih santai dan relatable.', lalu klik Kirim Instruksi Revisi. Status berubah menjadi 'Revisi' ber-badge merah, dan Riwayat Revisi tercatat di bawah.*  
5. *Klik 'Setujui Tugas' untuk tugas Popita yang sudah valid -> Status berubah jadi 'Done' ber-badge hijau.*

**[Narasi - Popita / Presenter]:**  
> *"Sekarang kita masuk ke inti siklus kolaborasi: **Review & Validation Workflow**.*  
> 
> *Ketika Melda menyelesaikan seluruh naskah, ia menekan tombol **'Ajukan Tugas ke Review Owner'**. Progres otomatis terkunci di 100% dan status berpindah ke fase **Review**.*  
> 
> *Kini kita kembali login sebagai **Raffi** sang Project Manager. Di dashboard Raffi, tugas Melda langsung muncul di antrean validasi.*  
> 
> *Saat Raffi memeriksa detail tugas, muncul **Panel Otoritas Owner**:*  
> - *Jika pekerjaan sudah sempurna, Raffi cukup menekan tombol hijau **'Setujui Tugas'**, maka status langsung menjadi **Done** dan progres proyek meningkat.*  
> - *Namun jika ada yang kurang pas, Raffi menekan **'Minta Revisi'** dan wajib menyertakan catatan perbaikan. Sistem langsung mengembalikan status menjadi **Revisi** berwarna merah dan mencatatnya ke tabel riwayat revisi.*  
> 
> *Melda dapat membaca catatan revisi tersebut secara transparan, memperbaikinya, dan mengajukan kembali hingga disetujui. Inilah yang menjamin standar kualitas agensi tetap terjaga!"*

---

### SEGMEN 8: Uji Keamanan Server-Side (403) & Test Otomatis (09:15 - 10:00)

**[Visual]**  
1. *Switch akun ke **Melda (Member)**. Coba ketik manual di URL browser: `http://127.0.0.1:8000/projects/1/tasks/create` atau `/workspaces/1/projects/create` -> Tunjukkan halaman **403 Forbidden** dari Laravel.*  
2. *Beralih ke jendela Terminal/PowerShell. Jalankan perintah:*  
   ```bash
   php artisan test
   ```  
   *Tunjukkan 29 tests passing berwarna hijau.*

**[Narasi - Raffi / Presenter]:**  
> *"Sebagai penutup, kami ingin membuktikan bahwa keamanan sistem ini tidak hanya sebatas menyembunyikan tombol di antarmuka depan, melainkan dilindungi ketat di level **Middleware dan Controller Server-Side**.*  
> 
> *Ketika user ber-role Member mencoba membobol URL pembuatan proyek atau tugas secara manual, server langsung mencegatnya dengan respons HTTP **403 Forbidden**.*  
> 
> *Seluruh alur kerja end-to-end ini — mulai dari pembuatan workspace, isolasi multi-tenant, assignment tugas dinamis, hingga siklus Review-Revisi-Approve — telah kami uji secara komprehensif menggunakan **PHPUnit Feature Testing**. Hasilnya, seluruh **29 pengujian berjalan 100% sukses tanpa ada error**.*  
> 
> *Demikian demonstrasi fitur dari **Project Management SaaS Platform** kami. Terima kasih atas perhatian teman-teman dan dosen pengampu mata kuliah Pemrograman Web III. Sampai jumpa!"*

---

## 💡 Tips Tambahan untuk Perekaman Video:
- **Kecepatan Bicara:** Gunakan artikulasi jelas dan santai, tidak terburu-buru.
- **Transisi Role:** Gunakan dropdown *Ganti Role Demo* di kanan atas agar transisi di video terlihat instan dan profesional tanpa repot logout-ketik password berulang kali.
- **Durasi Ideal:** 7 sampai 8 menit sangat pas untuk dinilai dosen karena mencakup estetika UI, fungsi bisnis nyata, dan bukti teknis backend.

