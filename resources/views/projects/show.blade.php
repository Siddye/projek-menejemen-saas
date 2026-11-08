@extends('layouts.app')
@section('title', $project->name)

@php
    $isOwner = $project->workspace->memberOf(auth()->user())?->isOwner();
    $statuses = [
        'todo' => ['label' => 'To Do', 'color' => '#64748b', 'badge' => 'secondary'],
        'in_progress' => ['label' => 'In Progress', 'color' => '#2563eb', 'badge' => 'primary'],
        'review' => ['label' => 'Review', 'color' => '#f59e0b', 'badge' => 'warning'],
        'revisi' => ['label' => 'Revisi', 'color' => '#ef4444', 'badge' => 'danger'],
        'done' => ['label' => 'Done', 'color' => '#10b981', 'badge' => 'success'],
    ];
@endphp

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar mb-3">
    <div>
        <div class="page-subtitle-breadcrumb">
            <a href="{{ route('workspaces.show', $project->workspace) }}" class="text-decoration-none text-muted">
                &larr; Workspace: {{ $project->workspace->name }}
            </a>
        </div>
        <h2 class="page-main-heading">
            {{ $project->name }}
        </h2>
    </div>

    <div class="d-flex align-items-center gap-2">
        @if ($isOwner)
            <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 shadow-xs text-muted font-semibold">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('tasks.create', $project) }}" class="btn-theme-primary">
                <i class="bi bi-plus-square"></i> Buat Tugas Baru
            </a>
        @endif
    </div>
</div>

<!-- Project Overview Card (Clean Glass) -->
<div class="clean-glass-card p-4 mb-4" style="border-radius: 24px;">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 font-semibold" style="font-size:12px;">
                    <i class="bi bi-person-badge me-1"></i> Klien: {{ $project->client_name }}
                </span>
                @if ($project->deadline)
                    <span class="badge bg-light text-muted border rounded-pill px-3 py-1 font-semibold" style="font-size:12px;">
                        <i class="bi bi-calendar3 me-1"></i> Tenggat: {{ $project->deadline->format('d M Y') }}
                        @if ($project->isLate()) <span class="text-danger fw-bold">(Terlambat!)</span> @endif
                    </span>
                @endif
            </div>

            @if ($project->brief)
                <p class="text-muted small mb-0" style="line-height: 1.6;">
                    <strong>Brief Klien:</strong> {{ $project->brief }}
                </p>
            @endif
        </div>

        <div class="col-lg-5">
            <div class="p-3 bg-white/80 rounded-4 border border-slate-100">
                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 12px;">
                    <span class="text-muted fw-semibold">Progres Keseluruhan Proyek</span>
                    <span class="fw-bold text-dark fs-6">{{ $project->progressPercent() }}%</span>
                </div>
                <div class="step-progress-track mb-3">
                    <div class="step-progress-bar" style="height: 8px;">
                        <div class="step-progress-fill" style="width: {{ $project->progressPercent() }}%"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center small text-muted">
                    <span><strong>{{ $project->tasks->count() }}</strong> Total Tugas</span>
                    <div class="avatar-group-overlap">
                        <div class="avatar-circle-mini avatar-c-blue">R</div>
                        <div class="avatar-circle-mini avatar-c-purple">R</div>
                        <div class="avatar-circle-mini avatar-c-amber">M</div>
                        <div class="avatar-circle-mini avatar-c-teal">P</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KANBAN BOARD LANES (5 Columns) -->
<div class="row g-3">
    @foreach ($statuses as $key => $statusMeta)
        @php
            $colTasks = $tasksByStatus->get($key, collect());
        @endphp
        <div class="col-lg">
            <!-- Column Container (Frosted Glass Lane) -->
            <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.65); border: 1px solid rgba(226, 232, 240, 0.8); min-height: 480px;">
                
                <!-- Column Header -->
                <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-dot" style="background: {{ $statusMeta['color'] }};"></span>
                        <span class="fw-bold small text-dark text-uppercase tracking-wider" style="font-size: 12px;">
                            {{ $statusMeta['label'] }}
                        </span>
                    </div>
                    <span class="badge rounded-pill bg-white text-dark border px-2 py-1 shadow-2xs" style="font-size: 11px;">
                        {{ $colTasks->count() }}
                    </span>
                </div>

                <!-- Column Cards -->
                <div class="d-flex flex-column gap-2.5">
                    @forelse ($colTasks as $index => $task)
                        @php
                            $colors = ['thumb-pink', 'thumb-orange', 'thumb-teal', 'thumb-purple', 'thumb-green'];
                            $thumbColor = $colors[$index % count($colors)];
                        @endphp
                        <a href="{{ route('tasks.show', $task) }}" class="clean-glass-card p-3 text-decoration-none text-dark d-block" style="border-radius: 16px; border-left: 4px solid {{ $statusMeta['color'] }};">
                            
                            <!-- Card Header: Role & Priority -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="role-pill role-pill-{{ $task->job_title }}" style="font-size: 10px; padding: 2px 7px;">
                                    @switch($task->job_title)
                                        @case('content_creator') Content @break
                                        @case('graphic_designer') Desain @break
                                        @case('social_media_specialist') Sosmed @break
                                    @endswitch
                                </span>
                                
                                <span class="badge {{ $task->priority === 'high' ? 'bg-danger-subtle text-danger' : ($task->priority === 'medium' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-secondary-subtle text-secondary') }} rounded-pill" style="font-size: 10px;">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>

                            <!-- Card Title -->
                            <div class="fw-bold text-dark mb-2" style="font-size: 13px; line-height: 1.35;">
                                {{ $task->title }}
                            </div>

                            @if ($task->revisions->isNotEmpty() && $task->status === 'revisi')
                                <div class="p-1.5 rounded-2 bg-danger-subtle text-danger small mb-2" style="font-size: 11px;">
                                    <i class="bi bi-arrow-counterclockwise"></i> Perlu Revisi
                                </div>
                            @endif

                            <!-- Card Footer: Assignee & Progress -->
                            <div class="pt-2 border-top border-slate-100 d-flex justify-content-between align-items-center" style="font-size: 11px;">
                                <div class="d-flex align-items-center gap-1.5 text-muted">
                                    <div class="avatar-circle-mini avatar-c-blue" style="width: 20px; height: 20px; font-size: 9px;">
                                        {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                    </div>
                                    <span class="text-truncate" style="max-width: 75px;">{{ $task->assignee->name }}</span>
                                </div>

                                <div class="text-end">
                                    @if ($task->deadline)
                                        <span class="{{ $task->isLate() ? 'text-danger fw-bold' : 'text-muted' }}">
                                            {{ $task->deadline->format('d M') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Mini Progress Bar -->
                            <div class="step-progress-track mt-2">
                                <div class="step-progress-bar" style="height: 4px;">
                                    <div class="step-progress-fill" style="width: {{ $task->progress }}%; background: {{ $statusMeta['color'] }};"></div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-center text-muted small border border-dashed rounded-3" style="border-color: rgba(148, 163, 184, 0.4); font-size: 11px;">
                            Tidak ada tugas
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    @endforeach
</div>

@endsection
