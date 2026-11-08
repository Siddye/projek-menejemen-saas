@extends('layouts.app')
@section('title', 'Dashboard')

@php
    $primaryWorkspace = $memberships->first()?->workspace;
    $primaryProject = $primaryWorkspace?->projects->first();
    $isOwner = $memberships->where('role', 'owner')->isNotEmpty();
@endphp

@section('content')

<!-- Action Bar (Title & Right Controls like the screenshot) -->
<div class="content-action-bar">
    <div>
        <div class="page-subtitle-breadcrumb">Dashboard</div>
        <h2 class="page-main-heading">
            <i class="bi bi-arrow-left text-muted fs-4 d-none d-sm-inline"></i> Proyek & Kampanye Tim
        </h2>
    </div>

    <div class="d-flex align-items-center gap-2">
        <!-- View Toggle Buttons (Grid / List / Filter like in photo) -->
        <div class="btn-group bg-white p-1 rounded-3 border shadow-xs" role="group">
            <button type="button" class="btn btn-sm btn-light active rounded-2 px-2.5 py-1 text-dark" title="Grid View">
                <i class="bi bi-grid-fill"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light rounded-2 px-2.5 py-1 text-muted" title="List View">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <button class="btn btn-sm btn-white bg-white border rounded-3 px-3 py-1.5 shadow-xs text-muted" title="Filter Proyek">
            <i class="bi bi-funnel"></i>
        </button>

        <!-- Create Button (Navy/Teal Pill Button like photo) -->
        @if ($isOwner && $primaryWorkspace)
            <a href="{{ route('projects.create', $primaryWorkspace) }}" class="btn-theme-primary">
                <i class="bi bi-plus-square"></i> Buat Campaign
            </a>
        @else
            <a href="{{ route('workspaces.create') }}" class="btn-theme-primary">
                <i class="bi bi-plus-square"></i> Buat Workspace
            </a>
        @endif
    </div>
</div>

<!-- TOP ROW: 2 Large Featured Cards (as shown in the top half of the photo) -->
<div class="row g-4 mb-5">

    <!-- Card 1: Featured Active Campaign -->
    @if ($primaryProject)
        <div class="col-lg-6">
            <div class="clean-glass-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <!-- Top Meta -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="small fw-semibold text-muted">
                            <span class="text-primary fw-bold">{{ $primaryProject->tasks->count() }} Tugas</span> &bull; 
                            Klien: <span class="text-dark fw-bold">{{ $primaryProject->client_name }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="status-dot dot-green" title="Sedang Berjalan"></span>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 small">
                                    <li><a class="dropdown-item" href="{{ route('projects.show', $primaryProject) }}">Buka Board Proyek</a></li>
                                    @if ($isOwner)
                                        <li><a class="dropdown-item" href="{{ route('tasks.create', $primaryProject) }}">+ Tambah Tugas</a></li>
                                        <li><a class="dropdown-item" href="{{ route('projects.edit', $primaryProject) }}">Edit Proyek</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Middle: Gradient Thumbnail + Title + Brief -->
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="card-gradient-thumb thumb-pink">
                            <i class="bi bi-cup-hot-fill"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px; letter-spacing: -0.4px;">
                                <a href="{{ route('projects.show', $primaryProject) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ $primaryProject->name }}
                                </a>
                            </h4>
                            <p class="text-muted small mb-0" style="line-height: 1.5;">
                                {{ Str::limit($primaryProject->brief ?: 'Kampanye peluncuran produk baru tim agensi.', 110) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer (Progress, Trainees / Team, Manager) -->
                <div class="pt-3 border-top border-slate-100 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                    <!-- Progress Bar Track -->
                    <div style="min-width: 130px;">
                        <div class="d-flex justify-content-between text-muted small fw-semibold mb-1" style="font-size: 11px;">
                            <span>Progres</span>
                            <span class="text-dark fw-bold">{{ $primaryProject->progressPercent() }}%</span>
                        </div>
                        <div class="step-progress-track">
                            <div class="step-progress-bar">
                                <div class="step-progress-fill" style="width: {{ $primaryProject->progressPercent() }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Team Avatars Overlap -->
                    <div>
                        <div class="text-muted small fw-semibold mb-1" style="font-size: 11px;">Tim Kerja</div>
                        <div class="avatar-group-overlap">
                            <div class="avatar-circle-mini avatar-c-blue" title="Raffi">R</div>
                            <div class="avatar-circle-mini avatar-c-purple" title="Rasya">R</div>
                            <div class="avatar-circle-mini avatar-c-amber" title="Melda">M</div>
                            <div class="avatar-circle-mini avatar-c-teal" title="Popita">P</div>
                        </div>
                    </div>

                    <!-- Project Manager -->
                    <div>
                        <div class="text-muted small fw-semibold mb-1" style="font-size: 11px;">Project Manager</div>
                        <div class="d-flex align-items-center gap-1.5 small fw-bold text-dark">
                            <div class="avatar-circle-mini avatar-c-gray" style="width:20px; height:20px; font-size:9px;">R</div>
                            <span>Raffi (Owner)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Card 2: Featured Review Queue / Workspace Status -->
    <div class="col-lg-6">
        @if ($pendingReviews->isNotEmpty())
            <!-- Highlight Pending Reviews for Owner -->
            <div class="clean-glass-card h-100 d-flex flex-column justify-content-between" style="border-color: rgba(245, 158, 11, 0.4);">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="small fw-semibold text-warning-emphasis">
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill">
                                Perlu Tindakan Owner
                            </span> &bull; {{ $pendingReviews->count() }} Tugas Menunggu
                        </div>
                        <span class="status-dot dot-amber"></span>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="card-gradient-thumb thumb-orange">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px; letter-spacing: -0.4px;">
                                Validasi Tugas Anggota
                            </h4>
                            <p class="text-muted small mb-0">
                                Anggota telah menyelesaikan pekerjaan dan mengajukan review. Periksa hasil kerja dan tentukan <strong>Approve</strong> atau <strong>Minta Revisi</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-top border-slate-100">
                    <div class="list-group list-group-flush border-0">
                        @foreach ($pendingReviews->take(2) as $task)
                            <a href="{{ route('tasks.show', $task) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-0 bg-transparent border-0">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge role-pill role-pill-{{ $task->job_title }}">
                                        {{ $task->job_title }}
                                    </span>
                                    <span class="small fw-bold text-dark">{{ $task->title }}</span>
                                </div>
                                <span class="btn btn-xs btn-outline-primary py-0.5 px-2 rounded-pill small" style="font-size:11px;">Periksa &rarr;</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- Default Workspace Highlight Card -->
            <div class="clean-glass-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="small fw-semibold text-muted">
                            <span class="text-teal fw-bold" style="color:var(--app-accent-teal);">Workspace Aktif</span> &bull; 
                            <span>Digital Agency Studio</span>
                        </div>
                        <span class="status-dot dot-green"></span>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="card-gradient-thumb thumb-teal">
                            <i class="bi bi-building-check"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 20px; letter-spacing: -0.4px;">
                                Digital Agency Studio
                            </h4>
                            <p class="text-muted small mb-0">
                                Ruang kerja kolaborasi agensi digital. Mengelola kampanye klien, pembagian tugas sesuai keahlian, dan alur verifikasi berkala.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-top border-slate-100 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                    <div>
                        <div class="text-muted small fw-semibold mb-1" style="font-size: 11px;">Status Alur</div>
                        <div class="small fw-bold text-success d-flex align-items-center gap-1">
                            <i class="bi bi-shield-check"></i> Semua Tugas Terverifikasi
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small fw-semibold mb-1" style="font-size: 11px;">Anggota Tim</div>
                        <div class="avatar-group-overlap">
                            <div class="avatar-circle-mini avatar-c-blue">R</div>
                            <div class="avatar-circle-mini avatar-c-purple">R</div>
                            <div class="avatar-circle-mini avatar-c-amber">M</div>
                            <div class="avatar-circle-mini avatar-c-teal">P</div>
                        </div>
                    </div>

                    @if ($primaryWorkspace)
                        <a href="{{ route('workspaces.show', $primaryWorkspace) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 font-semibold small">
                            Kelola Tim &rarr;
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

<!-- BOTTOM SECTION: Grid of Cards (Matching the 8 Class Cards in the screenshot) -->
<div class="mb-4" id="my-tasks-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark mb-0" style="font-size: 20px; letter-spacing: -0.3px;">
            Daftar Tugas Saya
        </h4>
        <span class="small text-muted fw-semibold">{{ $myTasks->count() }} Tugas Aktif</span>
    </div>

    @if ($myTasks->isEmpty())
        <div class="clean-glass-card p-5 text-center">
            <div class="card-gradient-thumb thumb-teal mx-auto mb-3" style="width:54px; height:54px; font-size:24px;">
                <i class="bi bi-check2-all"></i>
            </div>
            <h5 class="fw-bold text-dark">Tidak Ada Tugas Aktif Saat Ini</h5>
            <p class="text-muted small mb-0">Semua tugas telah diselesaikan atau Anda belum mendapatkan penugasan tugas baru.</p>
        </div>
    @else
        <div class="row g-3">
            @foreach ($myTasks as $index => $task)
                @php
                    $colors = ['thumb-pink', 'thumb-orange', 'thumb-teal', 'thumb-purple', 'thumb-green', 'thumb-amber'];
                    $colorClass = $colors[$index % count($colors)];
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="clean-glass-card h-100 p-3 d-flex flex-column justify-content-between" style="border-radius: 18px;">
                        <div>
                            <!-- Top Card Bar -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-1.5">
                                    <div class="card-thumb-sm {{ $colorClass }}">
                                        @switch($task->job_title)
                                            @case('content_creator') <i class="bi bi-pencil-fill"></i> @break
                                            @case('graphic_designer') <i class="bi bi-palette-fill"></i> @break
                                            @case('social_media_specialist') <i class="bi bi-megaphone-fill"></i> @break
                                            @default <i class="bi bi-file-text-fill"></i>
                                        @endswitch
                                    </div>
                                    <span class="text-muted text-truncate" style="font-size: 11px; max-width: 120px;">
                                        {{ $task->project->client_name }}
                                    </span>
                                </div>
                                <span class="status-dot {{ $task->status === 'review' ? 'dot-amber' : ($task->status === 'in_progress' ? 'dot-green' : 'dot-red') }}" title="{{ $task->statusLabel() }}"></span>
                            </div>

                            <!-- Title -->
                            <h6 class="fw-bold text-dark mb-1 text-truncate-2" style="font-size: 14px; line-height: 1.3;">
                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ $task->title }}
                                </a>
                            </h6>

                            <!-- Role Pill Badge -->
                            <div class="mb-3">
                                <span class="role-pill role-pill-{{ $task->job_title }}">
                                    @switch($task->job_title)
                                        @case('content_creator') Content Creator @break
                                        @case('graphic_designer') Graphic Designer @break
                                        @case('social_media_specialist') Sosmed Specialist @break
                                    @endswitch
                                </span>
                            </div>
                        </div>

                        <!-- Card Footer: Progress & Member -->
                        <div class="pt-2 border-top border-slate-100">
                            <div class="d-flex justify-content-between align-items-center mb-1.5" style="font-size: 11px;">
                                <span class="text-muted fw-semibold">Progres</span>
                                <span class="fw-bold text-dark">{{ $task->progress }}%</span>
                            </div>
                            <div class="step-progress-track mb-3">
                                <div class="step-progress-bar">
                                    <div class="step-progress-fill" style="width: {{ $task->progress }}%;"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="avatar-group-overlap">
                                    <div class="avatar-circle-mini avatar-c-blue" title="{{ $task->assignee->name }}">
                                        {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                    </div>
                                </div>

                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-dark rounded-pill px-2.5 py-0.5 small" style="font-size: 11px; font-weight: 600;">
                                    Buka &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- ADDITIONAL SECTION: All Workspaces (Card Grid) -->
<div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark mb-0" style="font-size: 20px; letter-spacing: -0.3px;">
            Workspace Tim
        </h4>
        <a href="{{ route('workspaces.index') }}" class="small text-primary fw-semibold text-decoration-none">Lihat Semua &rarr;</a>
    </div>

    <div class="row g-3">
        @foreach ($memberships as $m)
            <div class="col-md-6 col-lg-4">
                <div class="clean-glass-card h-100 p-4 d-flex flex-column justify-content-between" style="border-radius: 20px;">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="role-pill {{ $m->role === 'owner' ? 'role-pill-owner' : 'role-pill-' . $m->job_title }}">
                                {{ $m->role === 'owner' ? 'Owner / PM' : $m->jobTitleLabel() }}
                            </span>
                            <span class="status-dot dot-green"></span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $m->workspace->name }}</h5>
                        <p class="text-muted small mb-3">{{ $m->workspace->agency_name ?: 'Workspace agensi digital' }}</p>
                    </div>

                    <div class="pt-3 border-top border-slate-100 d-flex justify-content-between align-items-center">
                        <span class="small text-muted">{{ $m->workspace->projects->count() }} Campaign Klien</span>
                        <a href="{{ route('workspaces.show', $m->workspace) }}" class="btn btn-sm btn-dark rounded-pill px-3 py-1 font-semibold small" style="font-size:12px;">
                            Buka Workspace &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($isOwner)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('workspaces.create') }}" class="clean-glass-card h-100 p-4 d-flex flex-column align-items-center justify-content-center text-decoration-none" style="border: 2px dashed rgba(148, 163, 184, 0.4); border-radius: 20px; background: rgba(255,255,255,0.4);">
                    <div class="card-thumb-sm thumb-teal mb-2" style="width:38px; height:38px; font-size:18px; border-radius:12px;">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <span class="fw-bold text-dark small">Buat Workspace Baru</span>
                    <span class="text-muted" style="font-size:11px;">Mulai ruang kerja agensi baru</span>
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
