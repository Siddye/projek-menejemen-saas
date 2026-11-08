@extends('layouts.app')
@section('title', $workspace->name)

@php
    $myMembership = $workspace->memberOf(auth()->user());
    $isOwner = $myMembership && $myMembership->isOwner();
@endphp

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar mb-3">
    <div>
        <div class="page-subtitle-breadcrumb">
            <a href="{{ route('workspaces.index') }}" class="text-decoration-none text-muted">&larr; Semua Workspace</a>
        </div>
        <h2 class="page-main-heading">
            {{ $workspace->name }}
        </h2>
    </div>

    <div class="d-flex align-items-center gap-2">
        @if ($isOwner)
            <a href="{{ route('projects.create', $workspace) }}" class="btn-theme-primary">
                <i class="bi bi-plus-square"></i> Buat Campaign Baru
            </a>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- LEFT COLUMN: Campaign / Proyek Klien -->
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0 fs-6">
                <i class="bi bi-briefcase-fill text-primary me-1.5"></i> Campaign / Proyek Klien ({{ $workspace->projects->count() }})
            </h5>
            @if ($isOwner)
                <a href="{{ route('projects.create', $workspace) }}" class="small text-primary fw-bold text-decoration-none">+ Tambah Proyek</a>
            @endif
        </div>

        <div class="d-flex flex-column gap-3">
            @forelse ($workspace->projects as $index => $project)
                @php
                    $colors = ['thumb-pink', 'thumb-teal', 'thumb-orange', 'thumb-purple'];
                    $thumbColor = $colors[$index % count($colors)];
                @endphp
                <div class="clean-glass-card p-4" style="border-radius: 20px;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-3 mb-3">
                        <div class="d-flex align-items-start gap-3">
                            <div class="card-gradient-thumb {{ $thumbColor }}" style="width:54px; height:54px; font-size:22px; border-radius:16px;">
                                <i class="bi bi-folder-fill"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1" style="font-size: 17px;">
                                    <a href="{{ route('projects.show', $project) }}" class="text-decoration-none text-dark hover-primary">
                                        {{ $project->name }}
                                    </a>
                                </h5>
                                <div class="small text-muted">
                                    Klien: <strong class="text-dark">{{ $project->client_name }}</strong>
                                    @if ($project->deadline)
                                        &bull; Tenggat: {{ $project->deadline->format('d M Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            @if ($project->isLate())
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Terlambat</span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Aktif</span>
                            @endif
                        </div>
                    </div>

                    <!-- Progress bar -->
                    <div class="pt-2">
                        <div class="d-flex justify-content-between align-items-center text-muted small mb-1" style="font-size:11px;">
                            <span>Progres Penyelesaian</span>
                            <span class="fw-bold text-dark">{{ $project->progressPercent() }}%</span>
                        </div>
                        <div class="step-progress-track mb-3">
                            <div class="step-progress-bar">
                                <div class="step-progress-fill" style="width: {{ $project->progressPercent() }}%"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top border-slate-100 small">
                            <span class="text-muted"><strong>{{ $project->tasks->count() }}</strong> Total Tugas</span>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 font-semibold small" style="font-size:11px;">
                                Buka Board Proyek &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="clean-glass-card p-4 text-center">
                    <p class="text-muted small mb-2">Belum ada campaign atau proyek di workspace ini.</p>
                    @if ($isOwner)
                        <a href="{{ route('projects.create', $workspace) }}" class="btn btn-sm btn-theme-primary">
                            + Buat Campaign Sekarang
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    <!-- RIGHT COLUMN: Anggota Tim & Undangan -->
    <div class="col-lg-4">
        <!-- Team List Card -->
        <div class="clean-glass-card p-4 mb-4" style="border-radius: 22px;">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-slate-100">
                <h5 class="fw-bold text-dark mb-0 fs-6">
                    <i class="bi bi-people-fill text-teal me-1.5" style="color:var(--app-accent-teal);"></i> Anggota Tim ({{ $workspace->members->count() }})
                </h5>
                <span class="badge bg-light text-muted border rounded-pill small">Aktif</span>
            </div>

            <div class="d-flex flex-column gap-2.5 mb-3">
                @foreach ($workspace->members as $member)
                    <div class="p-2.5 rounded-3 bg-white/70 border border-slate-100 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-circle-mini avatar-c-blue" style="width:30px; height:30px; font-size:12px;">
                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">{{ $member->user->name }}</div>
                                <span class="role-pill {{ $member->role === 'owner' ? 'role-pill-owner' : 'role-pill-' . $member->job_title }}" style="font-size: 10px; padding: 1px 7px;">
                                    {{ $member->role === 'owner' ? 'Owner / PM' : $member->jobTitleLabel() }}
                                </span>
                            </div>
                        </div>

                        @if ($isOwner && $member->role !== 'owner')
                            <form method="POST" action="{{ route('workspaces.members.destroy', [$workspace, $member]) }}" onsubmit="return confirm('Hapus anggota ini dari workspace?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 border-0" title="Hapus Anggota">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Add Member Form for Owner -->
            @if ($isOwner)
                <div class="pt-3 border-top border-slate-100">
                    <h6 class="fw-bold text-dark small mb-2">+ Tambah Anggota ke Tim</h6>
                    <form method="POST" action="{{ route('workspaces.members.store', $workspace) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label text-muted" style="font-size: 11px;">Email Anggota (Sudah Terdaftar)</label>
                            <input type="email" name="email" class="form-control rounded-3 border-slate-200 small" placeholder="nama@agency.test" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 11px;">Peran / Job Title</label>
                            <select name="job_title" class="form-select rounded-3 border-slate-200 small" required>
                                <option value="content_creator">Content Creator</option>
                                <option value="graphic_designer">Graphic Designer</option>
                                <option value="social_media_specialist">Social Media Specialist</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-theme-primary w-100 justify-content-center">
                            <i class="bi bi-person-plus-fill"></i> Tambahkan ke Tim
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
