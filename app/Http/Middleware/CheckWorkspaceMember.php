<?php

namespace App\Http\Middleware;

use App\Models\Workspace;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWorkspaceMember
{
    /**
     * Pastikan user yang login adalah anggota dari workspace yang diakses.
     * Dipasang di route yang punya parameter {workspace}.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $workspace = $request->route('workspace');

        if ($workspace instanceof Workspace) {
            if (!$workspace->isMember($request->user())) {
                abort(403, 'Anda bukan anggota workspace ini.');
            }
        }

        return $next($request);
    }
}
