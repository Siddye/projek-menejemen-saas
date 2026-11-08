@extends('layouts.app')
@section('title', 'Buat Workspace')

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar mb-3">
    <div>
        <div class="page-subtitle-breadcrumb">
            <a href="{{ route('workspaces.index') }}" class="text-decoration-none text-muted">&larr; Kembali ke Daftar Workspace</a>
        </div>
        <h2 class="page-main-heading">
            Buat Workspace Baru
        </h2>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="clean-glass-card p-4 p-md-5" style="border-radius: 28px;">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-slate-100">
                <div class="card-gradient-thumb thumb-teal" style="width:52px; height:52px; font-size:22px;">
                    <i class="bi bi-buildings-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Ruang Kerja Baru</h5>
                    <p class="text-muted small mb-0">Anda akan otomatis menjadi Owner pada workspace ini.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('workspaces.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Nama Workspace</label>
                    <input type="text" name="name" class="form-control rounded-3 border-slate-200 py-2 small" placeholder="Contoh: Digital Agency Studio" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-dark">Deskripsi / Brand Agensi (Opsional)</label>
                    <input type="text" name="agency_name" class="form-control rounded-3 border-slate-200 py-2 small" placeholder="Contoh: Studio agensi kreatif milik Raffi & tim" value="{{ old('agency_name') }}">
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top border-slate-100">
                    <a href="{{ route('workspaces.index') }}" class="btn btn-sm btn-light border rounded-pill px-4 font-semibold text-muted">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-theme-primary px-4">
                        <i class="bi bi-check-lg"></i> Buat Workspace
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
