<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpired
{
    public function handle(Request $request, Closure $next)
    {
        // Skip session check for login routes
        if ($request->is('login') || $request->is('/') || $request->is('refresh-csrf')) {
            return $next($request);
        }

        if (Auth::check()) {
            // Get last activity, default to current login time if not set
            $lastActivity = session('last_activity', Auth::user()->created_at->timestamp ?? time());
            $sessionLifetime = config('session.lifetime') * 60; // Convert to seconds

            // Check if session has expired
            if (time() - $lastActivity > $sessionLifetime) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Session expired. Please login again.',
                        'expired' => true
                    ], 401);
                }

                return redirect()->route('login')
                    ->with('error', 'Session Anda telah berakhir. Silakan login kembali.');
            }

            // Update last activity time for valid sessions
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
