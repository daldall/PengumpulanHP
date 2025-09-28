<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuruMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isGuru()) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
