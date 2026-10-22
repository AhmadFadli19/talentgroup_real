<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Allow admin by role_id == 1 or role name == 'admin'
        if ($role === 'admin' && ($user->isAdmin() || ($user->role && strtolower($user->role->name) === 'admin'))) {
            return $next($request);
        }

        if (!$user->role || strtolower($user->role->name) !== strtolower($role)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}