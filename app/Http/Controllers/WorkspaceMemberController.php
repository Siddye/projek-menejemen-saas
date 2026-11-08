<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WorkspaceMemberController extends Controller
{
    public function store(Request $request, Workspace $workspace): RedirectResponse
    {
        $user = $request->user();
        if (!$workspace->isOwner($user) && !$workspace->isAdmin($user)) {
            abort(403, 'Hanya Owner atau Admin yang dapat menambahkan anggota.');
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:owner,admin,member'],
            'job_title' => ['nullable', 'string', 'max:100'],
        ]);

        // Find user by email or create new user
        $targetUser = User::where('email', $validated['email'])->first();

        if (!$targetUser) {
            $name = $validated['name'] ?: Str::headline(explode('@', $validated['email'])[0]);
            $targetUser = User::create([
                'name' => $name,
                'email' => $validated['email'],
                'password' => Hash::make('password'),
            ]);
        }

        // Check if already member
        if ($workspace->members()->where('users.id', $targetUser->id)->exists()) {
            return back()->with('error', 'User dengan email tersebut sudah menjadi anggota workspace ini.');
        }

        WorkspaceMember::create([
            'workspace_id' => $workspace->id,
            'user_id' => $targetUser->id,
            'role' => $validated['role'],
            'job_title' => $validated['job_title'],
        ]);

        return back()->with('success', "Anggota {$targetUser->name} berhasil ditambahkan ke workspace sebagai {$validated['role']}.");
    }

    public function destroy(Request $request, Workspace $workspace, User $member): RedirectResponse
    {
        $user = $request->user();
        if (!$workspace->isOwner($user) && !$workspace->isAdmin($user)) {
            abort(403, 'Hanya Owner atau Admin yang dapat menghapus anggota.');
        }

        // Owner cannot be removed
        if ($workspace->owner_id === $member->id) {
            return back()->with('error', 'Pemilik workspace tidak dapat dihapus dari anggota.');
        }

        WorkspaceMember::where('workspace_id', $workspace->id)
            ->where('user_id', $member->id)
            ->delete();

        return back()->with('success', "Anggota {$member->name} berhasil dihapus dari workspace.");
    }
}

