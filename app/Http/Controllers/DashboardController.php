<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $memberships = $user->workspaceMembers()
            ->with(['workspace.projects.tasks', 'workspace.members.user'])
            ->get();

        // Tugas yang sedang di-assign ke user ini (lintas workspace)
        $myTasks = $user->assignedTasks()
            ->with(['project.workspace'])
            ->whereIn('status', ['todo', 'in_progress', 'review', 'revisi'])
            ->orderBy('deadline')
            ->get();

        // Workspace yang dia jadi Owner-nya, untuk ringkasan review pending
        $ownedWorkspaceIds = $memberships->where('role', 'owner')->pluck('workspace_id');
        $pendingReviews = \App\Models\Task::whereHas('project', function ($q) use ($ownedWorkspaceIds) {
            $q->whereIn('workspace_id', $ownedWorkspaceIds);
        })->where('status', 'review')->with(['assignee', 'project'])->get();

        return view('dashboard.index', compact('memberships', 'myTasks', 'pendingReviews'));
    }
}
