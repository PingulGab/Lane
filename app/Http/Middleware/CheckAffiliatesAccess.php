<?php

namespace App\Http\Middleware;

use App\Models\Link;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAffiliatesAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the link from the route
        $link = Link::where('link', $request->route('link'))->firstOrFail();

        // Check if the user is authenticated as an affiliate
        $affiliate = Auth::guard('affiliate')->user();

        if (!$affiliate) {
            // Redirect unauthenticated affiliates to the custom affiliate login page
            return redirect()->to('affiliate/login/' . $link->link);
        }

        // Check if the authenticated affiliate has permission to access this link
        if (!$link->affiliates->contains($affiliate->id)) {
            // If the affiliate is authenticated but lacks permission, return a 403 response
            return response('Unauthorized', 403);
        }

        //  Check if password change is required
        if ($affiliate->must_change_password) {
            return redirect()->to('affiliate/change-password/' . $link->link);
        }

        // Allow access if authenticated and has permission
        return $next($request);
    }
}
