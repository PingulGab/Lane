<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProspectivePartnerResultController extends Controller
{
    public function resultProspectivePartnerForm($link)
    {
        $link = Link::with([
            'memorandum', 
            'proposalForm', 
            'endorsementForm'
            ])->where('link', $link)->firstOrFail();

        // Load related data if available
        $data = [
            'link' => $link,
            'memorandum' => $link->memorandum,
            'proposalForm' => $link->proposalForm,
        ];

        if ($link->endorsement_form_fk)
        {
            return redirect()->route('viewEndorsement', ['link' => $link->link]);
        }
        
        return view('PartnerApplication.CollegeView.resultView', $data);
    }

    public function showResultLoginPage($link)
    {

        $data = [
            'link' => $link,
        ];

        return view('PartnerApplication.CollegeView.resultAffiliateLogin', $data);
    }
}