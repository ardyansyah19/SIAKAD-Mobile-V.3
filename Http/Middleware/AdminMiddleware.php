<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Pastikan hanya user dengan role "admin" yang bisa mengakses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus admin.');
        }

        return $next($request);
    }
}
