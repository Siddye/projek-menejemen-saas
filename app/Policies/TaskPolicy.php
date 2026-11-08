<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $task->project->workspace->isMember($user);
    }

    public function create(User $user, Project $project): bool
    {
        return $project->workspace->isOwner($user) || $project->workspace->isAdmin($user);
    }

    public function update(User $user, Task $task): bool
    {
        return $task->project->workspace->isOwner($user) || $task->project->workspace->isAdmin($user);
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->project->workspace->isOwner($user) || $task->project->workspace->isAdmin($user);
    }

    public function updateStatus(User $user, Task $task): bool
    {
        // Owner/Admin or the assigned member
        if ($task->assigned_to === $user->id) {
            return true;
        }

        return $task->project->workspace->isOwner($user) || $task->project->workspace->isAdmin($user);
    }

    public function submitReview(User $user, Task $task): bool
    {
        // Assigned member can submit review (or owner/admin)
        if ($task->assigned_to === $user->id) {
            return true;
        }

        return $task->project->workspace->isOwner($user) || $task->project->workspace->isAdmin($user);
    }

    public function validateTask(User $user, Task $task): bool
    {
        // Only owner or admin can approve or request revision
        return $task->project->workspace->isOwner($user) || $task->project->workspace->isAdmin($user);
    }
}

