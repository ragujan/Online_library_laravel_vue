<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        } else {
            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect()->intended('login');
        }
    }
}
