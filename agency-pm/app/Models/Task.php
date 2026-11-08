<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'assigned_to', 'created_by', 'job_title',
        'title', 'description', 'priority', 'deadline', 'status',
        'input_data', 'output_data', 'progress',
    ];

    protected $casts = [
        'deadline' => 'date',
        'input_data' => 'array',
        'output_data' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(TaskRevision::class)->latest();
    }

    public function isLate(): bool
    {
        return $this->deadline && $this->deadline->isPast() && $this->status !== 'done';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'review' => 'Review',
            'revisi' => 'Revisi',
            'done' => 'Done',
            default => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'todo' => 'secondary',
            'in_progress' => 'primary',
            'review' => 'warning',
            'revisi' => 'danger',
            'done' => 'success',
            default => 'secondary',
        };
    }

    // Skema field INPUT (brief dari Owner) sesuai job_title — dipakai untuk render form
    public static function inputSchema(string $jobTitle): array
    {
        return match ($jobTitle) {
            'content_creator' => [
                'content_type'   => ['label' => 'Jenis Konten', 'type' => 'select', 'options' => ['Caption', 'Naskah Video', 'Artikel', 'Ide Konten']],
                'topic'          => ['label' => 'Topik/Tema', 'type' => 'text'],
                'tone_of_voice'  => ['label' => 'Tone of Voice', 'type' => 'text'],
                'reference_link' => ['label' => 'Link Referensi', 'type' => 'url'],
            ],
            'graphic_designer' => [
                'design_type'     => ['label' => 'Jenis Desain', 'type' => 'select', 'options' => ['Feed Instagram', 'Story', 'Banner', 'Poster']],
                'dimensions'      => ['label' => 'Ukuran/Dimensi', 'type' => 'text'],
                'brand_guideline' => ['label' => 'Link Brand Guideline', 'type' => 'url'],
                'color_notes'     => ['label' => 'Catatan Warna/Gaya', 'type' => 'text'],
            ],
            'social_media_specialist' => [
                'platforms'     => ['label' => 'Platform', 'type' => 'select', 'options' => ['Instagram', 'TikTok', 'Facebook', 'Twitter/X', 'Semua Platform']],
                'post_schedule' => ['label' => 'Target Tanggal Posting', 'type' => 'date'],
                'campaign_goal' => ['label' => 'Target/Goal Campaign', 'type' => 'text'],
            ],
            default => [],
        };
    }

    // Skema field OUTPUT (hasil kerja dari anggota) sesuai job_title — dipakai untuk render form
    public static function outputSchema(string $jobTitle): array
    {
        return match ($jobTitle) {
            'content_creator' => [
                'content_text' => ['label' => 'Isi Konten/Caption', 'type' => 'textarea'],
                'file_link'    => ['label' => 'Link File Naskah/Dokumen', 'type' => 'url'],
            ],
            'graphic_designer' => [
                'design_file_link' => ['label' => 'Link File Desain (Figma/Drive)', 'type' => 'url'],
                'preview_image'    => ['label' => 'Link Preview Gambar', 'type' => 'url'],
            ],
            'social_media_specialist' => [
                'post_link'        => ['label' => 'Link Postingan yang Tayang', 'type' => 'url'],
                'reach'            => ['label' => 'Jumlah Reach/Views', 'type' => 'number'],
                'engagement'       => ['label' => 'Jumlah Like/Komentar/Share', 'type' => 'number'],
                'report_notes'     => ['label' => 'Catatan Analisis Performa', 'type' => 'textarea'],
            ],
            default => [],
        };
    }
}
