<?php

namespace App\Http\Controllers;

use App\Models\ContactPerson;
use App\Models\Link;
use App\Models\PartnerLinkage;
use App\Models\ProposalForm;
use Dompdf\Options;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Memorandum;
use Carbon\Carbon;

use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\IOFactory;

class ProposalFormController extends Controller
{
    public function create()
    {
        if (request()->ajax()) {
            return view('generate_proposalForm.proposal_create'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('generate_proposalForm.proposal_create')
        ]);
    }

    public function generateProposalForm(Request $request)
    {
        // Validate all the inputs from the multi-step form
        $validatedData = $request->validate([
            'institution_name' => 'required|string|max:255',
            'institution_name_acronym' => 'required|string|max:255',
            'institution_head' => 'required|string|max:255',
            'institution_head_title' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'accreditations' => 'array|nullable',
            'accreditations.*' => 'nullable|string|max:1000',
            'type_of_institution' => 'required|string|in:Private Higher Educational Institution,Public Higher Educational Institution,Private Company,Public Company,Organization,Government Agency',
            'email' => 'required|email|max:255',
            'telephone_number' => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'institution_overview' => 'nullable|string',
            'target_participant' => 'required|string|in:Student,Faculty,Researcher',
            'target_level' => 'required|string|in:Elementary,Junior High School,Senior High School,Undergraduate,Graduate School,Certification Program (ESL)',
            'selected_institutionalUnit' => 'nullable|exists:institutional_units,id',
            'type_of_partnership' => 'required|string',
            'partnership_overview' => 'required|string',
            'partnership_expected_outcome' => 'required|string',
            'partnership_target_participants' => 'required|string',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email|max:255',
            'contact_person_position' => 'required|string|max:255',
            'contact_person_office' => 'required|string|max:255',
            'contact_person_telephone_number' => 'nullable|string|max:20',
            'contact_person_mobile_number' => 'nullable|string|max:20',
        
            // Validate each partner_linkages entry
            'partner_linkagess' => 'array|nullable',
            'partner_linkagess.*.institution_name' => 'string|max:255|nullable',
            'partner_linkagess.*.nature_of_partnership' => 'string|max:255|nullable',
            'partner_linkagess.*.validity_period' => 'date|nullable',
        ]);
        
    

        // Step 1: Create or Retrieve Contact Person
        $contactPerson = ContactPerson::updateOrCreate(
            ['email' => $validatedData['contact_person_email']], // Unique identifier
            [
                'name' => $validatedData['contact_person_name'],
                'position' => $validatedData['contact_person_position'],
                'office' => $validatedData['contact_person_office'],
                'telephone_number' => $validatedData['contact_person_telephone_number'],
                'mobile_number' => $validatedData['contact_person_mobile_number'],
            ]
        );

        // Check if 'accreditations' is set and is an array
        if (isset($validatedData['accreditations']) && is_array($validatedData['accreditations'])) {
            // Filter out null or empty values
            $filteredAccreditations = array_filter($validatedData['accreditations'], function($value) {
                return !is_null($value) && trim($value) !== '';
            });

            // Convert to JSON or null if empty
            $institution_accreditation = empty($filteredAccreditations) ? null : json_encode($filteredAccreditations);
        } else {
            $institution_accreditation = null; // Set to null if not present
        }

        // Step 2: Create the Proposal Form
        $proposal = ProposalForm::create([
            'institution_name' => $validatedData['institution_name'],
            'institution_name_acronym' => $validatedData['institution_name_acronym'],
            'institution_head' => $validatedData['institution_head'],
            'institution_head_title' => $validatedData['institution_head_title'],
            'country' => $validatedData['country'],
            'institution_accreditation' => $institution_accreditation,
            'type_of_institution' => $validatedData['type_of_institution'],
            'email' => $validatedData['email'],
            'telephone_number' => $validatedData['telephone_number'],
            'mobile_number' => $validatedData['mobile_number'],
            'website' => $validatedData['website'],
            'address' => $validatedData['address'],
            'institution_overview' => $validatedData['institution_overview'],
            'target_participant' => $validatedData['target_participant'],
            'target_level' => $validatedData['target_level'],
            'institutional_unit_id' => $validatedData['selected_institutionalUnit'],
            'type_of_partnership' => $validatedData['type_of_partnership'],
            'partnership_overview' => $validatedData['partnership_overview'],
            'partnership_expected_outcome' => $validatedData['partnership_expected_outcome'],
            'partnership_target_participants' => $validatedData['partnership_target_participants'],
            'contact_person_id' => $contactPerson->id,
        ]);
        
        // Step 3: Store each partner_linkages in the PartnerLinkage table
        if (!empty($validatedData['partner_linkagess'])) { // Check if partner_linkagess is not empty
            foreach ($validatedData['partner_linkagess'] as $partner_linkages) {
                // Check if necessary fields are not empty
                if (!empty($partner_linkages['institution_name']) || 
                    !empty($partner_linkages['nature_of_partnership']) || 
                    !empty($partner_linkages['validity_period'])) {
                    
                    PartnerLinkage::create([
                        'institution_name' => $partner_linkages['institution_name'],
                        'nature_of_partnership' => $partner_linkages['nature_of_partnership'],
                        'validity_period' => $partner_linkages['validity_period'],
                        'proposal_form_id' => $proposal->id,
                    ]);
                }
            }
        }
        
        $link_id = session('link_id');
        $link = Link::where('id', $link_id)->firstOrFail();
        session()->forget('link_id');
        
        // Generate the file name: AUF-MOA-[partner_name]-[datecreated]
        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-ProposalForm-' . str_replace(' ', '-', $proposal->institution_name) . '-' . $dateCreated;
    
        // Step 2: Link Memorandum and Proposal Form to the Link model
        $link->update([
            'proposal_form_fk' => $proposal->id,
        ]); 
        
        //Sync to institutional_unit_link
        $link->institutionalUnits()->sync($validatedData['selected_institutionalUnit']);
        
        // Generate the PDF using DOMPDF        
        $dompdf = new Dompdf();
        $html = view('components.proposal_form._proposal_form_preview', [
            'link' => $link
        ])->render();    
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::put('public/proposal-form/' . $fileName . '.pdf', $dompdf->output());
    
        // Redirect to the view page after generating the document
        return $proposal->id;
    }    

    public function viewDocument($id)
    {
        $proposal = ProposalForm::findOrFail($id);
        return view('generate_proposalForm.proposal_view', compact('proposal'));
    }

    public function downloadDocument($id, $format)
    {
        $proposal = ProposalForm::findOrFail($id);
        $fileName = 'AUF-ProposalForm-' . str_replace(' ', '-', $proposal->institution_name) . '.' . $format;
        $filePath = storage_path('app/public/' . $fileName);

        return response()->download($filePath);
    }

    public function editDocument($id)
    {
        $proposal = ProposalForm::findOrFail($id);
        
        return view('generate_proposalForm.proposal_edit', compact('proposal'));
    }

    public function updateDocument(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'institution_name' => 'required|string|max:255',
            'country' => 'required|string|max:255'
        ]);
    
        // Fetch the memorandum to update
        $proposal = ProposalForm::findOrFail($id);
    
        // Update the memorandum fields
        $proposal->institution_name = $validatedData['institution_name'];
        $proposal->country = $validatedData['country'];
        $proposal->save();
    
        // Regenerate the file names with the updated partner name and creation date
        $dateCreated = $proposal->created_at->format('Ymd');
        $fileName = 'AUF-ProposalForm-' . str_replace(' ', '-', $proposal->institution_name) . '-' . $dateCreated;
    
        $institutionName = strtoupper($proposal->institution_name);
        $country = strtoupper($proposal->country);

        // Regenerate the Word document using PHPWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //Global Styles
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(14);

        $sectionStyle = [
            'marginLeft' => 1799.887,  // 1.25 inch
            'marginRight' => 1799.887, // 1.25 inch
            'marginTop' => 1440,   // Default (1 inch)
            'marginBottom' => 1440 // Default (1 inch)
        ];

        //Custom Styles
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'name' => 'Times New Roman'], ['alignment' => Jc::CENTER]);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 14, 'name' => 'Times New Roman'], ['alignment' => Jc::CENTER]);
        $phpWord->addParagraphStyle('leadingParagraph', ['alignment'=>Jc::BOTH]);
        $phpWord->addParagraphStyle('indentedParagraph', [
            'alignment' => Jc::BOTH,
            'indentation' => ['firstLine' => 720],
        ]);
        $phpWord->addParagraphStyle('indentedSpacedParagraph', [
            'alignment' => Jc::BOTH,
            'lineHeight' => 1.5,
            'indentation' => ['firstLine' => 720],
        ]);

        //Creation of Section for FIRST PAGE
        $firstPageSection = $phpWord->addSection([
            'marginTop' => 4000,
            'marginBottom' => 1000,
        ]);

        //Title (First Page)
        $firstPageSection->addTextBreak(2);
        $firstPageSection->addTitle('PROPOSAL FORM', 1);
        $firstPageSection->addTitle($institutionName, 1);
        $firstPageSection->addTitle($country, 1);
    
        // Save the updated .docx file
        $docxFilePath = storage_path('app/public/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');

        // Generate the updated PDF using DOMPDF
        $dompdf = new \Dompdf\Dompdf();
        $html = view('generate_proposalForm.proposal_pdf_view', [
            'institution_name' => $proposal->institution_name,
            'country' => $proposal->country
        ])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
    
        // Save the updated PDF file
        Storage::disk('public')->put($fileName . '.pdf', $dompdf->output());
    
        // Redirect back to the view page with the updated files
        return redirect()->route('viewProposal', ['id' => $proposal->id]);
    }    
}
