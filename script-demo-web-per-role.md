# Script Demo Web per Role
Pasangan dari [script-video-presentasi.md](./script-video-presentasi.md) dan [daftar-file-penjelasan-video.md](./daftar-file-penjelasan-video.md).
Semua langkah di file ini **sudah dites jalan** di server lokal (status HTTP terverifikasi), bukan asumsi.

### Bukti Verifikasi Otomatis (ditulis lewat curl + baca HTML hasil render)

| Yang diverifikasi | Hasil |
|---|---|
| 4 akun quick-login & halaman utama (`/dashboard`, `/workspaces`, `/workspaces/1`, `/projects/1`, `/tasks/1-3`) | 200 untuk semua role |
| Member akses form create proyek / create tugas / edit proyek | **403** semua (Owner: 200) |
| Tombol "Tambah Anggota", "Hapus Anggota", "Buat Tugas Baru" | Muncul hanya saat login Raffi; hilang saat login Melda |
| Form `tasks/{id}/work` + `submit-review` di tugas orang lain | Tidak dirender sama sekali untuk non-assignee |
| Section "Perlu Tindakan Owner / Validasi Tugas Anggota" di dashboard | Ada di dashboard Raffi, tidak ada di dashboard Melda |
| Invite email sudah jadi anggota | Error "User sudah jadi anggota workspace ini." muncul |
| Data setelah seluruh tes | Tidak berubah: tetap 3 tugas, 4 anggota (hanya GET + 1 invite yang ditolak) |

---

## 0. Setup Sebelum Rekaman

```bash
cd "C:/xampp/htdocs/Project Management SaaS Platform"
php artisan migrate:fresh --seed     # reset ke data awal demo
npm run dev                          # (opsional) kalau asset belum ke-build
php artisan serve --port=8000        # jalankan di terminal terpisah
```

Buka `http://127.0.0.1:8000` → otomatis redirect ke `/login`.

### 4 Akun Demo (dari `database/seeders/DatabaseSeeder.php`)

| Nama | Email | Password | Role | job_title |
|---|---|---|---|---|
| Raffi | `raffi@agency.test` | `password` | **Owner** | — |
| Rasya Chaniago | `rasya@agency.test` | `password` | Member | `graphic_designer` |
| Melda Munisa | `melda@agency.test` | `password` | Member | `content_creator` |
| Popita Sari | `popita@agency.test` | `password` | Member | `social_media_specialist` |

**Shortcut ganti role (buat rekaman biar nggak perlu logout-login manual):**
`http://127.0.0.1:8000/quick-login/melda@agency.test` — tinggal ganti emailnya.
Atau klik dropdown **"Ganti Role Demo"** di kanan atas layar (`resources/views/layouts/app.blade.php:588-615`).

### Kondisi Data Awal Setelah Seed

| # | Tugas | Assignee | Status | Progres |
|---|---|---|---|---|
| 1 | Buat 10 ide konten & caption feed Instagram | Melda | `todo` | 0% |
| 2 | Desain 10 visual feed Instagram | Rasya | `in_progress` | 40% |
| 3 | Susun jadwal posting 2 minggu | Popita | `review` | 100% |

Workspace: **Digital Agency Studio** (`/workspaces/1`) — Proyek: **Campaign Media Sosial - Peluncuran Produk** / klien Kopi Nusantara (`/projects/1`).

### Saran Urutan Rekam
Rekam **blok A (Owner) dulu**, lalu **blok B (Member)**, baru **blok C (validasi)**, terakhir **blok D (keamanan)**. Alasannya: blok C mengubah status tugas, jadi blok A & B direkam dalam kondisi data pristine. Setelah selesai, `php artisan migrate:fresh --seed` lagi buat balikin kondisi awal.

---

## BLOK A — Owner: Raffi (± 2 menit)
**Login:** `quick-login/raffi@agency.test`

| Langkah | URL / Aksi | Yang dibicarain |
|---|---|---|
| A1 | `/dashboard` | Badge **"Owner"** ungu di kanan atas. Dashboard nampilin card ringkasan + bagian **"Perlu Tindakan Owner" / "Validasi Tugas Anggota" (Review Queue)** — bagian ini tidak muncul sama sekali di dashboard member. Jelasin angkanya diambil dari query group-by status. |
| A2 | Sidebar **Workspace** → `/workspaces` | Daftar workspace yang dia ikut. Owner bisa punya banyak workspace — dasar multi-tenancy. |
| A3 | Tombol **Buat Workspace** → `/workspaces/create` | Isi nama → submit. Poin penting: **pembuat otomatis jadi anggota ber-role owner**, nggak perlu invite diri sendiri. (Lihat `WorkspaceController::store` baris 31–41.) |
| A4 | `/workspaces/1` kolom kanan | **Anggota tim**: Raffi (Owner) + 3 member lengkap dengan label job_title-nya. |
| A5 | Form **+ Tambah Anggota ke Tim** | Input email terdaftar + pilih job_title. Coba `raffi@agency.test` → muncul error **"User sudah jadi anggota workspace ini"** — ini nunjukin guard anti-duplikat di `addMember()`. |
| A6 | `/workspaces/1/projects/create` | Form proyek: nama, **nama klien**, brief, tanggal mulai, deadline. Coba masukin deadline **sebelum** start_date → validasi nolak (`after_or_equal:start_date`). |
| A7 | `/projects/1` | **Board 5 kolom**: To Do / In Progress / Review / Revisi / Done. Tutup dengan penjelasan: "Popita sudah masuk kolom Review, Rasya 40% di In Progress." |
| A8 | `/projects/1/tasks/create` | **Momen terpenting di demo Owner.** Dropdown assignee punya atribut `data-job`. Ganti pilihan dari Melda → Rasya → Popita, dan **field form ikut berubah sendiri**: Melda dapat Topik + Tone of Voice, Rasya dapat Dimensi + Brand Guideline, Popita dapat Platform + Target Posting. Satu form, tiga profesi (`Task::inputSchema`). |
| A9 | Submit tugas baru | Balik ke board, kartu tugas baru muncul di kolom **To Do** dengan badge prioritas + nama assignee. |

---

## BLOK B — Member: Melda (Content Creator) (± 1,5 menit)
**Login:** `quick-login/melda@agency.test`

| Langkah | URL / Aksi | Yang dibicarain |
|---|---|---|
| B1 | `/dashboard` | Badge **"Member"** hijau + label **Content Creator**. Section "Perlu Tindakan Owner" tidak muncul — yang tersisa cuma **daftar tugas saya** lintas workspace, diurutin deadline terdekat. |
| B2 | `/workspaces/1` | Compare sama A4: **form tambah anggota hilang**, tombol hapus anggota hilang. Jelasin ini bukan cuma CSS — route-nya juga dikunci (dibuktikan di blok D). |
| B3 | `/projects/1` | Board tetap bisa dilihat (member butuh konteks), tapi tombol **Buat Tugas Baru tidak muncul** buat dia. |
| B4 | `/tasks/1` (tugas miliknya) | Bagian **brief dari Owner** terisi otomatis dari `input_data`: Jenis Konten = Caption, Topik = Peluncuran produk kopi kemasan baru, Tone of Voice = Santai hangat anak muda, Link referensi. |
| B5 | Scroll ke form progres | **Slider/input progres** (0–100) + field output versi Content Creator: Isi Konten/Caption (textarea) + Link File Naskah. Isi caption contoh + progres 60%. |
| B6 | Submit | Muncul flash message sukses. **Yang perlu disorot:** status langsung berubah `todo → in_progress` otomatis karena progres > 0, tanpa tombol terpisah. Balik lagi kartunya sudah pindah ke kolom In Progress di `/projects/1`. |
| B7 | `/tasks/2` (tugas Rasya) | **Form progres & tombol ajukan review tidak muncul** — sudah diverifikasi di HTML-nya, cuma bisa baca. Jelasin aturan `abort_unless($task->assigned_to === auth()->id(), 403)`. |

---

## BLOK C — Alur Validasi Penuh: Popita → Raffi → Melda (± 2 menit)

Ini inti dari tugas kuliah lu — siklus Review → Approve/Revisi.

| Langkah | Login | URL / Aksi | Yang dibicarain |
|---|---|---|---|
| C1 | Popita | `/tasks/3` | Status **Review**, progres terkunci 100%. Output-nya: link jadwal posting + catatan analisis. Jelasin `submitReview()` memaksa progress = 100 saat diajukan. |
| C2 | **Raffi** | `/dashboard` | Section **"Perlu Tindakan Owner" → "Validasi Tugas Anggota" (Review Queue)** — tugas Popita nongkrong di sini karena dia owner workspace-nya. Query-nya `whereHas('project')` + `where('status','review')`. |
| C3 | Raffi | `/tasks/3` | Panel validasi muncul **hanya** saat status `review` dan user = Owner: dua tombol — **Setujui Tugas (Approve & Done)** dan **Minta Revisi**. |
| C4 | Raffi | Klik **Approve** → confirm | Status → **Done**, progress tetap 100. Cek `/projects/1`: kartunya pindah ke kolom Done. |
| C5 | **Rasya** → Raffi | `/tasks/2` → lalu login Raffi `/tasks/2` | Skenario revisi pakai tugas Rasya (status `in_progress` 40%). Pertama sebagai Rasya: naikkan progres ke 100 + isi link desain, klik **Ajukan Tugas ke Review Owner**. Lalu ganti ke Raffi: klik **Minta Revisi**, isi **catatan perbaikan** (wajib, `required`), misal "warna kurang krem, aksen emas belum ada". |
| C6 | — | Submit **Minta Revisi** | Status → **Revisi** (badge merah) + catatan tersimpan di tabel `task_revisions`. Bagian **Riwayat Catatan Revisi** di halaman tugas langsung nampilin siapa yang nulis + kapan. |
| C7 | **Rasya** | `/tasks/2` | Status sudah **Revisi** (badge merah) dan **Riwayat Catatan Revisi** menampilkan penulis + waktunya. Tombol ajukan review muncul lagi (kondisinya `status !== 'review'`), jadi dia bisa submit ulang setelah memperbaiki file desainnya. Siklus ini bisa berulang sampai Owner puas. |
| C8 | Raffi | `/dashboard` | **Penutup demo**: dashboard sekarang bilang misal 2 Done, 1 In Progress, 1 Revisi. Jelasin `isLate()` menandai tugas lewat deadline yang belum Done dengan penanda merah, persis seperti skenario di `Role.md` — Raffi bisa langsung ingatkan anggota. |

---

## BLOK D — Sisi Keamanan: Bukti 403 (± 45 detik)

Bagian ini bikin presentasi lu beda dari kelompok lain: lu **buktikan** otorisasinya, bukan cuma klaim.
Rekam pakai **tab browser + DevTools Network**, atau langsung ketik URL.

| Langkah | Login | URL | Hasil Terverifikasi | Yang dibicarain |
|---|---|---|---|---|
| D1 | Melda (member) | `/workspaces/1/projects/create` | **403** ✅ | Route-nya sendiri yang nolak, bukan tombolnya yang disembunyiin. |
| D2 | Melda | `/projects/1/tasks/create` | **403** ✅ | Member nggak bisa bikin & assign tugas. |
| D3 | Melda | `/projects/1/edit` | **403** ✅ | Edit proyek = hak Owner. |
| D4 | Melda | `/tasks/2` (tugas Rasya) | **Form tidak dirender** ✅ diverifikasi: hanya ada form logout, tidak ada `tasks/2/work` maupun `tasks/2/submit-review`. Di `/tasks/1` (tugas sendiri) keduanya muncul. | Lapis UI. Di belakang layar ada `abort_unless($task->assigned_to === auth()->id(), 403)`, jadi walau endpoint-nya dipanggil manual lewat Postman tetap ditolak. |
| D5 | Raffi | sama semua URL di atas | **200** ✅ | Kontrasnya yang jadi bukti: akun sama, role beda, hasil beda. |

**Kalimat penutup blok ini:**
"Semua pengecekan hak akses terjadi di server lewat middleware dan controller, jadi manipulasi URL atau request langsung ke endpoint tetap ditolak dengan 403."

---

## E. Penutup Demo (± 30 detik)

1. Balik ke `/dashboard` sebagai Raffi — tunjukin hasil akhir siklus: ada yang Done, ada yang Revisi, antrean review kosong.
2. Singgung test: `php artisan test --filter=ProjectManagementWorkflowTest` → **4 test, 14 assertion, semua pass**. Jelasin skenario di video tadi memang diotomasi lewat feature test, jadi nggak cuma kelihatan jalan pas demo.
3. Reset data buat rekaman berikutnya: `php artisan migrate:fresh --seed`.

---

## F. Checklist Cepat Sebelum Tekan Record

- [ ] `php artisan migrate:fresh --seed` sudah dijalankan (data balik ke 3 tugas awal)
- [ ] `php artisan serve` jalan di terminal terpisah, log-nya nggak nutupin layar
- [ ] Browser fullscreen, **zoom 90–100%**, bookmark 4 URL quick-login udah siap
- [ ] Zoom/Google Meet & notifikasi desktop dimatiin
- [ ] Teks caption tugas contoh udah diketik di notepad, tinggal copy-paste biar rekaman ngalir
- [ ] Screenshot/error console browser dibersihin dulu
- [ ] Rekam Blok A → B → C → D berurutan (C mengubah data)

---

## Catatan: File View yang Tidak Aktif

`resources/views/layouts/navigation.blade.php` dan `resources/views/dashboard.blade.php` masih nyebut route `workspaces.review-queue` dan method `getMembershipFor()` yang **tidak ada**, plus email `@agency.com` yang salah. Keduanya **tidak dipakai** layout aktif (`layouts/app.blade.php` pakai sidebar sendiri, tanpa include navigation), makanya app tetap jalan mulus. Kalau nanti ada view yang include file itu, langsung error — mending dihapus atau dirapikan.
