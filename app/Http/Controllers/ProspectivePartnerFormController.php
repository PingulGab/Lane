<?php

namespace App\Http\Controllers;

use App\Mail\ProspectivePartnerFormSubmitted;
use App\Models\Link;
use App\Models\Memorandum;
use App\Models\ProposalForm;
use App\Models\EndorsementForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProspectivePartnerFormController extends Controller
{    
    public function submitForm(Request $request, $link)
    {
        $validatedData = $request->validate([
            'description_1' => 'required|string|max:255',
            'description_2' => 'required|string|max:255',
        ]);

        $link = Link::where('link', $link)->firstOrFail();

        $memorandum = Memorandum::create([
            'partner_name' => $request->input('partner_name'),
        ]);

        $proposalForm = ProposalForm::create([
            'country' => $request->input('country'),
            'institution_name' => $request->input('institution_name'),
        ]);

        $endorsement = new EndorsementForm();
        $endorsement->Description_1 = $validatedData['description_1'];
        $endorsement->Description_2 = $validatedData['description_2'];
        $endorsement->save();

        $link->update([
            'memorandum_fk' => $memorandum->id,
            'proposal_form_fk' => $proposalForm->id,
            'endorsement_form_fk' => $endorsement->id,
            'isActive' => false,
        ]);

        Mail::to('janjanpingul@gmail.com')->send(new ProspectivePartnerFormSubmitted($link));

        return response()->json(['message' => 'Form submitted successfully.']);
    }
}