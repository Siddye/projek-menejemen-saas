@extends('layouts.app')
@section('title', $project->name)

@php
    $isOwner = $project->workspace->memberOf(auth()->user())?->isOwner();
    $statuses = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'review' => 'Review', 'revisi' => 'Revisi', 'done' => 'Done'];
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <a href="{{ route('workspaces.show', $project->workspace) }}" class="text-decoration-none small">&larr; {{ $project->workspace->name }}</a>
        <h3 class="mb-0">{{ $project->name }}</h3>
        <div class="text-muted">Klien: <strong>{{ $project->client_name }}</strong>
            @if ($project->deadline) &middot; Deadline: {{ $project->deadline->format('d M Y') }} @endif
        </div>
    </div>
    @if ($isOwner)
    <a href="{{ route('tasks.create', $project) }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tugas Baru</a>
    @endif
</div>

@if ($project->brief)
<div class="alert alert-light border">
    <strong>Brief Klien:</strong> {{ $project->brief }}
</div>
@endif

<div class="progress mb-4" style="height:10px;">
    <div class="progress-bar bg-success" style="width: {{ $project->progressPercent() }}%"></div>
</div>

{{-- ====== KANBAN BOARD ====== --}}
<div class="row">
    @foreach ($statuses as $key => $label)
    <div class="col kanban-col">
        <h6 class="text-muted text-uppercase small mb-2">{{ $label }} ({{ $tasksByStatus->get($key, collect())->count() }})</h6>
        @foreach ($tasksByStatus->get($key, collect()) as $task)
        <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark">
            <div class="card task-card priority-{{ $task->priority }} mb-2">
                <div class="card-body p-2">
                    <span class="badge role-badge-{{ $task->job_title }} small mb-1">
                        @switch($task->job_title)
                            @case('content_creator') Content Creator @break
                            @case('graphic_designer') Graphic Designer @break
                            @case('social_media_specialist') Social Media Specialist @break
                        @endswitch
                    </span>
                    <div class="small fw-semibold">{{ $task->title }}</div>
                    <div class="small text-muted">{{ $task->assignee->name }}</div>
                    @if ($task->deadline)
                        <div class="small {{ $task->isLate() ? 'text-danger fw-bold' : 'text-muted' }}">
                            {{ $task->deadline->format('d M') }}
                        </div>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endforeach
</div>
@endsection
