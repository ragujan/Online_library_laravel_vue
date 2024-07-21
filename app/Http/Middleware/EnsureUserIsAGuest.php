<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAGuest
{

    public function handle(Request $request, Closure $next): Response
    {
        // if the user is not logged in, then proceed else redirect to home page
        if (!Auth::check()) {
            return $next($request);
        } else {
            return redirect()->intended('browse-books');
        }
    }
}
