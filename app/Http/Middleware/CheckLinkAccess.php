<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use App\Models\Link;

class CheckLinkAccess
{
    public function handle($request, Closure $next)
    {
        // Retrieve the link from the URL parameter
        $link = Link::where('link', $request->route('link'))->first();

        // If the link does not exist, return a 404 response
        if (!$link) {
            abort(404, 'Link not found');
        }

        // Check if the link is active and requires a password
        if ($link->isActive) {
            if ($request->input('password') && Hash::check($request->input('password'), $link->password)) {
                return $next($request);
            } else {
                return response('Unauthorized. Password required.', 403);
            }
        }

        // If the link is not active, check for department authentication
        if (!$link->isActive && auth()->check() && auth()->user()->is_department) {
            return $next($request);
        }

        // Redirect to login if neither condition is met
        return redirect('login');
    }
}
