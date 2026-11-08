@extends('layouts.app')
@section('title', 'Ubah Proyek')

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar mb-3">
    <div>
        <div class="page-subtitle-breadcrumb">
            <a href="{{ route('projects.show', $project) }}" class="text-decoration-none text-muted">
                &larr; Kembali ke {{ $project->name }}
            </a>
        </div>
        <h2 class="page-main-heading">
            Ubah Rincian Proyek
        </h2>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="clean-glass-card p-4 p-md-5" style="border-radius: 28px;">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-slate-100">
                <div class="card-gradient-thumb thumb-pink" style="width:52px; height:52px; font-size:22px;">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Ubah Campaign / Proyek</h5>
                    <p class="text-muted small mb-0">{{ $project->name }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('projects.update', $project) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Nama Campaign</label>
                    <input type="text" name="name" class="form-control rounded-3 border-slate-200 py-2 small" value="{{ old('name', $project->name) }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Nama Klien</label>
                    <input type="text" name="client_name" class="form-control rounded-3 border-slate-200 py-2 small" value="{{ old('client_name', $project->client_name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Brief Singkat dari Klien</label>
                    <textarea name="brief" class="form-control rounded-3 border-slate-200 small" rows="3">{{ old('brief', $project->brief) }}</textarea>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label class="form-label small fw-bold text-dark">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control rounded-3 border-slate-200 py-2 small" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-bold text-dark">Tenggat Waktu (Deadline)</label>
                        <input type="date" name="deadline" class="form-control rounded-3 border-slate-200 py-2 small" value="{{ old('deadline', $project->deadline ? $project->deadline->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-slate-100">
                    <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none small" onclick="if(confirm('Hapus proyek ini beserta seluruh tugas di dalamnya?')) { document.getElementById('delete-project-form').submit(); }">
                        <i class="bi bi-trash"></i> Hapus Proyek
                    </button>

                    <div class="d-flex gap-2">
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-light border rounded-pill px-4 font-semibold text-muted">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-theme-primary px-4">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <form id="delete-project-form" method="POST" action="{{ route('projects.destroy', $project) }}" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

@endsection
