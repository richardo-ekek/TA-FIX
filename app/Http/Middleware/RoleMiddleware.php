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
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah pengguna belum login
        if (!auth()->check()) {
            return redirect('/login'); // Lempar ke halaman login
        }

        // 2. Cek apakah role pengguna ada di dalam daftar role yang diizinkan ($roles)
        if (!in_array(auth()->user()->role, $roles)) {
            // Jika rolenya tidak cocok, tolak dengan error 403 (Forbidden)
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk melihat halaman ini.');
        }

        // 3. Jika login dan rolenya cocok, silakan masuk
        return $next($request);
    }
}