<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ route('workspaces.show', $workspace) }}" class="text-xs text-indigo-600 hover:underline">&larr; Workspace: {{ $workspace->name }}</a>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('Antrean Review & Validasi Tugas') }}
                    <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-amber-100 text-amber-900">
                        {{ $tasksInReview->count() }} Menunggu
                    </span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">Halaman khusus Project Manager / Owner untuk memeriksa dan memutuskan persetujuan (Approve) atau revisi tugas.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" x-data="{ reviseTaskId: null, reviseTaskTitle: '' }">

        <!-- 1. Review Queue Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Tugas Berstatus 'Review' (Menunggu Keputusan)
                </h3>
            </div>

            @if ($tasksInReview->isEmpty())
                <div class="bg-white rounded-2xl p-10 text-center border border-dashed border-gray-300">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h4 class="font-bold text-sm text-gray-800">Semua Beres! Tidak Ada Antrean Review</h4>
                    <p class="text-xs text-gray-400 mt-1">Seluruh tugas yang diajukan oleh anggota tim telah diproses.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach ($tasksInReview as $task)
                        <div class="bg-white rounded-2xl border border-amber-200 shadow-xs p-5 flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-100 text-amber-800">
                                        Status: Review
                                    </span>
                                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded {{ $task->priority === 'high' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ ucfirst($task->priority) }} Priority
                                    </span>
                                </div>

                                <div>
                                    <span class="text-xs font-semibold text-indigo-600 block mb-0.5">{{ $task->project->name }}</span>
                                    <h4 class="font-bold text-base text-gray-900">{{ $task->title }}</h4>
                                    @if ($task->description)
                                        <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">{{ $task->description }}</p>
                                    @endif
                                </div>

                                <div class="p-3 bg-gray-50 rounded-xl text-xs space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-500">Anggota Penanggung Jawab:</span>
                                        <strong class="text-gray-900">{{ $task->assignedUser->name }}</strong>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-500">Tenggat Waktu:</span>
                                        <span class="{{ $task->isLate() ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                            {{ $task->deadline ? $task->deadline->translatedFormat('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </div>

                                @if ($task->revisions->isNotEmpty())
                                    <div class="text-[11px] text-gray-500">
                                        <span class="font-semibold text-gray-700">Riwayat Revisi Sebelumnya ({{ $task->revisions->count() }}):</span>
                                        <ul class="list-disc list-inside mt-1 space-y-0.5 text-gray-600">
                                            @foreach ($task->revisions->take(2) as $rev)
                                                <li>"{{ $rev->note }}" <span class="text-gray-400">({{ $rev->created_at->diffForHumans() }})</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            @if ($isOwnerOrAdmin)
                                <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-end gap-2">
                                    <!-- Request Revision Trigger -->
                                    <button type="button" @click="reviseTaskId = {{ $task->id }}; reviseTaskTitle = '{{ addslashes($task->title) }}'" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs rounded-lg shadow-2xs transition">
                                        ✕ Minta Revisi...
                                    </button>

                                    <!-- Approve Button -->
                                    <form method="POST" action="{{ route('tasks.approve', $task) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Setujui tugas ini menjadi Selesai (Done)?')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-2xs transition">
                                            ✓ Setujui (Done)
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- 2. Tasks Currently in Revision -->
        <div class="pt-6 border-t border-gray-200">
            <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                Tugas Berstatus 'Revisi' (Sedang Diperbaiki Anggota)
            </h3>

            @if ($tasksInRevision->isEmpty())
                <div class="bg-white rounded-2xl p-6 text-center text-xs text-gray-400 border border-gray-200">
                    Tidak ada tugas yang sedang dalam tahap revisi.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($tasksInRevision as $task)
                        <div class="bg-white rounded-2xl border border-rose-200 shadow-xs p-4 space-y-2.5">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-rose-100 text-rose-800">
                                    Sedang Diperbaiki
                                </span>
                                <span class="text-xs text-gray-400">{{ $task->project->name }}</span>
                            </div>

                            <h4 class="font-bold text-sm text-gray-900">{{ $task->title }}</h4>

                            @if ($task->revisions->isNotEmpty())
                                <div class="p-2.5 bg-rose-50 border border-rose-200 rounded-lg text-xs text-rose-900">
                                    <strong class="font-semibold text-rose-950">Catatan Perbaikan:</strong>
                                    <p class="mt-0.5 text-rose-800">{{ $task->revisions->first()->note }}</p>
                                </div>
                            @endif

                            <div class="flex items-center justify-between text-xs text-gray-500 pt-1">
                                <span>Anggota: <strong class="text-gray-700">{{ $task->assignedUser->name }}</strong></span>
                                <a href="{{ route('projects.show', $task->project_id) }}" class="text-indigo-600 hover:underline font-semibold">
                                    Lihat di Proyek &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Revision Modal -->
        <div x-show="reviseTaskId !== null" @click.away="reviseTaskId = null" class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                    <div>
                        <h4 class="font-extrabold text-base text-gray-900">Permintaan Revisi Tugas</h4>
                        <p class="text-xs text-gray-500 mt-0.5" x-text="reviseTaskTitle"></p>
                    </div>
                    <button type="button" @click="reviseTaskId = null" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'/tasks/' + reviseTaskId + '/request-revision'" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="q_rev_note" :value="__('Catatan Perbaikan dari Owner')" />
                        <textarea id="q_rev_note" name="note" rows="4" required placeholder="Tuliskan catatan detail yang harus diperbaiki anggota tim..." class="block mt-1 w-full text-xs border-gray-300 rounded-lg shadow-xs focus:ring-rose-500 focus:border-rose-500"></textarea>
                        <p class="text-[11px] text-gray-400 mt-1">Catatan ini akan tersimpan di riwayat revisi dan tampil di dashboard anggota terkait.</p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                        <button type="button" @click="reviseTaskId = null" class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                        <button type="submit" class="px-4 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-lg shadow-xs">
                            Kirim Instruksi Revisi
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>

