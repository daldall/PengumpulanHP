<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isSiswa()) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
