<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheckMiddleware
{
    public function handle(Request $request, Closure $next, $requiredRole): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $thisRole = auth()->user()->pos;
        if ($requiredRole === 'user') {
            if ($thisRole === 'user') {
                return $next($request);
            } else {
                return redirect()->route('admin');
            }
        }
        if ($requiredRole === 'admin') {
            if ($thisRole !== 'user') {
                return $next($request);
            } else {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
