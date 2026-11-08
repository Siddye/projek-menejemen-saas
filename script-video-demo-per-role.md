# Script Video Demo Aplikasi — Terpisah per Role (4 Orang)
**Mata Kuliah:** Pemrograman Web III  
**Proyek:** Project Management SaaS Platform (Digital Agency Studio)  
**Total Durasi:** ± 8 – 10 Menit (tiap orang berbicara ± 2 menit)  

---

## 👥 Pembagian Tugas & Profil Akun Demo

| No | Nama | Role Sistem | Job Title | Tanggung Jawab Utama dalam Demo |
|---|---|---|---|---|
| **1** | **Raffi** | **Owner** | Project Manager | Pembukaan, UI/Login, Manajemen Workspace & Proyek, Form Tugas Dinamis, Penutup & Bukti Keamanan (403) |
| **2** | **Melda Munisa** | **Member** | Content Creator | Tampilan Dashboard Member, Dual-Panel Brief/Output, Slider Progres, Otomatisasi Status, Pengajuan Review |
| **3** | **Popita Sari** | **Member** | Sosmed Specialist | Tugas Jadwal & Laporan Tayang, Pengamanan Data (tidak bisa edit tugas orang lain), Alur Approved (Done) |
| **4** | **Rasya Chaniago** | **Member** | Graphic Designer | Tugas Desain Feed, Menerima Catatan Revisi dari Owner, Siklus Perbaikan & Resubmit Desain |

---

## 🎬 Setup Teknis Sebelum Rekam

1. **Jalankan terminal lokal:**
   ```bash
   cd "C:/xampp/htdocs/Project Management SaaS Platform"
   php artisan migrate:fresh --seed
   php artisan serve --port=8000
   ```
2. Buka `http://127.0.0.1:8000` di browser Google Chrome / Edge dalam keadaan **Full Screen**.
3. Gunakan dropdown **"Ganti Role Demo"** di kanan atas navbar untuk berpindah akun antar anggota secara instan.

---

---

# BAGIAN 1: RAFFI (Owner & Project Manager)
**Peran:** Owner Workspace, Project Manager, Pembuat Kebijakan & Otoritas Sistem  
**Estimasi Durasi:** ± 2,5 Menit  
**Akun Demo:** `raffi@agency.test` (Password: `password`)  

---

### [Langkah 1.1] Pembukaan & Tampilan Login Glassmorphism
**[Visual di Layar]**  
- Tampilkan halaman awal `http://127.0.0.1:8000/login`.
- Arahkan kursor ke layout glassmorphism: panel hero gelap di kiri, kartu form login di kanan, dan 4 tombol *Quick Login* di bawah.

**[Narasi yang Diucapkan Raffi]:**  
> *"Halo semuanya! Kami dari kelompok Pemrograman Web III. Di video kali ini, kami akan mendemonstrasikan aplikasi yang telah kami bangun, yaitu **Project Management SaaS Platform**.*  
> 
> *Aplikasi ini dirancang khusus untuk memecahkan masalah klasik pada agensi kreatif, di mana koordinasi tugas klien sering kali berceceran di grup chat dan tidak memiliki alur verifikasi mutu yang jelas.*  
> 
> *Dari segi antarmuka, aplikasi kami mengusung tema **Modern Glassmorphism** dengan palet warna deep teal, kartu frosted glass, dan ambient aura gradient.*  
> 
> *Untuk memudahkan demo dan pengujian, di halaman login ini telah kami sediakan fitur **Quick Login Demo** yang berisi 4 profil anggota tim kami sesuai skenario studi kasus: Saya sendiri, Raffi sebagai Project Manager & Owner, rekan saya Melda sebagai Content Creator, Popita sebagai Social Media Specialist, dan Rasya sebagai Graphic Designer.*  
> 
> *Mari kita masuk terlebih dahulu menggunakan akun saya sebagai Owner."*

---

### [Langkah 1.2] Dashboard Owner & Fitur Eksklusif Review Queue
**[Visual di Layar]**  
- Klik tombol quick login **Raffi**.
- Masuk ke `/dashboard`. Tunjukkan sidebar melayang di kiri, top-bar dengan identitas agensi, dan badge peran *Owner / PM*.
- Arahkan kursor ke kartu **Campaign Media Sosial Kopi Nusantara** dan kartu **Validasi Tugas Anggota / Review Queue**.

**[Narasi yang Diucapkan Raffi]:**  
> *"Saat ini kita telah berada di Dashboard Utama.*  
> 
> *Di sisi kiri terdapat sidebar navigasi vertikal yang clean dan terisolasi. Di dashboard saya sebagai Owner, ada komponen istimewa yang menjadi keunggulan sistem kami:*  
> 
> *Pertama, kartu **Active Campaign** yang memperlihatkan proyek klien Kopi Nusantara, lengkap dengan progres penyelesaian kumulatif dan deretan avatar tim yang bertugas.*  
> 
> *Kedua, panel **'Validasi Tugas Anggota'** atau Review Queue. Panel ini **hanya akan muncul pada akun Owner** saat ada tugas anggota yang sudah diajukan dan membutuhkan persetujuan. Jadi, Project Manager tidak perlu membuka proyek satu per satu hanya untuk mengecek pekerjaan yang siap ditinjau."*

---

### [Langkah 1.3] Manajemen Workspace & Tim Agensi
**[Visual di Layar]**  
- Buka menu **Workspace** di sidebar (`/workspaces/1`).
- Tunjukkan daftar kampanye di kiri dan daftar anggota tim di kanan.
- Sorot form **'+ Tambah Anggota ke Tim'**. Ketikkan email `raffi@agency.test`, lalu klik Submit untuk memunculkan pesan validasi guard.

**[Narasi yang Diucapkan Raffi]:**  
> *"Sekarang kita buka halaman detail Workspace **'Digital Agency Studio'**.*  
> 
> *Di panel sebelah kanan, Owner memiliki wewenang untuk mengundang anggota tim baru berdasarkan alamat email dan memilih keahlian profesinya.*  
> 
> *Sistem kami dilengkapi pengaman ganda: jika saya mencoba mendaftarkan kembali email yang sudah tergabung — misalnya email saya sendiri — sistem otomatis menolaknya dengan pesan: **'User sudah jadi anggota workspace ini'**.*  
> 
> *Selain itu, akun Owner dilindungi di level controller sehingga tidak bisa dihapus dari workspace oleh siapa pun."*

---

### [Langkah 1.4] Board Proyek & Form Tugas Dinamis Sesuai Profesi
**[Visual di Layar]**  
- Masuk ke detail proyek `/projects/1`. Tunjukkan **5 Kolom Kanban Board** (To Do, In Progress, Review, Revisi, Done).
- Klik tombol **'+ Buat Tugas Baru'** (`/projects/1/tasks/create`).
- Buka dropdown *'Pilih Anggota Tim (Assignee)'*. Ubah pilihan bergantian: **Melda** ➔ **Rasya** ➔ **Popita**. Tunjukkan form brief di bawahnya yang berubah otomatis.

**[Narasi yang Diucapkan Raffi]:**  
> *"Selanjutnya, mari kita masuk ke papan proyek klien Kopi Nusantara. Proyek ini disajikan dalam bentuk **Kanban Board 5 Kolom** interaktif.*  
> 
> *Saat Owner membuat tugas baru, kami menerapkan fitur **Dynamic Role-Based Task Schema**:*  
> - *Ketika saya memilih **Melda (Content Creator)**, form brief secara otomatis memunculkan kolom: **Jenis Konten, Topik, Tone of Voice, dan Link Referensi**.*  
> - *Namun, jika saya ubah memilih **Rasya (Graphic Designer)**, form brief berganti meminta: **Format Dimensi, Link Brand Guideline, dan Catatan Warna**.*  
> - *Dan jika memilih **Popita (Social Media Specialist)**, form berganti menjadi: **Platform Sosmed, Target Jadwal Tayang, dan Target KPI**.*  
> 
> *Seluruh parameter spesifik profesi ini disimpan secara terstruktur ke dalam format JSON di database.*  
> 
> *Sekarang, mari kita lihat bagaimana rekan saya, Melda, mengerjakan tugas pembuatan kontennya dari sisi Member."*

---

---

# BAGIAN 2: MELDA MUNISA (Content Creator)
**Peran:** Member Tim, Spesialis Pembuat Konten & Naskah Caption  
**Estimasi Durasi:** ± 2 Menit  
**Akun Demo:** `melda@agency.test` (Password: `password`)  

---

### [Langkah 2.1] Login Member & Antarmuka Terfokus
**[Visual di Layar]**  
- Klik dropdown **"Ganti Role Demo"** di navbar kanan atas, pilih **Melda Munisa**.
- Halaman dashboard reload. Tunjukkan badge peran hijau **Content Creator / Member**.
- Tunjukkan bahwa panel *Review Queue* milik Owner tidak ada di sini, menyisakan daftar tugas milik Melda saja.

**[Narasi yang Diucapkan Melda]:**  
> *"Halo, saya Melda Munisa sebagai Content Creator di Digital Agency Studio.*  
> 
> *Ketika saya masuk menggunakan akun saya, antarmuka dashboard langsung menyesuaikan:*  
> *Panel administratif dan antrean validasi milik Owner tidak ditampilkan. Dashboard saya terfokus menampilkan tugas-tugas yang memang di-assign kepada saya, diurutkan berdasarkan tenggat waktu terdekat.*  
> 
> *Di sini terlihat saya memiliki tugas berjudul **'Buat 10 ide konten & caption feed Instagram'** dengan status awal masih **To Do**."*

---

### [Langkah 2.2] Mengerjakan Tugas: Layout Dual-Panel & Auto-Status Update
**[Visual di Layar]**  
- Klik tugas Melda (`/tasks/1`).
- Jelaskan pembagian 2 kolom: Sisi Kiri (Brief Input dari Owner Raffi) dan Sisi Kanan (Form Hasil Kerja Output).
- Pada panel kanan:
  - Tuliskan teks naskah contoh di textarea caption (misal: *"Draf 10 Caption Kopi Nusantara: Slide 1 - Kehangatan Kopi Asli Indonesia..."*).
  - Masukkan link naskah (misal: `https://docs.google.com/document/d/demo-melda`).
  - Geser **Slider Progres** dari 0% menjadi **60%**, lalu klik tombol **'Simpan Hasil & Progres'**.
- Tunjukkan badge status di atas yang otomatis berubah dari **To Do** menjadi **In Progress** (warna biru).

**[Narasi yang Diucapkan Melda]:**  
> *"Saat saya membuka halaman detail tugas, kami menyajikan tata letak **Dual-Panel** yang sangat memudahkan pekerjaan kreatif:*  
> - *Di sisi kiri, saya bisa membaca **Brief Lengkap dari Owner**, mulai dari topik peluncuran produk kopi kemasan baru, tone of voice santai anak muda, hingga tautan referensi.*  
> - *Di sisi kanan, terdapat **Form Hasil Kerja** yang spesifik untuk Content Creator: tempat saya memasukkan isi caption dan tautan Google Docs.*  
> 
> *Sekarang saya isi draf caption-nya dan saya geser **Slider Progres Interaktif** ini ke **60%**, lalu saya klik Simpan.*  
> 
> *Perhatikan bahwa sistem secara cerdas langsung memperbarui status tugas dari **To Do menjadi In Progress** secara otomatis begitu ada progres pengerjaan, tanpa perlu tombol manual yang membingungkan!"*

---

### [Langkah 2.3] Mengajukan Tugas Selesai ke Review Owner
**[Visual di Layar]**  
- Geser kembali slider progres ke **100%**.
- Klik tombol **'Ajukan Tugas ke Review Owner ↑'**.
- Muncul dialog konfirmasi browser, klik OK.
- Tunjukkan bahwa status tugas kini berubah menjadi **Review** (badge kuning) dan form pengeditan dikunci.

**[Narasi yang Diucapkan Melda]:**  
> *"Setelah seluruh naskah dan materi selesai dikerjakan, saya naikkan progres menjadi **100%**, lalu menekan tombol **'Ajukan Tugas ke Review Owner'**.*  
> 
> *Status tugas kini resmi berpindah ke fase **Review**. Pada tahap ini, form input saya dikunci sementara untuk mencegah perubahan data selagi ditinjau oleh Project Manager.*  
> 
> *Selanjutnya, mari kita lihat bagaimana tugas yang dikerjakan oleh rekan saya, Popita, disetujui dan diselesaikan di sistem."*

---

---

# BAGIAN 3: POPITA SARI (Social Media Specialist)
**Peran:** Member Tim, Pengelola Jadwal & Distribusi Media Sosial  
**Estimasi Durasi:** ± 2 Menit  
**Akun Demo:** `popita@agency.test` (Password: `password`)  

---

### [Langkah 3.1] Spesialisasi Tugas Sosmed & Pengamanan Akses Antar-Anggota
**[Visual di Layar]**  
- Gunakan dropdown navbar untuk berganti role ke **Popita Sari**.
- Masuk ke `/projects/1`. Klik tugas milik orang lain (misal tugas Rasya `/tasks/2`).
- Tunjukkan bahwa di tugas Rasya, Popita **hanya bisa membaca (read-only)** dan tidak ada form untuk mengedit hasil kerja.
- Kembali ke `/projects/1`, buka tugas milik Popita sendiri: **'Susun jadwal posting 2 minggu'** (`/tasks/3`).

**[Narasi yang Diucapkan Popita]:**  
> *"Halo, saya Popita Sari sebagai Social Media Specialist.*  
> 
> *Sebelum melihat tugas saya, saya ingin memperlihatkan aspek keamanan penting pada aplikasi kami: ketika saya mencoba membuka tugas milik Rasya atau Melda, sistem mengunci form pengerjaan. Tombol edit maupun submit review tidak dirender sama sekali untuk saya.*  
> *Artinya, **setiap anggota tim hanya berhak mengubah tugas miliknya sendiri**.*  
> 
> *Sekarang kita buka tugas milik saya: **'Susun jadwal posting 2 minggu'**.*  
> *Sesuai profesi saya, form output yang disediakan adalah link jadwal posting spreadsheet dan catatan analisis strategi tayang.*  
> *Tugas saya ini sudah berprogres 100% dan berada pada status **Review**."*

---

### [Langkah 3.2] Simulasi Persetujuan Tugas (Approval ke Status Done)
**[Visual di Layar]**  
- Ganti role kembali ke **Raffi (Owner)** melalui dropdown cepat.
- Masuk ke `/dashboard`. Perlihatkan bahwa tugas Popita dan tugas Melda tampil di panel **'Validasi Tugas Anggota'**.
- Klik tugas Popita (`/tasks/3`).
- Tunjukkan panel hijau/kuning validasi Owner di bawah. Klik tombol hijau: **'Setujui Tugas (Approve & Done)'**.
- Muncul dialog konfirmasi, klik OK.
- Tunjukkan status tugas berubah menjadi **Done** (badge hijau emerald). Buka `/projects/1` dan perlihatkan kartu Popita sudah berada di kolom **Done**.

**[Narasi yang Diucapkan Popita / Raffi]:**  
> *(Popita melanjutkan narasi saat layar berpindah ke akun Raffi):*  
> *"Ketika tugas saya berada di status Review, Project Manager kami, Raffi, langsung melihat notifikasinya di panel Validasi Tugas di dashboard.*  
> 
> *Raffi memeriksa link jadwal tayang yang saya lampirkan. Karena jadwal posting sudah selaras dengan peluncuran produk kopi klien, Raffi cukup mengklik tombol hijau **'Setujui Tugas (Approve & Done)'**.*  
> 
> *Seketika status tugas berubah menjadi **Done**, dan di papan Kanban kartu saya resmi berpindah ke kolom hijau selesai. Progres keseluruhan kampanye pun ikut meningkat secara otomatis.*  
> 
> *Lalu, bagaimana jika hasil kerja belum sempurna dan membutuhkan perbaikan? Rekan saya, Rasya Chaniago, akan memperlihatkan alur revisinya."*

---

---

# BAGIAN 4: RASYA CHANIAGO (Graphic Designer)
**Peran:** Member Tim, Desainer Visual Kampanye & Pelaksana Alur Revisi  
**Estimasi Durasi:** ± 2 Menit  
**Akun Demo:** `rasya@agency.test` (Password: `password`)  

---

### [Langkah 4.1] Tugas Desain Visual & Pengajuan Awal
**[Visual di Layar]**  
- Beralih peran ke **Rasya Chaniago** melalui dropdown navbar.
- Buka tugas milik Rasya: **'Desain 10 visual feed Instagram'** (`/tasks/2`).
- Tunjukkan brief khusus desain: Brand Guideline link, dimensi 1080x1080, format PNG.
- Geser slider ke 100%, isi link desain (misal: `https://figma.com/file/demo-kopi-nusantara`), klik **Ajukan Tugas ke Review Owner**. Status menjadi **Review**.

**[Narasi yang Diucapkan Rasya]:**  
> *"Halo semuanya, saya Rasya Chaniago selaku Graphic Designer di tim ini.*  
> 
> *Pada tugas saya, brief yang diberikan Project Manager mencakup link Brand Guideline, palet warna, dan dimensi feed Instagram.*  
> 
> *Setelah menyelesaikan aset visual di Figma, saya masukkan link desainnya dan mengajukan tugas ke status **Review** agar diperiksa oleh Raffi."*

---

### [Langkah 4.2] Menerima Catatan Revisi Transparan dari Owner
**[Visual di Layar]**  
- Ganti role sejenak ke **Raffi (Owner)**, buka `/tasks/2`.
- Di panel validasi, klik tombol merah **'Minta Revisi...'**.
- Ketikkan catatan di textarea: *"Tone warna pada feed ke-3 dan ke-7 terlalu gelap. Harap sesuaikan dengan palet krem hangat kopi kemasan terbaru."*
- Klik **'Kirim Instruksi Revisi'**.
- Status berganti menjadi **Revisi** (badge merah).
- Beralih kembali ke **Rasya Chaniago** (`/tasks/2`). Tunjukkan card **'Riwayat Catatan Revisi'** yang muncul di bagian bawah halaman.

**[Narasi yang Diucapkan Rasya]:**  
> *"Sekarang, mari kita lihat apa yang terjadi saat Owner meminta perbaikan.*  
> 
> *Ketika Raffi memeriksa desain saya dan mendapati warna yang belum sesuai guideline, Raffi menekan tombol **'Minta Revisi'** dan menuliskan catatan perbaikan.*  
> 
> *Begitu saya membuka kembali halaman tugas saya sebagai Rasya, status tugas langsung ditandai dengan badge merah **Revisi**.*  
> 
> *Yang sangat kami sukai dari sistem ini adalah transparansinya: di bagian bawah tugas, terdapat panel **Riwayat Catatan Revisi** lengkap dengan nama pembuat catatan dan waktu pengirimannya.*  
> *Instruksi Raffi tertulis jelas: 'Tone warna pada feed ke-3 dan ke-7 terlalu gelap, sesuaikan dengan palet krem hangat'.*  
> 
> *Dengan instruksi tertulis ini, desainer tidak akan salah paham. Tombol ajukan review otomatis terbuka kembali, sehingga setelah file di Figma saya perbarui, saya bisa langsung mengajukannya kembali ke Owner sampai disetujui!"*

---

---

# PENUTUP & PEMBUKTIAN KEAMANAN (RAFFI)
**Estimasi Durasi:** ± 1,5 Menit  
**Pembicara:** Raffi (didampingi seluruh anggota)  

---

### [Langkah 5.1] Uji Proteksi Server-Side (Simulasi Bypass URL 403)
**[Visual di Layar]**  
- Masuk sebagai **Melda (Member)**.
- Buka address bar browser, ketik manual URL pembuatan tugas: `http://127.0.0.1:8000/projects/1/tasks/create` lalu tekan Enter.
- Tunjukkan halaman error bawaan Laravel: **403 | USER DOES NOT HAVE ACCESS / FORBIDDEN**.
- Coba juga URL edit proyek: `http://127.0.0.1:8000/projects/1/edit` ➔ Tunjukkan hasil yang sama (**403 Forbidden**).

**[Narasi yang Diucapkan Raffi]:**  
> *"Sebelum mengakhiri presentasi, kami ingin menunjukkan bahwa keamanan hak akses di platform ini tidak hanya sebatas menyembunyikan tombol di tampilan HTML.*  
> 
> *Jika seorang Member mencoba mengakses halaman administratif secara langsung lewat pengetikan URL di address bar — misalnya halaman membuat tugas atau mengedit proyek — server melalui Middleware `CheckWorkspaceMember` dan method `authorizeOwner` langsung mencegatnya dan mengembalikan status **403 Forbidden**.*  
> 
> *Hak akses kami amankan secara ketat di sisi server!"*

---

### [Langkah 5.2] Bukti Pengujian Otomatis (PHPUnit Feature Test) & Penutup
**[Visual di Layar]**  
- Buka terminal / command prompt.
- Jalankan perintah:
  ```bash
  php artisan test
  ```
- Biarkan terminal memproses hingga muncul banner hijau: **PASS (29 passed, 76 assertions)**.
- Sorot file test utama: `ProjectManagementWorkflowTest`.

**[Narasi yang Diucapkan Raffi]:**  
> *"Seluruh skenario kolaborasi yang kami peragakan tadi — mulai dari autentikasi, isolasi workspace, dynamic form input, hingga siklus Review-Revisi-Done — telah kami uji secara otomatis menggunakan **PHPUnit Feature Testing**.*  
> 
> *Dapat dilihat di layar terminal, seluruh **29 unit & feature tests dengan 76 assertions berhasil lolos 100% tanpa ada satu pun kegagalan**.*  
> 
> *Kesimpulannya, Project Management SaaS Platform ini berhasil membuktikan bahwa sistem berbasis peran mampu menertibkan alur kerja tim kreatif secara rapi, aman, dan profesional.*  
> 
> *Sekian demonstrasi dari kelompok kami. Terima kasih banyak atas perhatian Bapak/Ibu dosen dan rekan-rekan sekalian. Wassalamualaikum warahmatullahi wabarakatuh."*

---

## 📌 Rangkuman Pembagian Waktu (Cue Sheet Rekaman)

```text
[00:00 - 02:30] RAFFI    : Intro, Login Glassmorphism, Multi-Tenancy, Dynamic Form
[02:30 - 04:30] MELDA    : Dashboard Member, Dual-Panel Brief/Output, Slider Auto-Status
[04:30 - 06:30] POPITA   : Guard Akses Antar-Member, Verifikasi Jadwal, Approve ke Done
[06:30 - 08:30] RASYA    : Brief Desain, Catatan Revisi Transparan, Alur Resubmit
[08:30 - 10:00] RAFFI    : Bukti Keamanan 403 Server-Side, 29/29 Automated Tests, Closing
```

