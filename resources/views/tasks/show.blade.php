@extends('layouts.app')
@section('title', $task->title)

@php
    $isOwner = $task->project->workspace->memberOf(auth()->user())?->isOwner();
    $isAssignee = $task->assigned_to === auth()->id();
    $inputSchema = \App\Models\Task::inputSchema($task->job_title);
    $outputSchema = \App\Models\Task::outputSchema($task->job_title);
    
    $statusColor = match($task->status) {
        'todo' => '#64748b',
        'in_progress' => '#2563eb',
        'review' => '#f59e0b',
        'revisi' => '#ef4444',
        'done' => '#10b981',
        default => '#64748b',
    };
@endphp

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar mb-3">
    <div>
        <div class="page-subtitle-breadcrumb">
            <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none text-muted">
                &larr; Proyek: {{ $task->project->name }}
            </a>
        </div>
        <h2 class="page-main-heading">
            {{ $task->title }}
        </h2>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="role-pill role-pill-{{ $task->job_title }} px-3 py-1.5" style="font-size: 12px;">
            @switch($task->job_title)
                @case('content_creator') <i class="bi bi-pencil-square"></i> Content Creator @break
                @case('graphic_designer') <i class="bi bi-palette"></i> Graphic Designer @break
                @case('social_media_specialist') <i class="bi bi-megaphone"></i> Social Media Specialist @break
            @endswitch
        </span>

        <span class="badge rounded-pill px-3 py-1.5 text-white fw-bold" style="background: {{ $statusColor }}; font-size: 12px;">
            {{ $task->statusLabel() }}
        </span>
    </div>
</div>

<!-- Task Meta Info Card -->
<div class="clean-glass-card p-4 mb-4" style="border-radius: 22px;">
    <div class="row align-items-center g-3">
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="avatar-circle-mini avatar-c-blue" style="width: 32px; height: 32px; font-size: 13px;">
                    {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-muted" style="font-size: 11px;">Penanggung Jawab Tugas</div>
                    <div class="fw-bold text-dark">{{ $task->assignee->name }}</div>
                </div>
                <span class="text-muted">&bull;</span>
                <div>
                    <div class="text-muted" style="font-size: 11px;">Prioritas</div>
                    <span class="badge {{ $task->priority === 'high' ? 'bg-danger-subtle text-danger' : ($task->priority === 'medium' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-secondary-subtle text-secondary') }} rounded-pill">
                        {{ ucfirst($task->priority) }} Priority
                    </span>
                </div>
                @if ($task->deadline)
                    <span class="text-muted">&bull;</span>
                    <div>
                        <div class="text-muted" style="font-size: 11px;">Tenggat Deadline</div>
                        <span class="{{ $task->isLate() ? 'text-danger fw-bold' : 'text-dark fw-semibold' }}">
                            {{ $task->deadline->format('d M Y') }}
                            @if ($task->isLate()) (Terlambat!) @endif
                        </span>
                    </div>
                @endif
            </div>

            @if ($task->description)
                <p class="text-muted small mb-0 mt-3" style="line-height: 1.6;">
                    <strong>Deskripsi:</strong> {{ $task->description }}
                </p>
            @endif
        </div>

        <div class="col-md-5">
            <div class="p-3 bg-white/80 rounded-4 border border-slate-100">
                <div class="d-flex justify-content-between align-items-center mb-1.5" style="font-size: 12px;">
                    <span class="text-muted fw-semibold">Progres Pengerjaan</span>
                    <span class="fw-bold text-dark fs-6">{{ $task->progress }}%</span>
                </div>
                <div class="step-progress-track">
                    <div class="step-progress-bar" style="height: 8px;">
                        <div class="step-progress-fill" style="width: {{ $task->progress }}%; background: {{ $statusColor }};"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DUAL PANELS: INPUT (Brief) & OUTPUT (Hasil Kerja) -->
<div class="row g-4 mb-4">

    <!-- 1. INPUT / BRIEF DARI OWNER (Left Panel) -->
    <div class="col-lg-6">
        <div class="clean-glass-card h-100 p-4" style="border-radius: 22px;">
            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom border-slate-100">
                <div class="card-thumb-sm thumb-teal" style="width:30px; height:30px;">
                    <i class="bi bi-inbox-fill"></i>
                </div>
                <h5 class="fw-bold text-dark mb-0 fs-6">Brief Kerja (Input dari Owner)</h5>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse ($inputSchema as $key => $field)
                    <div class="p-3 rounded-3 bg-white/70 border border-slate-100">
                        <div class="text-muted small fw-semibold mb-1" style="font-size: 11px;">
                            {{ $field['label'] }}
                        </div>
                        <div class="text-dark fw-bold" style="font-size: 13px;">
                            @if (isset($task->input_data[$key]) && filter_var($task->input_data[$key], FILTER_VALIDATE_URL))
                                <a href="{{ $task->input_data[$key] }}" target="_blank" class="text-primary text-decoration-none d-inline-flex align-items-center gap-1">
                                    {{ $task->input_data[$key] }} <i class="bi bi-box-arrow-up-right small"></i>
                                </a>
                            @else
                                {{ $task->input_data[$key] ?? '-' }}
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">Tidak ada instruksi khusus tambahan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 2. OUTPUT / HASIL KERJA ANGGOTA (Right Panel) -->
    <div class="col-lg-6">
        <div class="clean-glass-card h-100 p-4" style="border-radius: 22px;">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-slate-100">
                <div class="d-flex align-items-center gap-2">
                    <div class="card-thumb-sm thumb-purple" style="width:30px; height:30px;">
                        <i class="bi bi-upload"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0 fs-6">Hasil Kerja (Output Anggota)</h5>
                </div>
                @if ($isAssignee)
                    <span class="badge bg-primary-subtle text-primary rounded-pill small">Dapat Diisi</span>
                @endif
            </div>

            @if ($isAssignee && !in_array($task->status, ['done']))
                <!-- Editable Form for Assignee -->
                <form method="POST" action="{{ route('tasks.work.update', $task) }}">
                    @csrf
                    @method('PUT')

                    <div class="d-flex flex-column gap-3 mb-3">
                        @foreach ($outputSchema as $key => $field)
                            <div>
                                <label class="form-label small fw-bold text-dark mb-1">{{ $field['label'] }}</label>
                                @if ($field['type'] === 'textarea')
                                    <textarea name="output[{{ $key }}]" class="form-control rounded-3 border-slate-200 small" rows="3" placeholder="Tuliskan hasil kerja atau caption di sini...">{{ $task->output_data[$key] ?? '' }}</textarea>
                                @else
                                    <input type="{{ $field['type'] === 'number' ? 'number' : ($field['type'] === 'url' ? 'url' : 'text') }}"
                                           name="output[{{ $key }}]" class="form-control rounded-3 border-slate-200 small"
                                           placeholder="Tautan atau hasil..."
                                           value="{{ $task->output_data[$key] ?? '' }}">
                                @endif
                            </div>
                        @endforeach

                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label small fw-bold text-dark mb-0">Progres Kerja</label>
                                <span class="fw-bold text-primary small"><span id="progressVal">{{ $task->progress }}</span>%</span>
                            </div>
                            <input type="range" class="form-range" name="progress" min="0" max="100" step="5"
                                   value="{{ $task->progress }}" oninput="document.getElementById('progressVal').innerText = this.value">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-outline-dark rounded-pill px-3 font-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Hasil & Progres
                        </button>
                    </div>
                </form>

                @if ($task->status !== 'review')
                    <form method="POST" action="{{ route('tasks.submit-review', $task) }}" class="mt-3 pt-3 border-top border-slate-100" onsubmit="return confirm('Ajukan tugas ini untuk divalidasi oleh Owner?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-theme-primary w-100 justify-content-center">
                            <i class="bi bi-send-fill"></i> Ajukan Tugas ke Review Owner &uarr;
                        </button>
                    </form>
                @endif
            @else
                <!-- Read-Only View of Output -->
                <div class="d-flex flex-column gap-3">
                    @forelse ($outputSchema as $key => $field)
                        <div class="p-3 rounded-3 bg-white/70 border border-slate-100">
                            <div class="text-muted small fw-semibold mb-1" style="font-size: 11px;">
                                {{ $field['label'] }}
                            </div>
                            <div class="text-dark fw-bold" style="font-size: 13px;">
                                @if (isset($task->output_data[$key]) && filter_var($task->output_data[$key], FILTER_VALIDATE_URL))
                                    <a href="{{ $task->output_data[$key] }}" target="_blank" class="text-primary text-decoration-none d-inline-flex align-items-center gap-1">
                                        {{ $task->output_data[$key] }} <i class="bi bi-box-arrow-up-right small"></i>
                                    </a>
                                @else
                                    {{ $task->output_data[$key] ?? '-' }}
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">Belum ada output pekerjaan.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>

</div>

<!-- OWNER VALIDATION ACTION CARD (When status is review) -->
@if ($isOwner && $task->status === 'review')
    <div class="clean-glass-card p-4 mb-4" style="border-radius: 22px; border: 2px solid rgba(245, 158, 11, 0.4);">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <div class="card-thumb-sm thumb-amber" style="width:32px; height:32px;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0 fs-6">Validasi Tugas oleh Owner (Raffi)</h5>
                    <div class="text-muted small">Tugas ini menunggu persetujuan Anda sebelum dinyatakan selesai.</div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 align-items-center flex-wrap">
            <form method="POST" action="{{ route('tasks.approve', $task) }}" onsubmit="return confirm('Apakah Anda yakin menyetujui tugas ini menjadi Selesai (Done)?')">
                @csrf
                <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold small">
                    <i class="bi bi-check2-circle me-1"></i> Setujui Tugas (Approve & Done)
                </button>
            </form>

            <button class="btn btn-outline-danger rounded-pill px-4 py-2 fw-bold small" data-bs-toggle="collapse" data-bs-target="#revisionBox">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Minta Revisi...
            </button>
        </div>

        <div class="collapse mt-3" id="revisionBox">
            <div class="p-3 rounded-3 bg-danger-subtle border border-danger-subtle">
                <form method="POST" action="{{ route('tasks.request-revision', $task) }}">
                    @csrf
                    <label class="form-label small fw-bold text-danger mb-1">Catatan Perbaikan untuk {{ $task->assignee->name }}:</label>
                    <textarea name="note" class="form-control rounded-3 small mb-2" rows="2" placeholder="Contoh: Perbaiki caption slide 3 dan 5 agar tone of voice lebih santai..." required></textarea>
                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                        Kirim Instruksi Revisi
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- REVISION HISTORY CARD -->
@if ($task->revisions->isNotEmpty())
    <div class="clean-glass-card p-4" style="border-radius: 22px;">
        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom border-slate-100">
            <div class="card-thumb-sm thumb-orange" style="width:28px; height:28px;">
                <i class="bi bi-clock-history"></i>
            </div>
            <h5 class="fw-bold text-dark mb-0 fs-6">Riwayat Catatan Revisi ({{ $task->revisions->count() }})</h5>
        </div>

        <div class="d-flex flex-column gap-2.5">
            @foreach ($task->revisions as $rev)
                <div class="p-3 rounded-3 bg-white/70 border border-slate-100 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="small fw-bold text-dark mb-0.5">{{ $rev->note }}</div>
                        <div class="text-muted" style="font-size: 11px;">Oleh {{ $rev->creator->name }} &bull; {{ $rev->created_at->translatedFormat('d M Y, H:i') }}</div>
                    </div>
                    <span class="badge bg-danger-subtle text-danger rounded-pill small">Catatan Revisi</span>
                </div>
            @endforeach
        </div>
    </div>
@endif

@endsection
