@extends('layouts.app')
@section('title', 'Buat Workspace')

@section('content')
<div class="row justify-content-center">
<div class="col-md-6">
    <h4 class="mb-3">Buat Workspace Baru</h4>
    <form method="POST" action="{{ route('workspaces.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Workspace</label>
            <input type="text" name="name" class="form-control" placeholder="Digital Agency Studio" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Agensi (opsional)</label>
            <input type="text" name="agency_name" class="form-control" placeholder="Nama agensi/brand Anda" value="{{ old('agency_name') }}">
        </div>
        <button class="btn btn-primary">Buat Workspace</button>
    </form>
</div>
</div>
@endsection
