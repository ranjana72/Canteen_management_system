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
     * Checks if the logged-in user has the required role.
     * If not, redirect them to their correct dashboard.
     *
     * Usage in routes:  Route::middleware(['role:admin'])
     *                   Route::middleware(['role:student'])
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // If not logged in at all, send to login page
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // If logged in but wrong role, send to their own dashboard
        if (auth()->user()->role !== $role) {
            return redirect()->route(auth()->user()->role . '.dashboard')
                             ->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }
}