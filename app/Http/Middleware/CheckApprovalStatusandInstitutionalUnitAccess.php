<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Symfony\Component\HttpFoundation\Response;

class CheckApprovalStatusandInstitutionalUnitAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve document by ID from the route
        $documentId = $request->route('id');
        $document = Document::with('approvals')->findOrFail($documentId);

        // Get the logged-in Institutional Unit user
        $institutionalUnit = Auth::guard('institutionalUnit')->user();

        if (!$institutionalUnit) {
            // Redirect to login if user is not authenticated
            return redirect()->route('signPendingLogin',['id' => $documentId, 'name' => $document->memorandum->partner_name]);
        }

        // Check if the logged-in user is the one assigned in the document's institutional_unit_id
        if ($document->institutional_unit_id !== $institutionalUnit->id) {
            return response('Unauthorized', 403);
        }

        // Check if all DocumentApprovals for the document are approved
        $allApproved = $document->approvals->every(fn($approval) => $approval->is_approved);

        // Optionally, check if is_ogr_approved is true
        if (!$allApproved || !$document->is_ogr_approved) {
            return response('Document approval is incomplete or OGR approval is pending.', 403);
        }

        // Proceed if all checks pass
        return $next($request);
    }
}
