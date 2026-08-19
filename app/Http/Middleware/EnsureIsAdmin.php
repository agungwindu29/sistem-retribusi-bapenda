<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak. Fitur ini hanya untuk Administrator BAPENDA.'], 403);
            }
            return redirect()->route('dashboard')->with('info', 'Akses ditolak. Fitur ini khusus untuk Administrator BAPENDA.');
        }

        return $next($request);
    }
}
