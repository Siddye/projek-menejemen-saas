<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">Workspace Aktif</span>
                    <span class="text-gray-300">&bull;</span>
                    @if ($userRole === 'owner')
                        <span class="px-2 py-0.5 text-[11px] font-extrabold bg-purple-100 text-purple-700 rounded-full">
                            Role: Owner / Project Manager
                        </span>
                    @else
                        <span class="px-2 py-0.5 text-[11px] font-extrabold bg-emerald-100 text-emerald-700 rounded-full">
                            Role: Member ({{ $jobTitle ?? 'Team Member' }})
                        </span>
                    @endif
                </div>
                <h2 class="font-extrabold text-2xl text-gray-900 leading-tight flex items-center gap-3">
                    {{ $currentWorkspace ? $currentWorkspace->name : 'Tidak Ada Workspace' }}
                </h2>
            </div>

            <!-- Workspace Switcher & Actions -->
            <div class="flex items-center gap-3">
                @if ($workspaces->count() > 1)
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center">
                        <select name="workspace_id" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($workspaces as $ws)
                                <option value="{{ $ws->id }}" {{ $currentWorkspace && $currentWorkspace->id == $ws->id ? 'selected' : '' }}>
                                    {{ $ws->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif

                @if ($currentWorkspace)
                    <a href="{{ route('workspaces.show', $currentWorkspace) }}" class="inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 shadow-xs transition">
                        <svg class="w-4 h-4 me-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Detail Workspace
                    </a>

                    @if ($userRole === 'owner' || $userRole === 'admin')
                        <a href="{{ route('workspaces.projects.create', $currentWorkspace) }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-xs transition">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Proyek
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if (!$currentWorkspace)
            <!-- Empty state when no workspace exists -->
            <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Anda Belum Memiliki Workspace</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto mb-6">Mulai dengan membuat workspace untuk tim atau agensi Anda, lalu undang anggota dan kelola proyek bersama.</p>
                <a href="{{ route('workspaces.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                    + Buat Workspace Pertama
                </a>
            </div>
        @else

            <!-- Role Notification Notice -->
            @if ($userRole === 'owner')
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-600 text-white flex items-center justify-center flex-shrink-0 font-bold text-xs mt-0.5">
                            PM
                        </div>
                        <div>
                            <h4 class="font-bold text-purple-950 text-sm">Mode Project Manager & Owner (Raffi)</h4>
                            <p class="text-xs text-purple-800 leading-relaxed mt-0.5">
                                Anda memiliki otoritas penuh: membuat proyek, assign tugas kepada anggota (Melda, Rasya, Popita), memeriksa hasil pekerjaan di antrean review, serta menyetujui (Approve) atau mengembalikan tugas dengan catatan revisi.
                            </p>
                        </div>
                    </div>
                    @if ($stats['review'] > 0)
                        <a href="{{ route('workspaces.review-queue', $currentWorkspace) }}" class="flex-shrink-0 px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-lg shadow-xs transition">
                            Periksa {{ $stats['review'] }} Tugas Review &rarr;
                        </a>
                    @endif
                </div>
            @else
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 font-bold text-xs mt-0.5">
                            TM
                        </div>
                        <div>
                            <h4 class="font-bold text-emerald-950 text-sm">Mode Anggota Tim: {{ Auth::user()->name }} ({{ $jobTitle ?? 'Member' }})</h4>
                            <p class="text-xs text-emerald-800 leading-relaxed mt-0.5">
                                Anda bertugas mengerjakan tugas yang di-assign kepada Anda. Ubah status tugas ke <span class="font-bold">In Progress</span> saat mulai bekerja, lalu ajukan ke <span class="font-bold">Review</span> agar diperiksa oleh Project Manager.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- KPI Summary Cards (Tahap 7) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                <!-- Total -->
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Tugas</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl sm:text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</span>
                        <span class="text-xs font-medium text-gray-400">{{ $stats['active_projects'] }} Proyek</span>
                    </div>
                </div>

                <!-- Done -->
                <div class="bg-white p-4 rounded-xl border border-emerald-200 bg-emerald-50/20 shadow-xs">
                    <div class="text-xs font-semibold text-emerald-700 uppercase tracking-wider flex items-center justify-between">
                        <span>Selesai (Done)</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl sm:text-3xl font-extrabold text-emerald-700">{{ $stats['done'] }}</span>
                        <span class="text-xs font-semibold text-emerald-600">
                            {{ $stats['total'] > 0 ? round(($stats['done'] / $stats['total']) * 100) : 0 }}%
                        </span>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="bg-white p-4 rounded-xl border border-blue-200 bg-blue-50/20 shadow-xs">
                    <div class="text-xs font-semibold text-blue-700 uppercase tracking-wider flex items-center justify-between">
                        <span>In Progress</span>
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    </div>
                    <div class="mt-2">
                        <span class="text-2xl sm:text-3xl font-extrabold text-blue-700">{{ $stats['in_progress'] }}</span>
                    </div>
                </div>

                <!-- Review Queue -->
                <div class="bg-white p-4 rounded-xl border border-amber-200 bg-amber-50/30 shadow-xs {{ $stats['review'] > 0 ? 'ring-2 ring-amber-400 ring-offset-1' : '' }}">
                    <div class="text-xs font-semibold text-amber-800 uppercase tracking-wider flex items-center justify-between">
                        <span>Review</span>
                        @if ($stats['review'] > 0)
                            <span class="px-1.5 py-0.5 text-[10px] bg-amber-200 text-amber-900 font-bold rounded-full animate-pulse">Perlu Cek</span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <span class="text-2xl sm:text-3xl font-extrabold text-amber-800">{{ $stats['review'] }}</span>
                    </div>
                </div>

                <!-- Revisi -->
                <div class="bg-white p-4 rounded-xl border border-rose-200 bg-rose-50/20 shadow-xs">
                    <div class="text-xs font-semibold text-rose-700 uppercase tracking-wider flex items-center justify-between">
                        <span>Revisi</span>
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    </div>
                    <div class="mt-2">
                        <span class="text-2xl sm:text-3xl font-extrabold text-rose-700">{{ $stats['revisi'] }}</span>
                    </div>
                </div>

                <!-- Overdue / Terlambat -->
                <div class="bg-white p-4 rounded-xl border border-red-200 bg-red-50/30 shadow-xs">
                    <div class="text-xs font-semibold text-red-700 uppercase tracking-wider flex items-center justify-between">
                        <span>Terlambat</span>
                        @if ($stats['overdue'] > 0)
                            <span class="px-1.5 py-0.5 text-[10px] bg-red-200 text-red-900 font-bold rounded-full">Warning</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <span class="text-2xl sm:text-3xl font-extrabold text-red-700">{{ $stats['overdue'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Two-Column Main Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column (2 Cols): Review Queue & My Tasks -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Special Review Queue Widget (Crucial for Owner / PM) -->
                    @if ($reviewQueueTasks->count() > 0)
                        <div class="bg-white rounded-2xl border border-amber-200 shadow-xs overflow-hidden">
                            <div class="p-5 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-200 flex items-center justify-between">
                                <div>
                                    <h3 class="font-extrabold text-gray-900 text-base flex items-center gap-2">
                                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Antrean Review Tugas Membutuhkan Validasi ({{ $reviewQueueTasks->count() }})
                                    </h3>
                                    <p class="text-xs text-gray-600 mt-0.5">Tugas berikut telah diselesaikan oleh anggota dan menunggu verifikasi Owner.</p>
                                </div>
                                <a href="{{ route('workspaces.review-queue', $currentWorkspace) }}" class="text-xs font-bold text-amber-900 hover:underline">
                                    Buka Halaman Antrean &rarr;
                                </a>
                            </div>

                            <div class="divide-y divide-gray-100">
                                @foreach ($reviewQueueTasks as $rt)
                                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 transition">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-100 text-amber-800">Menunggu Review</span>
                                                <span class="text-xs font-semibold text-gray-500">{{ $rt->project->name }}</span>
                                            </div>
                                            <h4 class="font-bold text-gray-900 text-sm">{{ $rt->title }}</h4>
                                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                                <span>Dikerjakan oleh: <strong class="text-gray-700">{{ $rt->assignedUser->name }}</strong></span>
                                                <span>&bull;</span>
                                                <span>Deadline: {{ $rt->deadline ? $rt->deadline->translatedFormat('d M Y') : '-' }}</span>
                                            </div>
                                        </div>

                                        @if ($userRole === 'owner' || $userRole === 'admin')
                                            <!-- Action Buttons for Owner -->
                                            <div class="flex items-center gap-2 flex-shrink-0" x-data="{ openRevise: false }">
                                                <!-- Approve Form -->
                                                <form method="POST" action="{{ route('tasks.approve', $rt) }}">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Apakah Anda yakin menyetujui tugas ini menjadi Selesai (Done)?')" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs transition">
                                                        ✓ Setujui (Done)
                                                    </button>
                                                </form>

                                                <!-- Trigger Revision Modal -->
                                                <button type="button" @click="openRevise = !openRevise" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs rounded-lg shadow-xs transition">
                                                    Minta Revisi...
                                                </button>

                                                <!-- Revision Inline Popover -->
                                                <div x-show="openRevise" @click.away="openRevise = false" class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4" style="display: none;">
                                                    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl">
                                                        <h4 class="font-extrabold text-base text-gray-900 mb-2">Instruksi Catatan Revisi</h4>
                                                        <p class="text-xs text-gray-500 mb-4">Tuliskan perbaikan yang harus dilakukan oleh {{ $rt->assignedUser->name }}:</p>

                                                        <form method="POST" action="{{ route('tasks.request-revision', $rt) }}">
                                                            @csrf
                                                            <textarea name="note" rows="3" required placeholder="Contoh: Perbaiki tone caption pada feed 3 dan 5 agar lebih santai..." class="w-full text-xs rounded-lg border-gray-300 focus:ring-rose-500 focus:border-rose-500 mb-4"></textarea>

                                                            <div class="flex items-center justify-end gap-2">
                                                                <button type="button" @click="openRevise = false" class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                                                                <button type="submit" class="px-4 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg shadow-xs">Kirim Revisi</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ route('projects.show', $rt->project_id) }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                                                Lihat di Proyek &rarr;
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Section: My Assigned Tasks -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <h3 class="font-extrabold text-gray-900 text-base">Tugas Saya ({{ $myTasks->count() }})</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Daftar tugas yang ditugaskan kepada Anda di workspace ini.</p>
                            </div>
                            <span class="text-xs font-semibold text-gray-500">{{ Auth::user()->name }}</span>
                        </div>

                        @if ($myTasks->isEmpty())
                            <div class="p-8 text-center text-gray-400 text-xs">
                                Tidak ada tugas yang sedang ditugaskan kepada Anda saat ini.
                            </div>
                        @else
                            <div class="divide-y divide-gray-100">
                                @foreach ($myTasks as $task)
                                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 transition">
                                        <div class="space-y-1.5 max-w-lg">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <!-- Status Badge -->
                                                @if ($task->status === 'done')
                                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-emerald-100 text-emerald-800">Done</span>
                                                @elseif ($task->status === 'review')
                                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-amber-100 text-amber-800">Sedang Direview</span>
                                                @elseif ($task->status === 'revisi')
                                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-rose-100 text-rose-800 animate-pulse">Perlu Revisi</span>
                                                @elseif ($task->status === 'in_progress')
                                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-blue-100 text-blue-800">In Progress</span>
                                                @else
                                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-gray-100 text-gray-700">To Do</span>
                                                @endif

                                                <!-- Priority Badge -->
                                                <span class="px-1.5 py-0.5 text-[10px] font-semibold rounded {{ $task->priority === 'high' ? 'bg-red-50 text-red-700 border border-red-200' : ($task->priority === 'medium' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-gray-50 text-gray-600 border border-gray-200') }}">
                                                    {{ ucfirst($task->priority) }} Priority
                                                </span>

                                                <span class="text-xs text-gray-400 font-medium">{{ $task->project->name }}</span>
                                            </div>

                                            <h4 class="font-bold text-gray-900 text-sm leading-snug">{{ $task->title }}</h4>

                                            @if ($task->description)
                                                <p class="text-xs text-gray-600 line-clamp-2">{{ $task->description }}</p>
                                            @endif

                                            <!-- Show latest revision note if in revisi status -->
                                            @if ($task->status === 'revisi' && $task->revisions->isNotEmpty())
                                                <div class="p-2.5 rounded-lg bg-rose-50 border border-rose-200 text-xs text-rose-900 mt-2">
                                                    <strong class="font-bold text-rose-950">Catatan Revisi dari {{ $task->revisions->first()->creator->name }}:</strong>
                                                    <p class="mt-0.5">{{ $task->revisions->first()->note }}</p>
                                                </div>
                                            @endif

                                            <div class="flex items-center gap-3 text-[11px] text-gray-500 pt-1">
                                                <span class="{{ $task->isLate() ? 'text-red-600 font-bold' : '' }}">
                                                    Tenggat: {{ $task->deadline ? $task->deadline->translatedFormat('d M Y') : '-' }}
                                                    @if ($task->isLate()) (Terlambat!) @endif
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Member Action Buttons -->
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            @if ($task->status === 'todo')
                                                <form method="POST" action="{{ route('tasks.update-status', $task) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="in_progress">
                                                    <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg shadow-xs transition">
                                                        Mulai Kerjakan &rarr;
                                                    </button>
                                                </form>
                                            @elseif ($task->status === 'in_progress' || $task->status === 'revisi')
                                                <form method="POST" action="{{ route('tasks.submit-review', $task) }}">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-lg shadow-xs transition">
                                                        Ajukan Review &uarr;
                                                    </button>
                                                </form>
                                            @elseif ($task->status === 'review')
                                                <span class="text-xs text-amber-700 italic font-medium">Menunggu persetujuan Owner</span>
                                            @elseif ($task->status === 'done')
                                                <span class="text-xs text-emerald-600 font-bold flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                    Selesai
                                                </span>
                                            @endif

                                            <a href="{{ route('projects.show', $task->project_id) }}" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Lihat di Project Board">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Active Projects List -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-extrabold text-gray-900 text-base">Proyek di Workspace ({{ $projects->count() }})</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Pantau progres pengerjaan proyek dan akses Kanban Board masing-masing.</p>
                            </div>
                            @if ($userRole === 'owner' || $userRole === 'admin')
                                <a href="{{ route('workspaces.projects.create', $currentWorkspace) }}" class="text-xs font-bold text-indigo-600 hover:underline">
                                    + Tambah Proyek
                                </a>
                            @endif
                        </div>

                        <div class="space-y-4">
                            @forelse ($projects as $proj)
                                <div class="p-4 rounded-xl border border-gray-200 hover:border-indigo-300 transition bg-gray-50/30">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                        <div>
                                            <a href="{{ route('projects.show', $proj) }}" class="font-bold text-gray-900 hover:text-indigo-600 text-base">
                                                {{ $proj->name }}
                                            </a>
                                            <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $proj->description }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <span class="text-xs font-bold text-indigo-600">{{ $proj->progress_percent }}% Selesai</span>
                                            <div class="text-[11px] text-gray-400">Tenggat: {{ $proj->deadline ? $proj->deadline->translatedFormat('d M Y') : '-' }}</div>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3 overflow-hidden">
                                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ $proj->progress_percent }}%"></div>
                                    </div>

                                    <div class="flex items-center justify-between text-xs text-gray-500 pt-1 border-t border-gray-100">
                                        <div class="flex items-center gap-3">
                                            <span><strong>{{ $proj->tasks->count() }}</strong> Total Tugas</span>
                                            <span>&bull;</span>
                                            <span><strong>{{ $proj->tasks->where('status', 'done')->count() }}</strong> Selesai</span>
                                            <span>&bull;</span>
                                            <span><strong>{{ $proj->tasks->where('status', 'review')->count() }}</strong> Review</span>
                                        </div>
                                        <a href="{{ route('projects.show', $proj) }}" class="font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                            Buka Board &rarr;
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-xs text-gray-400">
                                    Belum ada proyek di workspace ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column (1 Col): Team Workload & Case Study Info -->
                <div class="space-y-6">

                    <!-- Team Workload (Beban Kerja Tim) -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-extrabold text-gray-900 text-base">Beban Kerja Anggota Tim</h3>
                            <a href="{{ route('workspaces.show', $currentWorkspace) }}" class="text-xs text-indigo-600 hover:underline font-semibold">
                                Kelola &rarr;
                            </a>
                        </div>

                        <div class="space-y-4">
                            @foreach ($members as $member)
                                <div class="p-3 rounded-xl border border-gray-100 bg-gray-50/50">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-xs text-gray-900">{{ $member->user->name }}</h4>
                                                <span class="text-[10px] text-gray-500 font-medium">{{ $member->job_title ?? ucfirst($member->role) }}</span>
                                            </div>
                                        </div>
                                        <span class="px-1.5 py-0.5 text-[10px] font-bold rounded {{ $member->role === 'owner' ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ ucfirst($member->role) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-4 gap-1 text-center text-[10px] pt-2 border-t border-gray-100">
                                        <div class="bg-white p-1 rounded border border-gray-100">
                                            <div class="font-bold text-gray-800">{{ $member->total_tasks }}</div>
                                            <div class="text-gray-400">Total</div>
                                        </div>
                                        <div class="bg-white p-1 rounded border border-gray-100">
                                            <div class="font-bold text-blue-600">{{ $member->in_progress_tasks }}</div>
                                            <div class="text-gray-400">Proses</div>
                                        </div>
                                        <div class="bg-white p-1 rounded border border-gray-100">
                                            <div class="font-bold text-amber-600">{{ $member->review_tasks }}</div>
                                            <div class="text-gray-400">Review</div>
                                        </div>
                                        <div class="bg-white p-1 rounded border border-gray-100">
                                            <div class="font-bold text-emerald-600">{{ $member->done_tasks }}</div>
                                            <div class="text-gray-400">Done</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Role Mapping Info Box (as per MD Perencanaan) -->
                    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 text-white rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-xs uppercase font-extrabold text-indigo-300 tracking-wider">Studi Kasus Role.md</span>
                        </div>
                        <h4 class="font-bold text-base text-white mb-2">Campaign Media Sosial &bull; Kopi Nusantara</h4>
                        <p class="text-xs text-indigo-200 leading-relaxed mb-4">
                            Studi kasus tim agensi 4 orang mengelola peluncuran produk kopi. Melda (konten), Rasya (desain), Popita (sosmed), dengan validasi ketat oleh Raffi (PM).
                        </p>

                        <div class="space-y-2 text-xs border-t border-indigo-800/80 pt-3">
                            <div class="flex items-center justify-between text-indigo-200">
                                <span>Alur Validasi:</span>
                                <span class="font-bold text-white">To Do &rarr; Review &rarr; Done</span>
                            </div>
                            <div class="flex items-center justify-between text-indigo-200">
                                <span>Kontrol Akses:</span>
                                <span class="font-bold text-white">Policy & Role Middleware</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        @endif

    </div>
</x-app-layout>
