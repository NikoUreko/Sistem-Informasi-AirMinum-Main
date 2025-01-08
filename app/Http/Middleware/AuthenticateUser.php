<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek jika sesi user_id ada
        if (!$request->session()->has('user_id')) {
            return redirect('/login')->withErrors(['message' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
