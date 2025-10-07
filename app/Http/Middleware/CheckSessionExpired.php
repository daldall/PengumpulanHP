<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpired
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Update last activity time
            session(['last_activity' => time()]);
            
            // Check if session is still valid
            $lastActivity = session('last_activity', time());
            $sessionLifetime = config('session.lifetime') * 60; // Convert to seconds
            
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
        }
        
        return $next($request);
    }
}
