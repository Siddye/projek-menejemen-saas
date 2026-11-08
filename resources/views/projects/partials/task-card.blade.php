@php
    $currentUserId = Auth::id();
    $isAssignee = ($task->assigned_to === $currentUserId);
    $canModifyFull = $isOwnerOrAdmin;
    $isLate = $task->isLate();
@endphp

<div class="bg-white rounded-xl border border-gray-200 hover:border-gray-300 shadow-2xs hover:shadow-sm transition p-3.5 space-y-2.5">

    <!-- Card Header: Priority & Status/Revisions indicator -->
    <div class="flex items-center justify-between gap-1">
        <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $task->priority === 'high' ? 'bg-red-50 text-red-700 border border-red-200' : ($task->priority === 'medium' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-gray-50 text-gray-600 border border-gray-200') }}">
            {{ ucfirst($task->priority) }}
        </span>

        @if ($task->revisions->isNotEmpty())
            <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-rose-50 text-rose-700 rounded border border-rose-200 flex items-center gap-1" title="Pernah mendapat {{ $task->revisions->count() }} kali revisi">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                {{ $task->revisions->count() }}x Revisi
            </span>
        @endif
    </div>

    <!-- Title & Description -->
    <div>
        <h4 class="font-bold text-gray-900 text-xs leading-snug">
            {{ $task->title }}
        </h4>
        @if ($task->description)
            <p class="text-[11px] text-gray-500 mt-1 line-clamp-2 leading-relaxed">
                {{ $task->description }}
            </p>
        @endif
    </div>

    <!-- Active Revision Note (if in revisi state) -->
    @if ($task->status === 'revisi' && $task->revisions->isNotEmpty())
        <div class="p-2 bg-rose-50 border border-rose-200 rounded-lg text-[11px] text-rose-900 space-y-0.5">
            <span class="font-bold text-rose-950 block">Catatan Revisi PM:</span>
            <p class="italic text-rose-800">{{ $task->revisions->first()->note }}</p>
        </div>
    @endif

    <!-- Assignee info & Deadline -->
    <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-[11px]">
        <!-- Assignee Avatar & Name -->
        <div class="flex items-center gap-1.5 min-w-0" title="Ditugaskan kepada {{ $task->assignedUser->name }}">
            <div class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
            </div>
            <span class="truncate font-medium text-gray-700 max-w-[90px]">{{ $task->assignedUser->name }}</span>
        </div>

        <!-- Deadline -->
        <div class="text-right flex-shrink-0">
            <span class="{{ $isLate ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                {{ $task->deadline ? $task->deadline->format('d M') : '-' }}
                @if ($isLate) ! @endif
            </span>
        </div>
    </div>

    <!-- Action Buttons (Workflow & Role-based) -->
    <div class="pt-2 border-t border-gray-100 flex items-center justify-between gap-1 flex-wrap">

        <!-- Column-Specific Primary Actions -->
        @if ($column === 'todo')
            @if ($isAssignee || $isOwnerOrAdmin)
                <form method="POST" action="{{ route('tasks.update-status', $task) }}" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit" class="w-full py-1 px-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-[11px] rounded shadow-2xs transition">
                        Mulai Kerjakan &rarr;
                    </button>
                </form>
            @endif

        @elseif ($column === 'in_progress' || $column === 'revisi')
            @if ($isAssignee || $isOwnerOrAdmin)
                <form method="POST" action="{{ route('tasks.submit-review', $task) }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-1 px-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-[11px] rounded shadow-2xs transition">
                        Ajukan Review &uarr;
                    </button>
                </form>
            @endif

        @elseif ($column === 'review')
            @if ($isOwnerOrAdmin)
                <div class="flex items-center gap-1.5 w-full">
                    <form method="POST" action="{{ route('tasks.approve', $task) }}" class="flex-1">
                        @csrf
                        <button type="submit" onclick="return confirm('Apakah Anda yakin menyetujui tugas ini menjadi Selesai (Done)?')" class="w-full py-1 px-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] rounded shadow-2xs transition text-center">
                            ✓ Approve
                        </button>
                    </form>

                    <button type="button" @click="reviseTaskId = {{ $task->id }}; reviseTaskTitle = '{{ addslashes($task->title) }}'" class="flex-1 py-1 px-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-[10px] rounded shadow-2xs transition text-center">
                        ✕ Revisi
                    </button>
                </div>
            @else
                <div class="w-full text-center text-[10px] text-amber-700 bg-amber-50 py-1 rounded border border-amber-200 font-semibold">
                    Menunggu Verifikasi PM
                </div>
            @endif

        @elseif ($column === 'done')
            <div class="w-full flex items-center justify-center gap-1 text-[11px] text-emerald-700 font-bold py-0.5">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Telah Divalidasi
            </div>
        @endif

        <!-- Owner Delete/Options Menu -->
        @if ($isOwnerOrAdmin)
            <div class="w-full flex items-center justify-end pt-1">
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Hapus tugas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-[10px] text-gray-400 hover:text-red-600 transition">
                        Hapus Tugas
                    </button>
                </form>
            </div>
        @endif
    </div>

</div>

