<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'workspace_id', 'name', 'client_name', 'brief', 'start_date', 'deadline',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function progressPercent(): int
    {
        $total = $this->tasks()->count();
        if ($total === 0) return 0;
        $done = $this->tasks()->where('status', 'done')->count();
        return (int) round(($done / $total) * 100);
    }

    public function isLate(): bool
    {
        return $this->deadline && $this->deadline->isPast() && $this->progressPercent() < 100;
    }
}
