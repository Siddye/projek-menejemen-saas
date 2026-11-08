<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        return $project->workspace->isMember($user);
    }

    public function create(User $user, Workspace $workspace): bool
    {
        return $workspace->isOwner($user) || $workspace->isAdmin($user);
    }

    public function update(User $user, Project $project): bool
    {
        return $project->workspace->isOwner($user) || $project->workspace->isAdmin($user);
    }

    public function delete(User $user, Project $project): bool
    {
        return $project->workspace->isOwner($user) || $project->workspace->isAdmin($user);
    }
}

