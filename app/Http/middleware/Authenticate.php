<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // Steering Committee
            if ($request->is('sc/*') && !auth()->guard('sc')->check()) {
                return route('sc.login');
            }

            // Member
            if (($request->is('dashboard-anggota') || $request->is('member/*')) && !auth()->guard('member')->check()) {
                return route('login');
            }

            // Admin (Filament)
            return route('filament.admin.auth.login');
        }

        // Jika semua guard valid, tidak redirect
        return null;
    }
}
