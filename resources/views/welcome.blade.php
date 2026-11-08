<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Project Management SaaS') }} — Pemrograman Web III</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans">
    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-extrabold text-xl shadow-md shadow-indigo-200">
                    PM
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 leading-none text-lg">Digital Agency SaaS</h1>
                    <p class="text-xs text-slate-500 font-medium">Platform Manajemen Proyek & Validasi Tugas</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Buka Dashboard &rarr;
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-indigo-600 text-sm font-semibold transition">
                        Masuk (Login)
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 mb-4">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-ping"></span>
                Tugas Besar Pemrograman Web III
            </span>
            <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                Project Management SaaS Platform Berbasis Laravel
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Platform kolaborasi tim agensi digital dengan sistem alur bertingkat: <span class="font-semibold text-slate-900">Workspace &rarr; Proyek &rarr; Tugas</span>, dilengkapi verifikasi status <strong>To Do &rarr; In Progress &rarr; Review &rarr; Revisi / Done</strong>.
            </p>
        </div>

        <!-- Quick Login Demo Box -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 mb-16">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Uji Coba Langsung Berdasarkan Role (Role.md)</h3>
                    <p class="text-sm text-slate-500">Klik salah satu profil anggota kelompok di bawah untuk langsung login dan merasakan hak aksesnya:</p>
                </div>
                <div class="text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg font-mono">
                    Default Password: <span class="font-bold text-slate-800">password</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <!-- Raffi (Owner) -->
                <div class="border border-purple-200 bg-purple-50/40 hover:bg-purple-50 rounded-xl p-5 transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-0.5 text-xs font-extrabold bg-purple-100 text-purple-700 rounded-md uppercase tracking-wider">Owner</span>
                            <span class="text-xs text-slate-400 font-mono">25781097</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Raffi</h4>
                        <p class="text-xs text-purple-700 font-semibold mb-2">Project Manager & Owner</p>
                        <p class="text-xs text-slate-600 mb-4">
                            Kelola workspace "Digital Agency Studio", buat proyek, assign tugas, dan memvalidasi (Approve / Revisi) hasil pekerjaan tim.
                        </p>
                    </div>
                    <a href="{{ route('quick-login', 'raffi@agency.com') }}" class="w-full text-center py-2 px-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold text-xs rounded-lg shadow-sm transition">
                        Masuk sebagai Raffi &rarr;
                    </a>
                </div>

                <!-- Rasya (Graphic Designer) -->
                <div class="border border-emerald-200 bg-emerald-50/40 hover:bg-emerald-50 rounded-xl p-5 transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-0.5 text-xs font-extrabold bg-emerald-100 text-emerald-700 rounded-md uppercase tracking-wider">Member</span>
                            <span class="text-xs text-slate-400 font-mono">25781093</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Rasya Chaniago</h4>
                        <p class="text-xs text-emerald-700 font-semibold mb-2">Graphic Designer</p>
                        <p class="text-xs text-slate-600 mb-4">
                            Bertanggung jawab mendesain 10 visual feed Instagram Kopi Nusantara, update progres dan submit hasil untuk direview Raffi.
                        </p>
                    </div>
                    <a href="{{ route('quick-login', 'rasya@agency.com') }}" class="w-full text-center py-2 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg shadow-sm transition">
                        Masuk sebagai Rasya &rarr;
                    </a>
                </div>

                <!-- Melda (Content Creator) -->
                <div class="border border-blue-200 bg-blue-50/40 hover:bg-blue-50 rounded-xl p-5 transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-0.5 text-xs font-extrabold bg-blue-100 text-blue-700 rounded-md uppercase tracking-wider">Member</span>
                            <span class="text-xs text-slate-400 font-mono">25781091</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Melda Munisa</h4>
                        <p class="text-xs text-blue-700 font-semibold mb-2">Content Creator</p>
                        <p class="text-xs text-slate-600 mb-4">
                            Menyusun ide konten & caption feed Instagram. Pernah melalui siklus revisi dari Raffi hingga akhirnya disetujui (Done).
                        </p>
                    </div>
                    <a href="{{ route('quick-login', 'melda@agency.com') }}" class="w-full text-center py-2 px-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg shadow-sm transition">
                        Masuk sebagai Melda &rarr;
                    </a>
                </div>

                <!-- Popita (Social Media Specialist) -->
                <div class="border border-amber-200 bg-amber-50/40 hover:bg-amber-50 rounded-xl p-5 transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-0.5 text-xs font-extrabold bg-amber-100 text-amber-700 rounded-md uppercase tracking-wider">Member</span>
                            <span class="text-xs text-slate-400 font-mono">25781096</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Popita Sari</h4>
                        <p class="text-xs text-amber-700 font-semibold mb-2">Social Media Specialist</p>
                        <p class="text-xs text-slate-600 mb-4">
                            Mengerjakan jadwal posting editorial 2 minggu (sedang berjalan) dan menyiapkan laporan analisis performa mingguan.
                        </p>
                    </div>
                    <a href="{{ route('quick-login', 'popita@agency.com') }}" class="w-full text-center py-2 px-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs rounded-lg shadow-sm transition">
                        Masuk sebagai Popita &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- System Architecture & Workflow Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">
                    1
                </div>
                <h4 class="font-bold text-lg text-slate-900 mb-2">Workspace & Multi-Tenancy Tim</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Setiap tim agensi memiliki workspace terisolasi. Owner dapat mengundang anggota dengan penugasan role hak akses sistem dan label profesi (Job Title).
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">
                    2
                </div>
                <h4 class="font-bold text-lg text-slate-900 mb-2">Kanban Board & Manajemen Tugas</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Visualisasi tugas dalam 5 status berurutan (To Do, In Progress, Review, Revisi, Done), lengkap dengan prioritas, tenggat waktu (deadline), dan filter tugas.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">
                    3
                </div>
                <h4 class="font-bold text-lg text-slate-900 mb-2">Validasi Tugas & Riwayat Revisi</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Member tidak bisa sembarangan menandai selesai. Tugas harus diajukan ke tahap Review agar Owner dapat memverifikasi kualitas atau memberikan instruksi revisi.
                </p>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        Project Management SaaS Platform &bull; Kelompok: Raffi (25781097), Rasya Chaniago (25781093), Melda Munisa (25781091), Popita Sari (25781096)
    </footer>
</body>
</html>
