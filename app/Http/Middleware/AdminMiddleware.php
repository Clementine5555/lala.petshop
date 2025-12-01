<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // mengijinkan hanya superadmin dan admin
        if (! in_array($user->role, ['superadmin', 'admin'])) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
