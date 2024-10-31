<?php

namespace App\Http\Middleware;

use App\Models\Link;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckInstitutionalUnitAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $link = Link::where('link', $request->route('link'))->firstOrFail();

        // Check if the user is authenticated as an institutional unit
        $institutionalUnit = Auth::guard('institutionalUnit')->user();

        if (!$institutionalUnit) {
            // Redirect unauthenticated Institutional Units to the custom affiliate login page
            return redirect()->route('resultLogin', ['link' => $link->link]);
        }

        // Check if the authenticated Institutional Unit has permission to access this link
        if (!$link->institutionalUnits->contains($institutionalUnit->id)) {
            // If the affiliate is authenticated but lacks permission, return a 403 response
            return response('Unauthorized', 403);
        }

        //  Check if password change is required
        if ($institutionalUnit->must_change_password) {
            return redirect()->route('showInstitutionalUnitChangePassword', ['link' => $link->link]);
        }

        // Allow access if authenticated and has permission
        return $next($request);    }
}
