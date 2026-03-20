<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBannedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status == '3') {
            if ($request->routeIs('banned.page')) {
                return $next($request);
            }
            return redirect()->route('banned.page');
        }

        return $next($request);
    }
}
