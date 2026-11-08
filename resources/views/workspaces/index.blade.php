@extends('layouts.app')
@section('title', 'Workspace Saya')

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar">
    <div>
        <div class="page-subtitle-breadcrumb">Manajemen Ruang Kerja</div>
        <h2 class="page-main-heading">
            Daftar Workspace Tim
        </h2>
    </div>

    <div>
        <a href="{{ route('workspaces.create') }}" class="btn-theme-primary">
            <i class="bi bi-plus-square"></i> Buat Workspace Baru
        </a>
    </div>
</div>

<div class="row g-4">
    @forelse ($workspaces as $index => $workspace)
        @php
            $colors = ['thumb-teal', 'thumb-pink', 'thumb-purple', 'thumb-orange'];
            $thumbColor = $colors[$index % count($colors)];
            $isOwner = $workspace->owner_id === auth()->id();
        @endphp
        <div class="col-md-6 col-lg-4">
            <div class="clean-glass-card h-100 p-4 d-flex flex-column justify-content-between" style="border-radius: 22px;">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="card-thumb-sm {{ $thumbColor }}" style="width:40px; height:40px; font-size:18px; border-radius:14px;">
                            <i class="bi bi-layers-half"></i>
                        </div>
                        <span class="role-pill {{ $isOwner ? 'role-pill-owner' : 'role-pill-content_creator' }}">
                            {{ $isOwner ? 'Owner' : 'Anggota' }}
                        </span>
                    </div>

                    <h4 class="fw-bold text-dark mb-1" style="font-size: 18px; letter-spacing: -0.3px;">
                        <a href="{{ route('workspaces.show', $workspace) }}" class="text-decoration-none text-dark hover-primary">
                            {{ $workspace->name }}
                        </a>
                    </h4>
                    <p class="text-muted small mb-3">
                        {{ $workspace->agency_name ?: 'Ruang kerja agensi digital & kolaborasi tim.' }}
                    </p>
                </div>

                <div class="pt-3 border-top border-slate-100 d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-semibold">
                        <i class="bi bi-folder2-open me-1"></i> {{ $workspace->projects->count() }} Campaign
                    </span>
                    <a href="{{ route('workspaces.show', $workspace) }}" class="btn btn-sm btn-dark rounded-pill px-3 py-1 font-semibold small" style="font-size: 11px;">
                        Buka Workspace &rarr;
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="clean-glass-card p-5 text-center">
                <div class="card-gradient-thumb thumb-teal mx-auto mb-3">
                    <i class="bi bi-folder-plus"></i>
                </div>
                <h4 class="fw-bold text-dark">Belum Memiliki Workspace</h4>
                <p class="text-muted small mb-4">Mulai dengan membuat ruang kerja untuk tim agensi Anda.</p>
                <a href="{{ route('workspaces.create') }}" class="btn-theme-primary">
                    <i class="bi bi-plus-lg"></i> Buat Workspace Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>

@endsection
