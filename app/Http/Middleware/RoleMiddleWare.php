<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleWare
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        return redirect()->route('login')->withErrors(['accessError' => 'Unauthorized access.']);
    }
}