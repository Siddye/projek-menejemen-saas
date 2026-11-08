<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create(Workspace $workspace)
    {
        $this->authorizeOwner($workspace);

        return view('projects.create', compact('workspace'));
    }

    public function store(Request $request, Workspace $workspace)
    {
        $this->authorizeOwner($workspace);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'brief' => 'nullable|string',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project = $workspace->projects()->create($data);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyek/campaign berhasil dibuat.');
    }

    public function show(Project $project)
    {
        $project->load(['tasks.assignee', 'workspace']);
        $tasksByStatus = $project->tasks->groupBy('status');

        return view('projects.show', compact('project', 'tasksByStatus'));
    }

    public function edit(Project $project)
    {
        $this->authorizeOwner($project->workspace);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorizeOwner($project->workspace);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'brief' => 'nullable|string',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($data);

        return redirect()->route('projects.show', $project)->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $this->authorizeOwner($project->workspace);
        $workspace = $project->workspace;
        $project->delete();

        return redirect()->route('workspaces.show', $workspace)->with('success', 'Proyek berhasil dihapus.');
    }

    private function authorizeOwner(Workspace $workspace): void
    {
        $member = $workspace->memberOf(auth()->user());
        abort_unless($member && $member->isOwner(), 403, 'Hanya Owner yang bisa melakukan aksi ini.');
    }
}
