<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsMahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isMahasiswa()) {
            return $next($request);
        }

        if (Auth::check()) {
            // Logged in as Admin, redirect to Admin Dashboard
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            abort(403, 'Aksi tidak sah. Hanya untuk mahasiswa.');
        }

        return redirect()->route('login');
    }
}
