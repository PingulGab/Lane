<?php

namespace App\Http\Controllers;

use App\Mail\ProspectivePartnerFormSubmitted;
use App\Models\College;
use App\Models\Document;
use App\Models\DocumentApproval;
use App\Models\Link;
use App\Models\Memorandum;
use App\Models\ProposalForm;
use App\Models\EndorsementForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Affiliate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ProspectivePartnerFormController extends Controller
{    
    // Display the link page
    public function prospectPartnerViewLink($link)
    {
        $link = Link::where('link', $link)->firstOrFail();
        $collegeList = College::all();
        $affiliateList = Affiliate::all();

        // Check if the user is authenticated and if session timestamp exists
        $authSessionKey = "authenticated_{$link->id}";
        $authTimestampKey = "authenticated_{$link->id}_time";

        if (Session::has($authSessionKey) && Session::has($authTimestampKey)) {
            $authenticatedTime = Carbon::parse(Session::get($authTimestampKey));

            // Check if the session has expired (after 1 hour)
            if ($authenticatedTime->diffInMinutes(now()) <= 180) {
                // Session is valid, show protected content
                if ($link->isActive == false)
                {
                    return redirect()->route('prospectPartnerViewSubmittedForm', $link->link);
                } else {
                    return view('PartnerApplication.PartnerView.partnershipApplicationForm_View', ['link' => $link, 'collegesList' => $collegeList, 'affiliateList' => $affiliateList]);
                }
            } else {
                // Session expired, remove the session variables
                Session::forget($authSessionKey);
                Session::forget($authTimestampKey);
            }
        }

        // If not authenticated or session expired, show the password form
        return view('PartnerApplication.PartnerView.partnershipApplicationForm_Password', ['link' => $link]);
    }
    
    // Validate the password entered by the user
    public function validateProspectPartnerPassword(Request $request, $link)
    {
        $link = Link::where('link', $link)->firstOrFail();

        if (password_verify($request->password, $link->password)) {
            // Password is correct, store authentication status in session
            $authSessionKey = "authenticated_{$link->id}";
            $authTimestampKey = "authenticated_{$link->id}_time";

            Session::put($authSessionKey, true);
            Session::put($authTimestampKey, now()); // Store the current time for expiry check

            // Redirect back to the same link (so the content is displayed)
            return redirect()->route('prospectPartnerViewLink', $link->link);
        }

        // Password is incorrect, return back with an error
        return back()->withErrors(['password' => 'Invalid password.']);
    }

    // Display the link page
    public function prospectPartnerViewSubmittedForm($link)
    {
        $link = Link::where('link', $link)->firstOrFail();

        $data = [
            'link' => $link,
            'memorandum' => $link->memorandum,
            'proposalForm' => $link->proposalForm,
        ];

        // Check if the user is authenticated and if session timestamp exists
        $authSessionKey = "authenticated_{$link->id}";
        $authTimestampKey = "authenticated_{$link->id}_time";

        if (Session::has($authSessionKey) && Session::has($authTimestampKey)) {
            $authenticatedTime = Carbon::parse(Session::get($authTimestampKey));

            // Check if the session has expired (after 1 hour)
            if ($authenticatedTime->diffInMinutes(now()) <= 180) {
                // Session is valid, show protected content
                return view('PartnerApplication.PartnerView.submittedForm_View', $data);
            } else {
                // Session expired, remove the session variables
                Session::forget($authSessionKey);
                Session::forget($authTimestampKey);
            }
        }

        // If not authenticated or session expired, show the password form
        return view('PartnerApplication.PartnerView.submittedForm_Password', ['link' => $link]);
    }
    
    // Validate the password entered by the user
    public function validatePasswordSubmittedForm(Request $request, $link)
    {
        $link = Link::where('link', $link)->firstOrFail();

        if (password_verify($request->password, $link->password)) {
            // Password is correct, store authentication status in session
            $authSessionKey = "authenticated_{$link->id}";
            $authTimestampKey = "authenticated_{$link->id}_time";

            Session::put($authSessionKey, true);
            Session::put($authTimestampKey, now()); // Store the current time for expiry check

            // Redirect back to the same link (so the content is displayed)
            return redirect()->route('prospectPartnerViewSubmittedForm', $link->link);
        }

        // Password is incorrect, return back with an error
        return back()->withErrors(['password' => 'Invalid password.']);
    }
    public function submitProspectPartnerForm(Request $request, $link)
    {
        $link = Link::where('link', $link)->firstOrFail();
    
        $selectedColleges = $request->input('selected_colleges', []);
        $selectedAffiliates = $request->input('selected_affiliates', []);
    
        // Step 1: Create Memorandum and Proposal Form
        $memorandum = Memorandum::create([
            'partner_name' => $request->input('partner_name'),
        ]);
    
        $proposalForm = ProposalForm::create([
            'country' => $request->input('country'),
            'institution_name' => $request->input('institution_name'),
        ]);
    
        // Step 2: Link Memorandum and Proposal Form to the Link model
        $link->update([
            'memorandum_fk' => $memorandum->id,
            'proposal_form_fk' => $proposalForm->id,
            'isActive' => false,
        ]);
    
        // Sync selected colleges with the link
        $link->colleges()->sync($selectedColleges);
        $link->affiliates()->sync($selectedAffiliates);
    
        // Optionally send email after submission
        //TODO Mail::to('janjanpingul@gmail.com')->send(new ProspectivePartnerFormSubmitted($link));
    
        return response()->json(['message' => 'Form submitted successfully, and approval tracking initiated.']);
    }
}