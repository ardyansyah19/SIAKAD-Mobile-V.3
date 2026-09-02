<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MahasiswaMiddleware
{
    /**
     * Pastikan hanya user dengan role "mahasiswa" yang bisa mengakses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || Auth::user()->role !== 'mahasiswa') {
            abort(403, 'Akses ditolak. Halaman ini khusus mahasiswa.');
        }

        return $next($request);
    }
}
