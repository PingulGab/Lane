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
        $affiliateList = Affiliate::whereNotIn('id', [1, 2])->get();

        $link = Link::with([
            'memorandum', 
            'proposalForm', 
            'endorsementForm'
            ])->where('link', $link)->firstOrFail();

        if ($link->endorsementForm) {
            return view('PartnerApplication.InstitutionalUnitView.submitted_view', ['link' => $link, 'memorandum' => $link->memorandum, 'proposalForm'=>$link->proposalForm, 'endorsement'=>$link->endorsementForm]);
        }

        // Load related data if endorsement_form_fk is not present
        $data = [
            'link' => $link,
            'memorandum' => $link->memorandum,
            'proposalForm' => $link->proposalForm,
            'affiliateList' => $affiliateList,
        ];

        return view('PartnerApplication.InstitutionalUnitView.index', $data);

    }

    public function showResultLoginPage($link)
    {

        $data = [
            'link' => $link,
        ];

        return view('PartnerApplication.InstitutionalUnitView.login', $data);
    }
    
    public function submitEndorsementForm(Request $request, $link)
    {
        (new EndorsementFormController())->generateEndorsement($request, $link);

        //TODO Send email to OGR

        return redirect()->route('resultProspectivePartnerForm', $link);
    }
}