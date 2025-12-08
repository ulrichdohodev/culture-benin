<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Roles can be passed as a comma separated list, e.g. "admin,moderator"
     */
    public function handle(Request $request, Closure $next, $roles = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$roles) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user && method_exists($user, 'hasRole') && $user->hasRole($roles)) {
            return $next($request);
        }

        // Fallback: allow moderators to access admin read/write pages (but NOT deletes)
        // This ensures moderators can access most admin menus even if a route was left with 'role:admin'.
        if ($user && method_exists($user, 'isModerator') && $user->isModerator()) {
            $routeName = optional($request->route())->getName();

            // Disallow moderators from accessing user/role management pages
            if ($routeName && (str_starts_with($routeName, 'admin.utilisateurs') || str_starts_with($routeName, 'admin.roles'))) {
                abort(403, 'Accès non autorisé.');
            }

            // Disallow moderators from performing DELETE requests
            if ($request->isMethod('DELETE')) {
                abort(403, 'Accès non autorisé.');
            }

            // Otherwise allow the request for moderators
            return $next($request);
        }

        // No special fallback for contributors: only roles explicitly allowed
        // (admin, moderator) can access the protected routes. Contributors
        // should be restricted by the same role checks and not receive
        // implicit allowances here.

        abort(403, 'Accès non autorisé.');
    }
}
