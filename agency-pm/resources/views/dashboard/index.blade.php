@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h3 class="mb-4">Halo, {{ auth()->user()->name }} 👋</h3>

{{-- ====== PANEL KHUSUS OWNER: tugas menunggu review ====== --}}
@if ($pendingReviews->isNotEmpty())
<div class="card mb-4 border-warning">
    <div class="card-header bg-warning-subtle">
        <i class="bi bi-hourglass-split"></i> Menunggu Review Anda ({{ $pendingReviews->count() }})
    </div>
    <div class="list-group list-group-flush">
        @foreach ($pendingReviews as $task)
        <a href="{{ route('tasks.show', $task) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $task->title }}</strong>
                <div class="small text-muted">{{ $task->project->name }} &middot; diajukan oleh {{ $task->assignee->name }}</div>
            </div>
            <span class="badge bg-warning text-dark">Perlu direview</span>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- ====== WORKSPACE SAYA ====== --}}
<div class="row mb-4">
    @foreach ($memberships as $m)
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $m->workspace->name }}</h5>
                <span class="badge role-badge-{{ $m->role }}">
                    {{ $m->role === 'owner' ? 'Owner' : $m->jobTitleLabel() }}
                </span>
                <p class="text-muted small mt-2">{{ $m->workspace->agency_name }}</p>
                <a href="{{ route('workspaces.show', $m->workspace) }}" class="btn btn-sm btn-primary">Buka Workspace</a>
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-md-4 mb-3">
        <a href="{{ route('workspaces.create') }}" class="card h-100 text-decoration-none border-dashed d-flex align-items-center justify-content-center" style="border:2px dashed #ccc;">
            <div class="text-center text-muted py-4">
                <i class="bi bi-plus-circle fs-2"></i>
                <div>Buat Workspace Baru</div>
            </div>
        </a>
    </div>
</div>

{{-- ====== TUGAS SAYA (role-specific) ====== --}}
<h5 class="mb-3"><i class="bi bi-list-task"></i> Tugas Saya yang Perlu Dikerjakan</h5>

@if ($myTasks->isEmpty())
    <p class="text-muted">Belum ada tugas aktif untuk Anda saat ini.</p>
@else
<div class="row">
    @foreach ($myTasks as $task)
    <div class="col-md-6 mb-3">
        <div class="card task-card priority-{{ $task->priority }}">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span class="badge role-badge-{{ $task->job_title }}">
                        @switch($task->job_title)
                            @case('content_creator') <i class="bi bi-pencil-square"></i> Content Creator @break
                            @case('graphic_designer') <i class="bi bi-palette"></i> Graphic Designer @break
                            @case('social_media_specialist') <i class="bi bi-megaphone"></i> Social Media Specialist @break
                        @endswitch
                    </span>
                    <span class="badge bg-{{ $task->statusColor() }}">{{ $task->statusLabel() }}</span>
                </div>
                <h6 class="mt-2 mb-1">{{ $task->title }}</h6>
                <div class="small text-muted mb-2">
                    {{ $task->project->name }} &middot; Klien: {{ $task->project->client_name }}
                    @if ($task->deadline)
                        &middot; Deadline: {{ $task->deadline->format('d M Y') }}
                        @if ($task->isLate())<span class="text-danger fw-bold">(Terlambat!)</span>@endif
                    @endif
                </div>
                <div class="progress mb-2" style="height:6px;">
                    <div class="progress-bar" style="width: {{ $task->progress }}%"></div>
                </div>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">Kerjakan</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
