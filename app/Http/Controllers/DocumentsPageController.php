<?php

namespace App\Http\Controllers;

use App\Mail\startAdminApproval;
use App\Models\Document;
use App\Models\DocumentApproval;
use App\Models\Memorandum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\EndorsementFormCreated;
use Mail;

class DocumentsPageController extends Controller
{
    public function documents()
    {
        if (request()->ajax()) {
            return view('Documents.index'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('Documents.index')
        ]);
    }

    public function showDocument($id)
    {
        $document = Document::with(['memorandum', 'endorsementForm', 'proposalForm', 'approvals.affiliate'])->findOrFail($id);
        
        if($document->is_ogr_approved && !$document->is_signed){
            return view('Documents.viewDocument', [ 'document' => $document, 'id' => $id]);
        }
        
        if(!$document->is_ogr_approved){
            return view('PartnerApplication.OGRView.pendingOGRApproval', [ 'document' => $document, 'id' => $id]);
        }

        if($document->is_signed)
        {
            return view('PartnerApplication.OGRView.signedDocument.index', ['document' => $document]);
        }
        
    }
    public function approveDocument($id)
    {
        $document = Document::with(['memorandum', 'endorsementForm', 'proposalForm', 'approvals.affiliate'])->findOrFail($id);

        $document->update([
            'is_ogr_approved' => true,
        ]);

        /* //TODO Email Sending
        // Fetch affiliates related to the document approvals
        $affiliates = $document->approvals->map(function ($approval) {
            return $approval->affiliate;
        });

        // Send email notification to each affiliate
        foreach ($affiliates as $affiliate) {
            Mail::to($affiliate->email)->send(new startAdminApproval($document));
        } */

        return redirect()->route('showDocument', ['id' => $id, 'name' => $document->proposalForm->institution_name]);
    }
    public function affiliateShowDocument($id, $name)
    {
        $document = Document::with('approvals')->where('id', $id)->firstOrFail();

        $affiliate = Auth::guard('affiliate')->user();

        $documentApproval = DocumentApproval::where('document_id', $id)
        ->where('affiliate_id', $affiliate->id)
        ->firstOrFail();

        $currentVersion = $document->memorandum->version;

        if($documentApproval->is_approved){
            return view('PartnerApplication.AffiliateView.approvedView', ['id' => $id, 'document' => $document, 'currentVersion' => $currentVersion]);
        } else {
            return view('PartnerApplication.AffiliateView.index', ['id' => $id, 'document' => $document, 'currentVersion' => $currentVersion]);
        }        
    }

    public function affiliateApproveDocument($id, $name)
    {
        $document = Document::with('approvals')->where('id', $id)->firstOrFail();
    
        // Retrieve the logged-in affiliate
        $affiliate = Auth::guard('affiliate')->user();
    
        // Find the specific DocumentApproval record for the affiliate and document.
        $documentApproval = DocumentApproval::where('document_id', $id)
            ->where('affiliate_id', $affiliate->id)
            ->firstOrFail();
    
        // Check if all approvals at the current stage (approval_order) are completed.
        $currentOrder = $documentApproval->approval_order;
    
        $pendingPriorApprovals = DocumentApproval::where('document_id', $id)
            ->where('approval_order', '<', $currentOrder)
            ->where('is_approved', false)
            ->count();
    
        // Error if Mandatory Affiliates (DPO and Legal) tried to access without the approval of all VPOs
        if ($pendingPriorApprovals > 0) {
            return redirect()->back()->withErrors('All prior approvals must be completed before your approval.');
        }
    
        // Updating the table to mark as approved
        $documentApproval->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    
        // Check if there are any pending approvals in the current order
        $pendingApprovalIsInCurrentOrder = DocumentApproval::where('document_id', $id)
            ->where('approval_order', $currentOrder)
            ->where('is_approved', false)
            ->count();
    
        // Notify next stage if all approvals in the current order are completed
        if ($pendingApprovalIsInCurrentOrder === 0) {
            $nextOrder = $currentOrder + 1;
            $nextApprovals = DocumentApproval::where('document_id', $id)
                ->where('approval_order', $nextOrder)
                ->where('is_notified', false)
                ->get();
    
            foreach ($nextApprovals as $nextApproval) {
                // Send email to next affiliate
                $affiliateToNotify = $nextApproval->affiliate;
                //Mail::to($affiliateToNotify->email)->send(new EndorsementFormCreated($document));
    
                // Mark as notified
                $nextApproval->update(['is_notified' => true]);
            }
        }
    
        // **New Code: Check if the current affiliate is the last stage (Legal)**
        $isLastApproval = DocumentApproval::where('document_id', $id)
            ->where('is_approved', false)
            ->count() === 0;
    
        // Send final email notification if this was the last required approval (Legal office)
        if ($isLastApproval && $affiliate->name === 'Legal Counsel') {
            // Customize and send a final approval completed email notification
            Mail::to($document->institutionalUnits->email)->send(new EndorsementFormCreated($document));
        }
    
        return redirect()->route('affiliateShowDocument', ['id' => $id, 'name' => $name]);
    }

    public function approveSignedDocument($id, $name)
    {
        //TODO This is where the function that registers the document as a PARTNERSHIP.
    }
}
