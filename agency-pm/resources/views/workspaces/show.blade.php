@extends('layouts.app')
@section('title', $workspace->name)

@php
    $myMembership = $workspace->memberOf(auth()->user());
    $isOwner = $myMembership && $myMembership->isOwner();
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3>{{ $workspace->name }}</h3>
        <p class="text-muted mb-0">{{ $workspace->agency_name }}</p>
    </div>
    @if ($isOwner)
    <a href="{{ route('projects.create', $workspace) }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Campaign Baru</a>
    @endif
</div>

<div class="row">
    {{-- ====== DAFTAR PROYEK/CAMPAIGN ====== --}}
    <div class="col-md-8">
        <h5 class="mb-3">Campaign / Proyek Klien</h5>
        @forelse ($workspace->projects as $project)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">{{ $project->name }}</h6>
                        <div class="small text-muted">Klien: {{ $project->client_name }}</div>
                    </div>
                    @if ($project->isLate())
                        <span class="badge bg-danger">Terlambat</span>
                    @endif
                </div>
                <div class="progress my-2" style="height:8px;">
                    <div class="progress-bar bg-success" style="width: {{ $project->progressPercent() }}%"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        {{ $project->tasks->count() }} tugas &middot; {{ $project->progressPercent() }}% selesai
                        @if ($project->deadline) &middot; Deadline {{ $project->deadline->format('d M Y') }} @endif
                    </span>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">Buka</a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">Belum ada campaign/proyek di workspace ini.</p>
        @endforelse
    </div>

    {{-- ====== ANGGOTA TIM ====== --}}
    <div class="col-md-4">
        <h5 class="mb-3">Anggota Tim</h5>
        <div class="list-group mb-3">
            @foreach ($workspace->members as $member)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <div>{{ $member->user->name }}</div>
                    <span class="badge role-badge-{{ $member->role === 'owner' ? 'owner' : $member->job_title }}">
                        {{ $member->role === 'owner' ? 'Owner' : $member->jobTitleLabel() }}
                    </span>
                </div>
                @if ($isOwner && $member->role !== 'owner')
                <form method="POST" action="{{ route('workspaces.members.destroy', [$workspace, $member]) }}" onsubmit="return confirm('Hapus anggota ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
                @endif
            </div>
            @endforeach
        </div>

        @if ($isOwner)
        <div class="card">
            <div class="card-body">
                <h6>Tambah Anggota</h6>
                <form method="POST" action="{{ route('workspaces.members.store', $workspace) }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small">Email (harus sudah terdaftar)</label>
                        <input type="email" name="email" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Jenis Pekerjaan (Role)</label>
                        <select name="job_title" class="form-select form-select-sm" required>
                            <option value="content_creator">Content Creator</option>
                            <option value="graphic_designer">Graphic Designer</option>
                            <option value="social_media_specialist">Social Media Specialist</option>
                        </select>
                    </div>
                    <button class="btn btn-sm btn-primary w-100">Tambahkan</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
