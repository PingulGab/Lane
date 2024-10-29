<?php

namespace App\Http\Controllers;

use App\Mail\startAdminApproval;
use App\Models\Document;
use App\Models\DocumentApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
        if($document->is_ogr_approved){
            return view('Documents.viewDocument', [ 'document' => $document, 'id' => $id]);
        } else {
            return view('PartnerApplication.OGRView.pendingOGRApproval', [ 'document' => $document, 'id' => $id]);
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

        return redirect()->route('showDocument', ['id' => $id, 'name' => $document->memorandum->partner_name]);
    }

    public function affiliateShowDocument($id, $name)
    {
        $document = Document::with('approvals')->where('id', $id)->firstOrFail();

        $affiliate = Auth::guard('affiliate')->user();

        $documentApproval = DocumentApproval::where('document_id', $id)
        ->where('affiliate_id', $affiliate->id)
        ->firstOrFail();

        if($documentApproval->is_approved){
            return view('PartnerApplication.AffiliateView.approvedView', ['id' => $id, 'document' => $document]);
        } else {
            return view('PartnerApplication.AffiliateView.index', ['id' => $id, 'document' => $document]);
        }        
    }

    public function affiliateApproveDocument($id, $name)
    {
        $document = Document::with('approvals')->where('id', $id)->firstOrFail();

        //Retrieve the Logged in Affiliate
        $affiliate = Auth::guard('affiliate')->user();

        // Find the specific DocumentApproval record for the affiliate and document.
        $documentApproval = DocumentApproval::where('document_id', $id)
        ->where('affiliate_id', $affiliate->id)
        ->firstOrFail();

        // Updating the Table
        $documentApproval->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return redirect()->route('affiliateShowDocument', ['id' => $id, 'name' => $name]);
    }
}
