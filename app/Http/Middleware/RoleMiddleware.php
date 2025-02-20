<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware {
    public function handle(Request $request, Closure $next, $role): Response {
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect('/')->withErrors(['access' => 'Anda tidak memiliki akses ke halaman ini.']);
        }
        return $next($request);
    }
}