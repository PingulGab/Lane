<?php

namespace App\Http\Controllers;

use App\Models\ContactPerson;
use App\Models\PartnerLinkage;
use App\Models\ProposalForm;
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
            'country' => 'required|string|max:255',
            'type_of_institution' => 'required|string|in:Private Higher Educational Institution,Public Higher Educational Institution,Private Company,Public Company,Organization,Government Agency',
            'email' => 'required|email|max:255',
            'telephone_number' => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'institution_overview' => 'nullable|string',
            'target_participant' => 'required|string|in:Student,Faculty,Researcher',
            'target_level' => 'required|string|in:Elementary,Junior High School,Senior High School,Undergraduate,Graduate School,Certification Program (ESL)',
            'selected_institutionalUnit' => 'nullable|exists:institutional_units,id',
            'type_of_partnership' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $validPrefixes = ['Non-Degree Program', 'Degree Program', 'Mobility Program', 'Research Program'];
                    $isValid = false;
        
                    foreach ($validPrefixes as $prefix) {
                        if (strpos($value, "{$prefix} - ") === 0) {
                            $isValid = true;
                            break;
                        }
                    }
        
                    if (!$isValid) {
                        $fail("The selected partnership type is invalid.");
                    }
                }
            ],
            'type_of_partnership_other' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    if (strpos($request->type_of_partnership, 'Others') !== false && empty($value)) {
                        $fail("The {$attribute} field is required when 'Others' is selected.");
                    }
                }
            ],
            'partnership_overview' => 'required|string',
            'partnership_expected_outcome' => 'required|string',
            'partnership_target_participants' => 'required|string',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email|max:255',
            'contact_person_position' => 'required|string|max:255',
            'contact_person_office' => 'required|string|max:255',
            'contact_person_telephone_number' => 'nullable|string|max:20',
            'contact_person_mobile_number' => 'nullable|string|max:20',
        
            // Validate each accreditation entry
            'accreditations' => 'required|array',
            'accreditations.*.institution_name' => 'required|string|max:255',
            'accreditations.*.nature_of_partnership' => 'required|string|max:255',
            'accreditations.*.validity_period' => 'required|date',
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

        // Step 2: Create the Proposal Form
        $proposal = ProposalForm::create([
            'institution_name' => $validatedData['institution_name'],
            'country' => $validatedData['country'],
            'type_of_institution' => $validatedData['type_of_institution'],
            'email' => $validatedData['email'],
            'telephone_number' => $validatedData['telephone_number'],
            'mobile_number' => $validatedData['mobile_number'],
            'website' => $validatedData['website'],
            'institution_overview' => $validatedData['institution_overview'],
            'institution_accreditation' => json_encode($validatedData['accreditations']), // Save as JSON
            'target_participant' => $validatedData['target_participant'],
            'target_level' => $validatedData['target_level'],
            'institutional_unit_id' => $validatedData['selected_institutionalUnit'],
            'type_of_partnership' => $validatedData['type_of_partnership'],
            'partnership_overview' => $validatedData['partnership_overview'],
            'partnership_expected_outcome' => $validatedData['partnership_expected_outcome'],
            'partnership_target_participants' => $validatedData['partnership_target_participants'],
            'contact_person_id' => $contactPerson->id,
        ]);
        
        // Step 3: Store each accreditation in the PartnerLinkage table
        foreach ($validatedData['accreditations'] as $accreditation) {
            PartnerLinkage::create([
                'institution_name' => $accreditation['institution_name'],
                'nature_of_partnership' => $accreditation['nature_of_partnership'],
                'validity_period' => $accreditation['validity_period'],
                'proposal_form_id' => $proposal->id,
            ]);
        }

        // Generate the file name: AUF-MOA-[partner_name]-[datecreated]
        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-ProposalForm-' . str_replace(' ', '-', $proposal->institution_name) . '-' . $dateCreated;
    
        
        // Generate the PDF using DOMPDF        
        $dompdf = new Dompdf();
        $html = view('generate_proposalForm.proposal_pdf_view', [
            'institution_name' => $proposal->institution_name,
            'country' => $proposal->country,
        ])->render();    
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::put('public/' . $fileName . '.pdf', $dompdf->output());
    
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
