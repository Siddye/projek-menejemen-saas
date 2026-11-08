@extends('layouts.app')
@section('title', $task->title)

@php
    $isOwner = $task->project->workspace->memberOf(auth()->user())?->isOwner();
    $isAssignee = $task->assigned_to === auth()->id();
    $inputSchema = \App\Models\Task::inputSchema($task->job_title);
    $outputSchema = \App\Models\Task::outputSchema($task->job_title);
@endphp

@section('content')
<a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none small">&larr; {{ $task->project->name }}</a>

<div class="d-flex justify-content-between align-items-start mt-1 mb-3">
    <div>
        <h3 class="mb-1">{{ $task->title }}</h3>
        <span class="badge role-badge-{{ $task->job_title }}">
            @switch($task->job_title)
                @case('content_creator') <i class="bi bi-pencil-square"></i> Content Creator @break
                @case('graphic_designer') <i class="bi bi-palette"></i> Graphic Designer @break
                @case('social_media_specialist') <i class="bi bi-megaphone"></i> Social Media Specialist @break
            @endswitch
        </span>
        <span class="badge bg-{{ $task->statusColor() }}">{{ $task->statusLabel() }}</span>
        <span class="badge bg-light text-dark border">Prioritas: {{ ucfirst($task->priority) }}</span>
    </div>
    <div class="text-end">
        <div class="small text-muted">Ditugaskan ke</div>
        <strong>{{ $task->assignee->name }}</strong>
        @if ($task->deadline)
            <div class="small {{ $task->isLate() ? 'text-danger fw-bold' : 'text-muted' }}">
                Deadline: {{ $task->deadline->format('d M Y') }} @if($task->isLate()) (Terlambat) @endif
            </div>
        @endif
    </div>
</div>

<div class="progress mb-4" style="height:10px;">
    <div class="progress-bar" style="width: {{ $task->progress }}%">{{ $task->progress }}%</div>
</div>

@if ($task->description)
<div class="alert alert-light border mb-3"><strong>Deskripsi:</strong> {{ $task->description }}</div>
@endif

<div class="row">
    {{-- ====== INPUT / BRIEF DARI OWNER (read-only) ====== --}}
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light"><i class="bi bi-inbox"></i> Input / Brief Kerja</div>
            <div class="card-body">
                @forelse ($inputSchema as $key => $field)
                    <div class="mb-2">
                        <div class="small text-muted">{{ $field['label'] }}</div>
                        <div>{{ $task->input_data[$key] ?? '-' }}</div>
                    </div>
                @empty
                    <p class="text-muted small">Tidak ada brief tambahan.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ====== OUTPUT / HASIL KERJA (editable oleh assignee) ====== --}}
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light"><i class="bi bi-upload"></i> Output / Hasil Kerja</div>
            <div class="card-body">
                @if ($isAssignee && !in_array($task->status, ['done']))
                <form method="POST" action="{{ route('tasks.work.update', $task) }}">
                    @csrf @method('PUT')

                    @foreach ($outputSchema as $key => $field)
                    <div class="mb-2">
                        <label class="form-label small">{{ $field['label'] }}</label>
                        @if ($field['type'] === 'textarea')
                            <textarea name="output[{{ $key }}]" class="form-control form-control-sm" rows="3">{{ $task->output_data[$key] ?? '' }}</textarea>
                        @else
                            <input type="{{ $field['type'] === 'number' ? 'number' : ($field['type'] === 'url' ? 'url' : 'text') }}"
                                   name="output[{{ $key }}]" class="form-control form-control-sm"
                                   value="{{ $task->output_data[$key] ?? '' }}">
                        @endif
                    </div>
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label small">Progres Pekerjaan: <span id="progressVal">{{ $task->progress }}</span>%</label>
                        <input type="range" class="form-range" name="progress" min="0" max="100" step="5"
                               value="{{ $task->progress }}" oninput="document.getElementById('progressVal').innerText = this.value">
                    </div>

                    <button class="btn btn-sm btn-outline-primary">Simpan Progres & Hasil</button>
                </form>

                @if ($task->status !== 'review')
                <form method="POST" action="{{ route('tasks.submit-review', $task) }}" class="mt-2" onsubmit="return confirm('Ajukan tugas ini untuk direview Owner?')">
                    @csrf
                    <button class="btn btn-sm btn-success w-100"><i class="bi bi-send"></i> Ajukan untuk Review</button>
                </form>
                @endif

                @else
                    @forelse ($outputSchema as $key => $field)
                        <div class="mb-2">
                            <div class="small text-muted">{{ $field['label'] }}</div>
                            <div>{{ $task->output_data[$key] ?? '-' }}</div>
                        </div>
                    @empty
                        <p class="text-muted small">Belum ada hasil kerja.</p>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ====== VALIDASI OWNER ====== --}}
@if ($isOwner && $task->status === 'review')
<div class="card border-warning mb-4">
    <div class="card-header bg-warning-subtle"><i class="bi bi-check2-square"></i> Validasi Tugas</div>
    <div class="card-body">
        <div class="d-flex gap-2 mb-3">
            <form method="POST" action="{{ route('tasks.approve', $task) }}" onsubmit="return confirm('Setujui tugas ini?')">
                @csrf
                <button class="btn btn-success"><i class="bi bi-check-lg"></i> Setujui (Done)</button>
            </form>
            <button class="btn btn-outline-danger" data-bs-toggle="collapse" data-bs-target="#revisionForm">
                <i class="bi bi-arrow-counterclockwise"></i> Minta Revisi
            </button>
        </div>
        <div class="collapse" id="revisionForm">
            <form method="POST" action="{{ route('tasks.request-revision', $task) }}">
                @csrf
                <textarea name="note" class="form-control mb-2" rows="2" placeholder="Catatan perbaikan yang perlu dilakukan..." required></textarea>
                <button class="btn btn-sm btn-danger">Kirim Permintaan Revisi</button>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ====== RIWAYAT REVISI ====== --}}
@if ($task->revisions->isNotEmpty())
<div class="card">
    <div class="card-header bg-light"><i class="bi bi-clock-history"></i> Riwayat Revisi</div>
    <div class="list-group list-group-flush">
        @foreach ($task->revisions as $rev)
        <div class="list-group-item">
            <div class="small text-muted">{{ $rev->creator->name }} &middot; {{ $rev->created_at->format('d M Y H:i') }}</div>
            <div>{{ $rev->note }}</div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
