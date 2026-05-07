<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // kalau belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // kalau bukan admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin');
        }

        return $next($request);
    }
}
