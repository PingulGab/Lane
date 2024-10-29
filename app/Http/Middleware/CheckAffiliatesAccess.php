<?php

namespace App\Http\Middleware;

use App\Models\Document;
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
        $document = Document::with('approvals')->where('id', $request->route('id'))->firstOrFail();

        // Check if the user is authenticated as an affiliate
        $affiliate = Auth::guard('affiliate')->user();

        if (!$affiliate) {
            // Redirect unauthenticated affiliates to the custom affiliate login page
            return redirect()->route('showAffiliateLoginDocument', ['id' => $document->id, 'name' => $document->memorandum->partner_name]);
        }

        // Check if the authenticated affiliate has permission to access this link
        if (!$document->approvals->contains('affiliate_id', $affiliate->id)) {
            // If the affiliate is authenticated but lacks permission, return a 403 response
            return response('Unauthorized', 403);
        }

        //  Check if password change is required
        if ($affiliate->must_change_password) {
            return redirect()->route('showAffiliateChangePasswordDocument', ['id' => $document->id, 'name' => $document->memorandum->partner_name]);
        }

        // Allow access if authenticated and has permission
        return $next($request);
    }
}
