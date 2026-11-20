# Script Video Presentasi — Project Management SaaS Platform
Durasi target: 5–8 menit | Pembicara: 4 orang (Raffi, Rasya, Melda, Popita) | Format: narasi saja

---

## SEGMENT 1 — Pembukaan & Gambaran Umum (± 1 menit)
**Pembicara: RAFFI**

Halo, perkenalkan kami dari kelompok Pemrograman Web III. Di video ini kami akan memperkenalkan Project Management SaaS Platform, yaitu aplikasi web untuk manajemen proyek dan validasi tugas tim kecil berbasis Laravel.

Masalah yang ingin kami selesaikan sederhana: tim agensi kecil biasanya mengelola tugas klien lewat chat, sehingga status pekerjaan dan hasil revisi sulit dilacak. Lewat platform ini, setiap tim punya workspace sendiri, di dalamnya ada proyek-proyek, dan setiap proyek berisi tugas yang dibagikan ke anggota dengan alur validasi sebelum dinyatakan selesai.

Contoh penerapan yang kami pakai adalah tim agensi digital beranggotakan empat orang. Raffi berperan sebagai Project Manager sekaligus Owner workspace, Rasya Chaniago sebagai Graphic Designer, Melda Munisa sebagai Content Creator, dan Popita Sari sebagai Social Media Specialist.

Stack teknologi yang kami gunakan: framework Laravel dengan autentikasi Laravel Breeze, database MySQL sebagai penyimpanan, Blade sebagai templating, Bootstrap 5 plus Bootstrap Icons lewat CDN untuk styling ant mukanya, Vite sebagai build tool, dan PHPUnit untuk pengujian.

Role dalam sistem ada tiga. Owner punya hak penuh: mengelola workspace, mengundang dan menghapus anggota, membuat proyek, assigning tugas, serta memvalidasi tugas. Admin punya hak yang sama kecuali menghapus workspace. Member hanya melihat proyek dan tugas miliknya, memperbarui status, serta mengajukan tugas untuk direview. Yang penting untuk digarisbawahi: role adalah hak akses sistem, sedangkan job_title seperti Graphic Designer adalah label pekerjaan saja, bukan hak akses.

---

## SEGMENT 2 — Struktur Database & Model (± 1,5 menit)
**Pembicara: RASYA**

Sekarang kita masuk ke fondasi aplikasinya, yaitu struktur database. Ada lima tabel utama yang dibuat lewat migration dan masing-masing punya model Eloquent.

Pertama, tabel users sebagai bawaan Breeze. Kedua, tabel workspaces yang menyimpan nama workspace dan owner_id sebagai foreign key ke users, yaitu siapa pembuat workspace tersebut.

Ketiga, tabel workspace_members. Ini tabel penghubung many-to-many antara users dan workspaces, tapi kita tambahkan dua kolom penting: role yang berisi enum owner, admin, atau member, dan job_title yang nullable untuk menandai keahlian anggota.

Keempat, tabel projects. Setiap proyek milik satu workspace, punya nama, nama klien, brief, tanggal mulai, dan deadline.

Kelima, tabel tasks. Ini jantung aplikasinya. Setiap tugas milik satu proyek, punya assigned_to yaitu siapa yang mengerjakan, created_by yaitu siapa yang menugaskan, lalu priority dengan enum low, medium, high, deadline, dan status dengan lima kemungkinan: todo, in progress, review, revisi, dan done. Selain itu ada dua kolom JSON, yaitu input_data untuk brief dari Owner dan output_data untuk hasil kerja dari anggota, serta satu kolom progress berupa persentase.

Terakhir, tabel task_revisions yang menyimpan catatan perbaikan dari Owner, dengan foreign key ke tasks dan created_by.

Relasinya kita bangun di model dengan hasMany dan belongsTo. Misalnya model Workspace punya relasi owner, members, dan projects, serta dua method bantu: isMember untuk mengecek apakah seorang user adalah anggota, dan memberOf untuk mengambil data keanggotaan lengkap dengan role-nya. Dua method ini yang jadi dasar seluruh pengecekan hak akses di aplikasi.

---

## SEGMENT 3 — Autentikasi, Workspace & Proyek (± 2 menit)
**Pembicara: MELDA**

Sisi autentikasi kami serahkan penuh ke Laravel Breeze, jadi user bisa register, login, dan logout tanpa kami tulis dari nol. Untuk memudahkan demo antar role, kami tambahkan satu route bernama quick-login yang langsung login sebagai user tertentu berdasarkan email.

Fitur pertama adalah workspace. Di WorkspaceController, saat method store dijalankan, kami tidak hanya membuat record workspace, tapi otomatis memasukkan pembuatnya ke tabel workspace_members dengan role owner. Jadi tidak mungkin ada workspace tanpa owner.

Untuk mengundang anggota, method addMember memvalidasi email yang wajib ada di tabel users dan job_title yang harus pilih salah satu dari tiga keahlian. Setelah user ditemukan berdasarkan email, kami cek dulu lewat isMember supaya tidak ada anggota ganda, baru dibuat record workspace_members baru dengan role member. Sebaliknya, method removeMember punya pengaman khusus: kalau yang mau dihapus ternyata berperan sebagai owner, permintaan ditolak.

Keamanan akses kami jaga di dua lapis. Lapis pertama adalah middleware CheckWorkspaceMember yang didaftarkan dengan alias workspace.member dan dipasang di group route workspace. Middleware ini memanfaatkan route model binding untuk mengambil objek Workspace, lalu memanggil isMember. Kalau user bukan anggota, langsung kami abort dengan status 403, jadi data workspace lain benar-benar tidak bisa dibuka dari sisi server. Lapis kedua adalah method authorizeOwner yang kami panggil di dalam tiap controller untuk aksi sensitif. Cara kerjanya: ambil data keanggotaan user tersebut lewat memberOf, lalu cek isOwner yang membandingkan kolom role dengan nilai owner. Kalau role-nya member biasa, permintaan ditolak dengan 403. Di level database, kolom role ini kita buat sebagai enum dengan tiga nilai: owner, admin, dan member.

Fitur berikutnya adalah manajemen proyek lewat ProjectController. Route untuk membuat dan menyimpan proyek di-nested di bawah workspace, sehingga proyek selalu tahu dia milik siapa. Sementara route edit, update, dan hapus dilindungi authorizeOwner, artinya hanya Owner yang boleh mengelola proyek. Data yang diinput divalidasi di sini, termasuk aturan bahwa deadline harus setelah atau sama dengan tanggal mulai. Untuk tampilan, halaman detail proyek mengelompokkan tugas per status dengan Eloquent collect groupBy, sehingga siap ditampilkan sebagai board.

---

## SEGMENT 4 — Manajemen Tugas & Alur Validasi (± 2 menit)
**Pembicara: POPITA**

Ini bagian yang paling membedakan aplikasi kami dari to-do list biasa, yaitu manajemen tugas yang adaptif terhadap profesi.

Saat Owner membuat tugas di TaskController method store, sistem mencari data keanggotaan dari user yang di-assign, lalu mengambil inputSchema berdasarkan job_title-nya. Method inputSchema di model Task menggunakan match expression yang mengembalikan daftar field berbeda untuk tiap profesi. Content Creator mendapat field jenis konten, topik, tone of voice, dan link referensi. Graphic Designer mendapat jenis desain, dimensi, link brand guideline, dan catatan warna. Social Media Specialist mendapat platform, target tanggal posting, dan goal campaign. Jadi satu form yang sama otomatis menyesuaikan diri, dan semuanya disimpan sebagai JSON di kolom input_data.

Sisi anggota juga begitu. Lewat method updateWork, anggota mengisi progres dalam persen sekaligus output_data yang skemanya diambil dari outputSchema sesuai job_title mereka. Misalnya Content Creator mengisi isi caption dan link naskah, sedangkan Social Media Specialist mengisi link postingan tayang, reach, engagement, dan catatan analisis.

Ada aturan status otomatis di sini: kalau tugas masih berstatus todo tapi progresnya sudah lebih dari nol, sistem langsung mengubahnya menjadi in progress tanpa perlu tombol terpisah.

Otorisasinya tegas. Method updateWork dan submitReview sama-sama mengecek apakah assigned_to tugas itu sama dengan user yang login. Kalau bukan tugasnya, akses ditolak. Jadi member tidak mungkin mengutak-atik tugas orang lain.

Nah, alur validasinya ada di TaskValidationController. Ketika anggota menekan ajukan review, status berubah menjadi review dan progress dipaksa seratus persen. Selanjutnya giliran Owner. Kalau hasil kerja disetujui, method approve mengubah status menjadi done. Tapi kalau belum sesuai, misalnya caption tidak cocok dengan tone of voice klien, method requestRevision mengubah status menjadi revisi sekaligus menyimpan catatan perbaikan ke tabel task_revisions lewat relasi revisions. Catatan ini yang nanti dibaca anggota di halaman detail tugas, lalu dia revisi dan ajukan lagi. Berulang sampai approve.

Terakhir, dashboard progres di DashboardController merangkum semuanya dalam satu halaman. Pertama, kami ambil seluruh keanggotaan user beserta workspace, proyek, tugas, dan anggotanya lewat eager loading dengan method with, sehingga menghindari masalah N-plus-one query. Kedua, daftar tugas milik user yang belum selesai, yaitu status todo, in progress, review, dan revisi, lintas workspace, lalu diurutkan berdasarkan deadline terdekat supaya tugas yang mendesak tampil paling atas. Ketiga, khusus untuk Owner, kami cari semua tugas berstatus review di workspace yang dia punya lewat whereHas dan where status, yang menjadi antrean review. Model Task juga menyediakan method isLate yang mendeteksi tugas lewat deadline dan belum done, serta method statusColor yang memberi warna badge per status, sehingga di dashboard dan board tugas terlambat langsung tampil sebagai penanda merah. Board-nya sendiri kami render sebagai lima kolom status, dan setiap kartu tugas menampilkan bar progres berdasarkan kolom progress.

---

## SEGMENT 5 — Penutup (± 45 detik)
**Pembicara: RAFFI**

Sebagai simpulan, aplikasi ini sudah memenuhi seluruh alur yang kami rencanakan dalam delapan tahap: dari setup project, migrasi database, autentikasi, workspace dan anggota, manajemen proyek, manajemen tugas, validasi tugas, sampai dashboard progres.

Tiga hal yang menjadi kekuatan platform ini. Pertama, multi-tenancy berbasis workspace sehingga tiap tim terisolasi datanya. Kedua, hak akses bertingkat dengan middleware plus pemeriksaan di controller, bukan cuma sembunyi tombol di frontend. Ketiga, form tugas berbasis profesi yang bikin satu aplikasi bisa dipakai tim dengan peran berbeda tanpa mengubah kode.

Ke depannya kami ingin menambahkan drag-and-drop pada board tugas, notifikasi email saat tugas direvisi, serta unggah file hasil kerja langsung ke server.

Sekian demo dan penjelasan kode dari kami. Terima kasih atas perhatiannya.

---

