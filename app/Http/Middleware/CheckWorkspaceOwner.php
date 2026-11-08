<?php

namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\Workspace;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWorkspaceOwner
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $workspaceId = $request->route('workspace') ?? $request->route('workspace_id');

        if (!$workspaceId && $request->route('project')) {
            $projectId = $request->route('project');
            $project = $projectId instanceof Project ? $projectId : Project::find($projectId);
            $workspaceId = $project?->workspace_id;
        }

        if ($workspaceId) {
            $workspace = $workspaceId instanceof Workspace ? $workspaceId : Workspace::find($workspaceId);

            if (!$workspace || (!$workspace->isOwner($user) && !$workspace->isAdmin($user))) {
                abort(403, 'Akses ditolak. Fitur ini hanya dapat diakses oleh Owner / Admin workspace.');
            }
        }

        return $next($request);
    }
}

