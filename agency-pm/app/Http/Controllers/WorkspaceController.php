<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function index(Request $request)
    {
        $workspaces = $request->user()->workspaceMembers()->with('workspace')->get()->pluck('workspace');

        return view('workspaces.index', compact('workspaces'));
    }

    public function create()
    {
        return view('workspaces.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'agency_name' => 'nullable|string|max:255',
        ]);

        $workspace = Workspace::create([
            ...$data,
            'owner_id' => $request->user()->id,
        ]);

        // Owner otomatis jadi anggota dengan role owner
        WorkspaceMember::create([
            'workspace_id' => $workspace->id,
            'user_id' => $request->user()->id,
            'role' => 'owner',
        ]);

        return redirect()->route('workspaces.show', $workspace)
            ->with('success', 'Workspace berhasil dibuat.');
    }

    public function show(Workspace $workspace)
    {
        $workspace->load(['projects.tasks', 'members.user']);

        return view('workspaces.show', compact('workspace'));
    }

    public function addMember(Request $request, Workspace $workspace)
    {
        $this->authorizeOwner($workspace, $request);

        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'job_title' => 'required|in:content_creator,graphic_designer,social_media_specialist',
        ]);

        $user = User::where('email', $data['email'])->first();

        if ($workspace->isMember($user)) {
            return back()->withErrors(['email' => 'User sudah jadi anggota workspace ini.']);
        }

        WorkspaceMember::create([
            'workspace_id' => $workspace->id,
            'user_id' => $user->id,
            'role' => 'member',
            'job_title' => $data['job_title'],
        ]);

        return back()->with('success', $user->name . ' berhasil ditambahkan ke workspace.');
    }

    public function removeMember(Request $request, Workspace $workspace, WorkspaceMember $member)
    {
        $this->authorizeOwner($workspace, $request);

        if ($member->role === 'owner') {
            return back()->withErrors(['member' => 'Owner tidak bisa dihapus dari workspace.']);
        }

        $member->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
    }

    private function authorizeOwner(Workspace $workspace, Request $request): void
    {
        $member = $workspace->memberOf($request->user());
        abort_unless($member && $member->isOwner(), 403, 'Hanya Owner yang bisa melakukan aksi ini.');
    }
}
