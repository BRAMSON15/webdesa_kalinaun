<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Check if account is active
            if (!$user->is_active) {
                auth()->logout();
                return redirect()->route('login')->withErrors(['error' => 'Akun Anda telah dinonaktifkan. Hubungi admin untuk informasi lebih lanjut.']);
            }
        }

        return $next($request);
    }
}
