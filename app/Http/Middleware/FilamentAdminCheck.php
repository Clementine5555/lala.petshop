<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilamentAdminCheck
{
    /**
     * Handle an incoming request.
     * Cek bahwa user adalah admin sebelum akses Filament.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login, redirect ke filament login
        if (!Auth::check()) {
            return redirect()->route('filament.admin_lala.auth.login');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cek apakah user adalah admin
        if (!$user->is_admin) {
            // User bukan admin, logout dan redirect ke login
            Auth::logout();
            
            return response()
                ->view('errors.403', ['message' => 'Anda tidak memiliki akses ke dashboard admin. Hanya admin yang dapat mengakses area ini.'], 403);
        }

        // User adalah admin, lanjutkan request
        return $next($request);
    }
}
