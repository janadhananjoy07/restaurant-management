<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Example check: Ensure user is logged in and is a standard user
        if (!auth()->check() || auth()->user()->role !== 'user') {
            return redirect('/login');
        }

        return $next($request);
    }
}
