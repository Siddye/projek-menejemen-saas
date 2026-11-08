<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $workspace = $project->workspace;
        $this->authorizeOwner($workspace);

        $members = $workspace->members()->with('user')->where('role', 'member')->get();

        return view('tasks.create', compact('project', 'members'));
    }

    public function store(Request $request, Project $project)
    {
        $workspace = $project->workspace;
        $this->authorizeOwner($workspace);

        $data = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date',
        ]);

        $member = $workspace->members()->where('user_id', $data['assigned_to'])->firstOrFail();

        // Ambil input_data sesuai skema job_title anggota tsb
        $inputSchema = Task::inputSchema($member->job_title);
        $inputData = [];
        foreach ($inputSchema as $key => $field) {
            $inputData[$key] = $request->input("input.$key");
        }

        Task::create([
            ...$data,
            'project_id' => $project->id,
            'created_by' => auth()->id(),
            'job_title' => $member->job_title,
            'input_data' => $inputData,
            'status' => 'todo',
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Tugas berhasil dibuat dan di-assign.');
    }

    public function show(Task $task)
    {
        $task->load(['project.workspace', 'assignee', 'creator', 'revisions.creator']);

        return view('tasks.show', compact('task'));
    }

    // Anggota update progres + isi output kerja (sesuai job_title mereka)
    public function updateWork(Request $request, Task $task)
    {
        abort_unless($task->assigned_to === auth()->id(), 403, 'Ini bukan tugas Anda.');

        $data = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $outputSchema = Task::outputSchema($task->job_title);
        $outputData = $task->output_data ?? [];
        foreach ($outputSchema as $key => $field) {
            if ($request->has("output.$key")) {
                $outputData[$key] = $request->input("output.$key");
            }
        }

        $status = $task->status;
        if ($status === 'todo' && $data['progress'] > 0) {
            $status = 'in_progress';
        }

        $task->update([
            'progress' => $data['progress'],
            'output_data' => $outputData,
            'status' => $status,
        ]);

        return back()->with('success', 'Progres & hasil kerja berhasil disimpan.');
    }

    // Anggota ajukan tugas untuk direview Owner
    public function submitReview(Task $task)
    {
        abort_unless($task->assigned_to === auth()->id(), 403, 'Ini bukan tugas Anda.');

        $task->update(['status' => 'review', 'progress' => 100]);

        return back()->with('success', 'Tugas diajukan untuk direview Owner.');
    }

    private function authorizeOwner(Workspace $workspace): void
    {
        $member = $workspace->memberOf(auth()->user());
        abort_unless($member && $member->isOwner(), 403, 'Hanya Owner yang bisa melakukan aksi ini.');
    }
}
