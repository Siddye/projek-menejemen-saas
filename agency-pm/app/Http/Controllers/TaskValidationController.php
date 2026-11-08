<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskValidationController extends Controller
{
    public function approve(Task $task)
    {
        $this->authorizeOwner($task);

        $task->update(['status' => 'done', 'progress' => 100]);

        return back()->with('success', 'Tugas disetujui dan dinyatakan selesai.');
    }

    public function requestRevision(Request $request, Task $task)
    {
        $this->authorizeOwner($task);

        $data = $request->validate([
            'note' => 'required|string',
        ]);

        $task->update(['status' => 'revisi']);

        $task->revisions()->create([
            'created_by' => auth()->id(),
            'note' => $data['note'],
        ]);

        return back()->with('success', 'Tugas dikembalikan untuk revisi.');
    }

    private function authorizeOwner(Task $task): void
    {
        $workspace = $task->project->workspace;
        $member = $workspace->memberOf(auth()->user());
        abort_unless($member && $member->isOwner(), 403, 'Hanya Owner yang bisa memvalidasi tugas.');
    }
}
