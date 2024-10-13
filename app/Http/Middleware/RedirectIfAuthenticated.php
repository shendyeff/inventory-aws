<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Ambil role user
                $role = Auth::user()->getRoleNames()->first();

                // Redirect berdasarkan role
                if ($role === 'Admin' || $role === 'Super Admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($role === 'Customer') {
                    return redirect()->route('customer.dashboard');
                }

                // Jika ada role lain, bisa ditambahkan di sini.
            }
        }

        return $next($request);
    }
}
