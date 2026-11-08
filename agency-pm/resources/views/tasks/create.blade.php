@extends('layouts.app')
@section('title', 'Tugas Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-md-7">
    <h4 class="mb-1">Buat & Assign Tugas Baru</h4>
    <p class="text-muted small mb-3">{{ $project->name }} &middot; {{ $project->client_name }}</p>

    <form method="POST" action="{{ route('tasks.store', $project) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Assign ke Anggota</label>
            <select name="assigned_to" id="assigned_to" class="form-select" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach ($members as $m)
                <option value="{{ $m->user_id }}" data-job="{{ $m->job_title }}">
                    {{ $m->user->name }} ({{ $m->jobTitleLabel() }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul Tugas</label>
            <input type="text" name="title" class="form-control" placeholder="Misal: Buat 10 ide konten feed Instagram" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Tambahan</label>
            <textarea name="description" class="form-control" rows="2"></textarea>
        </div>

        <div class="row">
            <div class="col-6 mb-3">
                <label class="form-label">Prioritas</label>
                <select name="priority" class="form-select" required>
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control">
            </div>
        </div>

        <hr>
        <h6>Detail Input / Brief Kerja</h6>
        <p class="small text-muted">Form ini otomatis menyesuaikan dengan jenis pekerjaan anggota yang dipilih.</p>

        {{-- Form dinamis per job_title, disembunyikan/ditampilkan via JS --}}
        @php
            $schemas = [
                'content_creator' => \App\Models\Task::inputSchema('content_creator'),
                'graphic_designer' => \App\Models\Task::inputSchema('graphic_designer'),
                'social_media_specialist' => \App\Models\Task::inputSchema('social_media_specialist'),
            ];
        @endphp

        @foreach ($schemas as $job => $fields)
        <div class="job-input-group" data-job="{{ $job }}" style="display:none;">
            @foreach ($fields as $key => $field)
            <div class="mb-2">
                <label class="form-label small">{{ $field['label'] }}</label>
                @if ($field['type'] === 'select')
                    <select name="input[{{ $key }}]" class="form-select form-select-sm">
                        @foreach ($field['options'] as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                @elseif ($field['type'] === 'date')
                    <input type="date" name="input[{{ $key }}]" class="form-control form-control-sm">
                @else
                    <input type="text" name="input[{{ $key }}]" class="form-control form-control-sm">
                @endif
            </div>
            @endforeach
        </div>
        @endforeach

        <button class="btn btn-primary mt-3">Buat & Assign Tugas</button>
    </form>
</div>
</div>

<script>
    const select = document.getElementById('assigned_to');
    const groups = document.querySelectorAll('.job-input-group');
    select.addEventListener('change', function () {
        const job = this.selectedOptions[0]?.dataset.job;
        groups.forEach(g => g.style.display = (g.dataset.job === job) ? 'block' : 'none');
    });
</script>
@endsection
