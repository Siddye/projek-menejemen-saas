<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkspaceMember extends Model
{
    use HasFactory;

    protected $fillable = ['workspace_id', 'user_id', 'role', 'job_title'];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    // Label job_title yang ramah ditampilkan di UI
    public function jobTitleLabel(): string
    {
        return match ($this->job_title) {
            'content_creator' => 'Content Creator',
            'graphic_designer' => 'Graphic Designer',
            'social_media_specialist' => 'Social Media Specialist',
            default => '-',
        };
    }
}
