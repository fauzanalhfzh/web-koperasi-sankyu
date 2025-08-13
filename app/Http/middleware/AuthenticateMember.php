<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateMember
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('member')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
