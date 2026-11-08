@extends('layouts.app')
@section('title', 'Campaign Baru')

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar mb-3">
    <div>
        <div class="page-subtitle-breadcrumb">
            <a href="{{ route('workspaces.show', $workspace) }}" class="text-decoration-none text-muted">
                &larr; Workspace: {{ $workspace->name }}
            </a>
        </div>
        <h2 class="page-main-heading">
            Buat Campaign / Proyek Klien Baru
        </h2>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="clean-glass-card p-4 p-md-5" style="border-radius: 28px;">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-slate-100">
                <div class="card-gradient-thumb thumb-pink" style="width:52px; height:52px; font-size:22px;">
                    <i class="bi bi-rocket-takeoff-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Rincian Campaign</h5>
                    <p class="text-muted small mb-0">{{ $workspace->name }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('projects.store', $workspace) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Nama Campaign</label>
                    <input type="text" name="name" class="form-control rounded-3 border-slate-200 py-2 small" placeholder="Contoh: Campaign Media Sosial - Peluncuran Produk" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Nama Klien</label>
                    <input type="text" name="client_name" class="form-control rounded-3 border-slate-200 py-2 small" placeholder="Contoh: Kopi Nusantara" value="{{ old('client_name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Brief Singkat dari Klien</label>
                    <textarea name="brief" class="form-control rounded-3 border-slate-200 small" rows="3" placeholder="Klien ingin campaign peluncuran produk baru dengan fokus audiens muda...">{{ old('brief') }}</textarea>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label class="form-label small fw-bold text-dark">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control rounded-3 border-slate-200 py-2 small" value="{{ old('start_date', date('Y-m-d')) }}">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-bold text-dark">Tenggat Waktu (Deadline)</label>
                        <input type="date" name="deadline" class="form-control rounded-3 border-slate-200 py-2 small" value="{{ old('deadline', date('Y-m-d', strtotime('+14 days'))) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top border-slate-100">
                    <a href="{{ route('workspaces.show', $workspace) }}" class="btn btn-sm btn-light border rounded-pill px-4 font-semibold text-muted">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-theme-primary px-4">
                        <i class="bi bi-check-lg"></i> Buat Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
