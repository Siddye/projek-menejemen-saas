@extends('layouts.app')
@section('title', 'Workspace Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Workspace Saya</h3>
    <a href="{{ route('workspaces.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Workspace Baru</a>
</div>

<div class="row">
    @forelse ($workspaces as $workspace)
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5>{{ $workspace->name }}</h5>
                <p class="text-muted small">{{ $workspace->agency_name }}</p>
                <a href="{{ route('workspaces.show', $workspace) }}" class="btn btn-sm btn-primary">Buka</a>
            </div>
        </div>
    </div>
    @empty
    <p class="text-muted">Anda belum punya workspace. Buat satu untuk mulai mengelola campaign klien.</p>
    @endforelse
</div>
@endsection
