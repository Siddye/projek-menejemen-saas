@extends('layouts.app')
@section('title', 'Campaign Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-md-7">
    <h4 class="mb-3">Buat Campaign/Proyek Klien Baru</h4>
    <form method="POST" action="{{ route('projects.store', $workspace) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Campaign</label>
            <input type="text" name="name" class="form-control" placeholder="Campaign Media Sosial - Peluncuran Produk" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Klien</label>
            <input type="text" name="client_name" class="form-control" placeholder="Kopi Nusantara" value="{{ old('client_name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Brief dari Klien</label>
            <textarea name="brief" class="form-control" rows="4" placeholder="Jelaskan kebutuhan dan tujuan campaign klien...">{{ old('brief') }}</textarea>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}">
            </div>
        </div>
        <button class="btn btn-primary">Buat Campaign</button>
    </form>
</div>
</div>
@endsection
