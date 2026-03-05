<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika user belum login ATAU bukan admin, lempar balik ke daftar seminar
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('seminar.index')->with('error', 'Maaf, halaman ini hanya untuk Admin.');
        }
    
        return $next($request);
    }
}
