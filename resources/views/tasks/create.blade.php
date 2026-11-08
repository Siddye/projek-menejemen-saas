@extends('layouts.app')
@section('title', 'Tugas Baru')

@section('content')

<!-- Header Action Bar -->
<div class="content-action-bar mb-3">
    <div>
        <div class="page-subtitle-breadcrumb">
            <a href="{{ route('projects.show', $project) }}" class="text-decoration-none text-muted">
                &larr; Proyek: {{ $project->name }}
            </a>
        </div>
        <h2 class="page-main-heading">
            Buat & Assign Tugas Baru
        </h2>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="clean-glass-card p-4 p-md-5" style="border-radius: 28px;">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-slate-100">
                <div class="card-gradient-thumb thumb-teal" style="width:52px; height:52px; font-size:22px;">
                    <i class="bi bi-plus-square-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Formulir Penugasan Kerja</h5>
                    <p class="text-muted small mb-0">{{ $project->name }} &bull; Klien: {{ $project->client_name }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('tasks.store', $project) }}">
                @csrf

                <!-- Assignee Selection -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-dark">Pilih Anggota Tim (Assignee)</label>
                    <select name="assigned_to" id="assigned_to" class="form-select rounded-3 border-slate-200 py-2 small fw-semibold" required>
                        <option value="">-- Pilih Anggota Tim Sesuai Peran --</option>
                        @foreach ($members as $m)
                            <option value="{{ $m->user_id }}" data-job="{{ $m->job_title }}">
                                {{ $m->user->name }} &bull; ({{ $m->jobTitleLabel() }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text small" style="font-size: 11px;">
                        Brief input di bawah otomatis berganti menyesuaikan spesialisasi peran yang dipilih.
                    </div>
                </div>

                <!-- Title & Description -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Judul Tugas</label>
                    <input type="text" name="title" class="form-control rounded-3 border-slate-200 py-2 small" placeholder="Contoh: Mendesain 10 visual feed Instagram..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Deskripsi Tambahan</label>
                    <textarea name="description" class="form-control rounded-3 border-slate-200 small" rows="2" placeholder="Catatan instruksi umum pengerjaan..."></textarea>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label class="form-label small fw-bold text-dark">Tingkat Prioritas</label>
                        <select name="priority" class="form-select rounded-3 border-slate-200 py-2 small" required>
                            <option value="low">Low (Rendah)</option>
                            <option value="medium" selected>Medium (Sedang)</option>
                            <option value="high">High (Tinggi)</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-bold text-dark">Tenggat Waktu (Deadline)</label>
                        <input type="date" name="deadline" class="form-control rounded-3 border-slate-200 py-2 small" value="{{ date('Y-m-d', strtotime('+4 days')) }}">
                    </div>
                </div>

                <!-- Dynamic Input Brief Box -->
                <div class="p-4 rounded-4 bg-white/80 border border-slate-200 mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="status-dot dot-green"></span>
                        <h6 class="fw-bold text-dark mb-0 fs-6">Brief Kerja Khusus Sesuai Peran</h6>
                    </div>
                    <p class="text-muted small mb-3" style="font-size: 11px;">
                        Isi parameter brief kerja yang akan ditampilkan kepada anggota tim saat mengerjakan tugas ini.
                    </p>

                    @php
                        $schemas = [
                            'content_creator' => \App\Models\Task::inputSchema('content_creator'),
                            'graphic_designer' => \App\Models\Task::inputSchema('graphic_designer'),
                            'social_media_specialist' => \App\Models\Task::inputSchema('social_media_specialist'),
                        ];
                    @endphp

                    <div id="no-role-selected" class="p-3 text-center text-muted small border border-dashed rounded-3">
                        Silakan pilih anggota tim di atas untuk memunculkan form brief khusus.
                    </div>

                    @foreach ($schemas as $job => $fields)
                        <div class="job-input-group d-flex flex-column gap-3" data-job="{{ $job }}" style="display:none;">
                            @foreach ($fields as $key => $field)
                                <div>
                                    <label class="form-label small fw-bold text-dark mb-1">{{ $field['label'] }}</label>
                                    @if ($field['type'] === 'select')
                                        <select name="input[{{ $key }}]" class="form-select rounded-3 border-slate-200 py-1.5 small">
                                            @foreach ($field['options'] as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    @elseif ($field['type'] === 'date')
                                        <input type="date" name="input[{{ $key }}]" class="form-control rounded-3 border-slate-200 py-1.5 small">
                                    @else
                                        <input type="text" name="input[{{ $key }}]" class="form-control rounded-3 border-slate-200 py-1.5 small" placeholder="Masukkan {{ strtolower($field['label']) }}...">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top border-slate-100">
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-light border rounded-pill px-4 font-semibold text-muted">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-theme-primary px-4">
                        <i class="bi bi-check-lg"></i> Simpan & Assign Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const select = document.getElementById('assigned_to');
    const groups = document.querySelectorAll('.job-input-group');
    const noRoleMsg = document.getElementById('no-role-selected');

    select.addEventListener('change', function () {
        const job = this.selectedOptions[0]?.dataset.job;
        let anyVisible = false;

        groups.forEach(g => {
            if (g.dataset.job === job) {
                g.style.display = 'flex';
                anyVisible = true;
            } else {
                g.style.display = 'none';
            }
        });

        if (noRoleMsg) {
            noRoleMsg.style.display = anyVisible ? 'none' : 'block';
        }
    });
</script>

@endsection
