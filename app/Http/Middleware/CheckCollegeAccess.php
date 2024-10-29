<?php

namespace App\Http\Middleware;

use App\Models\Link;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckCollegeAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $link = Link::where('link', $request->route('link'))->firstOrFail();

        // Check if the user is authenticated as an college
        $college = Auth::guard('college')->user();

        if (!$college) {
            // Redirect unauthenticated colleges to the custom affiliate login page
            return redirect()->route('resultLogin', ['link' => $link->link]);
        }

        // Check if the authenticated college has permission to access this link
        if (!$link->colleges->contains($college->id)) {
            // If the affiliate is authenticated but lacks permission, return a 403 response
            return response('Unauthorized', 403);
        }

        //  Check if password change is required
        if ($college->must_change_password) {
            return redirect()->route('showCollegeChangePassword', ['link' => $link->link]);
        }

        // Allow access if authenticated and has permission
        return $next($request);    }
}
