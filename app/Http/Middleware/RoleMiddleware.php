<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. If user is not logged in, send to login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. If user is logged in but has the WRONG role, show 403 Forbidden
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        // 3. Allow request to proceed
        return $next($request);
    }
}