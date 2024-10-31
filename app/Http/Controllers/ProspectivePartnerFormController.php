<?php

namespace App\Http\Controllers;

use App\Mail\ProspectivePartnerFormSubmitted;
use App\Models\Document;
use App\Models\DocumentApproval;
use App\Models\InstitutionalUnit;
use App\Models\Link;
use App\Models\Memorandum;
use App\Models\ProposalForm;
use App\Models\EndorsementForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Affiliate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\IOFactory;

class ProspectivePartnerFormController extends Controller
{    
    // Display the link page
    public function prospectPartnerViewLink($link)
    {
        $link = Link::where('link', $link)->firstOrFail();
        $institutionalUnitList = InstitutionalUnit::all();

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
                    return view('PartnerApplication.PartnerView.partnershipApplicationForm_View', ['link' => $link, 'institutionalUnitList' => $institutionalUnitList]);
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

    // Form is Submitted
    public function submitProspectPartnerForm(Request $request, $link)
    {
        $memorandumController = new MemorandumController();
        
        $memorandumID = $memorandumController->generateMemorandum($request);
        $this->generateProposalForm($request, $link, $memorandumID);
        // Optionally send email after submission
        //TODO Mail::to('janjanpingul@gmail.com')->send(new ProspectivePartnerFormSubmitted($link));
    
        return response()->json(['message' => 'Form submitted successfully, and approval tracking initiated.']);
    }

    public function generateProposalForm(Request $request, $link, $memorandum)
    {
        $link = Link::where('link', $link)->firstOrFail();
    
        $selectedinstitutionalUnits = $request->input('selected_institutionalUnits', []);
    
        $proposalForm = ProposalForm::create([
            'country' => $request->input('country'),
            'institution_name' => $request->input('institution_name'),
        ]);
    
        // Step 2: Link Memorandum and Proposal Form to the Link model
        $link->update([
            'memorandum_fk' => $memorandum,
            'proposal_form_fk' => $proposalForm->id,
            'isActive' => false,
        ]);
    
        // Sync selected institutional units with the link
        $link->institutionalUnits()->sync($selectedinstitutionalUnits);
    }

    //Generate Memorandum
    // public function generateMemorandum(Request $request)
    // {
    //     // Validate all the inputs from the multi-step form
    //     $validatedData = $request->validate([
    //         'partner_name' => 'required|string|max:255',
    //         'whereas_clauses' => 'nullable|array',
    //         'whereas_clauses.*' => 'required|string|max:1000',
    //         'whereas_clause_texts' => 'nullable|array',
    //         'whereas_clause_texts.*' => 'required|string|max:1000',
    //         'contact_person' => 'required|string|max:255',
    //         'contact_email' => 'required|email|max:255',
    //         'articles' => 'nullable|array',
    //         'articles.*' => 'required|string|max:1000',
    //     ]);
    
    //     // Combine the Whereas dropdown and textarea into a structured array
    //     $combinedWhereasClauses = [];
    //     foreach ($validatedData['whereas_clauses'] as $index => $dropdownClause) {
    //         $textClause = $validatedData['whereas_clause_texts'][$index] ?? ''; // Textarea content
    //         $combinedWhereasClauses[] = [
    //             'dropdown' => $dropdownClause,
    //             'text' => $textClause
    //         ];
    //     }

    //     // Create a new Memorandum entry in the database
    //     $memorandum = new Memorandum();
    //     $memorandum->partner_name = $validatedData['partner_name'];
    //     $memorandum->contact_person = $validatedData['contact_person'];
    //     $memorandum->contact_email = $validatedData['contact_email'];
    //     $memorandum->whereas_clauses = json_encode($combinedWhereasClauses); // Save both dropdown and text
    //     $memorandum->articles = json_encode($validatedData['articles']);
    //     $memorandum->save();
    
    //     // Generate the file name: AUF-MOA-[partner_name]-[datecreated]
    //     $dateCreated = Carbon::now()->format('Ymd');
    //     $fileName = 'AUF-Memorandum-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;
    
    //     //Setting Capitalizations
    //     $partnerName = strtoupper($memorandum->partner_name);
    //     $partnerRepresentative = strtoupper($memorandum->contact_person);

    //     // Generate the Word document using PHPWord
    //     $phpWord = new PhpWord();
        
    //     //Global Styles
    //     $phpWord->setDefaultFontName('Times New Roman');
    //     $phpWord->setDefaultFontSize(14);

    //     $sectionStyle = [
    //         'marginLeft' => 1799.887,  // 1.25 inch
    //         'marginRight' => 1799.887, // 1.25 inch
    //         'marginTop' => 1440,   // Default (1 inch)
    //         'marginBottom' => 1440 // Default (1 inch)
    //     ];

    //     //Custom Styles
    //     $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'name' => 'Times New Roman'], ['alignment' => Jc::CENTER]);
    //     $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 14, 'name' => 'Times New Roman'], ['alignment' => Jc::CENTER]);
    //     $phpWord->addParagraphStyle('leadingParagraph', ['alignment'=>Jc::BOTH]);
    //     $phpWord->addParagraphStyle('indentedParagraph', [
    //         'alignment' => Jc::BOTH,
    //         'indentation' => ['firstLine' => 720],
    //     ]);
    //     $phpWord->addParagraphStyle('indentedSpacedParagraph', [
    //         'alignment' => Jc::BOTH,
    //         'lineHeight' => 1.5,
    //         'indentation' => ['firstLine' => 720],
    //     ]);

    //     //Creation of Section for FIRST PAGE
    //     $firstPageSection = $phpWord->addSection([
    //         'marginTop' => 4000,
    //         'marginBottom' => 1000,
    //     ]);

    //     //Title (First Page)
    //     $firstPageSection->addTextBreak(2);
    //     $firstPageSection->addTitle('ANGELES UNIVERSITY FOUNDATION (PHILIPPINES)', 1);
    //     $firstPageSection->addTitle('AND', 1);
    //     $firstPageSection->addTitle($memorandum->partner_name, 1);
    //     //Space
    //     $firstPageSection->addTextBreak(5,['size'=>16]);
    //     //Description (First Page)
    //     $firstPageSection->addTitle('MEMORANDUM OF AGREEMENT FOR {Reason, change this to be dynamic}', 1);
    
    //     // Memorandum of Agreement Section
    //     $moaPageSection = $phpWord->addSection($sectionStyle);
        
    //     $moaPageSection->addTitle('MEMORANDUM OF AGREEMENT', 2);
    //     $moaPageSection->addTextBreak(2);
    //     $moaPageSection->addText('KNOW ALL MEN BY THESE PRESENTS:', null, 'leadingParagraph');
    //     $moaPageSection->addTextBreak();
    //     $moaPageSection->addText('This Memorandum of Agreement ("Agreement") is executed on {Date}, in Angeles City, Philippines, by and between:', null, 'indentedParagraph');
    //     $moaPageSection->addTextBreak();
    //     $moaSection_auf_TextRun = $moaPageSection->addTextRun('indentedSpacedParagraph');
    //     $moaSection_auf_TextRun->addText('ANGELES UNIVERSITY FOUNDATION (PHILIPPINES)',['bold'=>true]);
    //     $moaSection_auf_TextRun->addText(', a higher education institution duly organized and existing under the laws of the Republic of the Philippines, with principal address at MacArthur Highway, Angeles City, Philippines, duly represented herein by its President, ');
    //     $moaSection_auf_TextRun->addText('DR. JOSEPH EMMANUEL L. ANGELES ',['bold'=>true]);
    //     $moaSection_auf_TextRun->addText('(hereafter referred to as ');
    //     $moaSection_auf_TextRun->addText('"AUF"', ['bold'=>true]);
        
    //     $moaPageSection->addTextBreak();
    //     $moaPageSection->addText('and', null,['alignment'=>Jc::CENTER]);
    //     $moaPageSection->addTextBreak();

    //     $moaSection_partner_TextRun = $moaPageSection->addTextRun('indentedSpacedParagraph');
    //     $moaSection_partner_TextRun->addText($partnerName. ', ',['bold'=>true]);
    //     $moaSection_partner_TextRun->addText('a time-honored and well-acclaimed institution of higher learning duly organized and existing under the laws of the People’s Republic of China, with principal address at No.1 Keji Road, Shangjie, Minhou, Fuzhou, Fujian, People’s Republic of China, herein represented by its President, ');
    //     $moaSection_partner_TextRun->addText($partnerRepresentative . ' ',['bold'=>true]);
    //     $moaSection_partner_TextRun->addText('(hereafter referred to as ');
    //     $moaSection_partner_TextRun->addText('"{PartnerName_Abbreviation}"', ['bold'=>true]);

    //     // Witnesseth That Section
    //     $witnessethPageSection = $phpWord->addSection($sectionStyle);

    //     // !Add Whereas Clauses
    //     $witnessethPageSection->addTitle('WITNESSETH THAT:', 1);
    //     foreach ($validatedData['whereas_clauses'] as $index => $dropdownClause) {
    //         $textClause = $validatedData['whereas_clause_texts'][$index] ?? '';
    //         $combinedClause = "WHEREAS, " . $dropdownClause . " " . ucfirst($textClause); // Combining both
    //         $witnessethPageSection->addText($combinedClause, null, ['align' => 'both']); // Justify alignment
    //     }

    //     // !Add Contact Information
    //     /*$section->addText('Contact Person: ' . $memorandum->contact_person, 'paragraphStyle');
    //     $section->addText('Contact Email: ' . $memorandum->contact_email, 'paragraphStyle');
    
    //     // !Add Article Clauses
    //     $section->addText('Article 3: Scope of Collaboration', 'paragraphStyle');
    //     foreach (json_decode($memorandum->articles, true) as $index => $article) {
    //         $section->addText('3.' . ($index + 1) . ' ' . $article, 'paragraphStyle', 'justify');
    //     }*/
    
    //     // Save the .docx file
    //     $docxFilePath = storage_path('app/public/memorandum/' . $fileName . '.docx');
    //     $phpWord->save($docxFilePath, 'Word2007');
    
    //     // Generate the PDF using DOMPDF
    //     $combinedWhereasClausesForPdf = [];
    //     foreach ($combinedWhereasClauses as $index => $clauseData) {
    //         // Combine the dropdown and textarea content for PDF view
    //         $combinedWhereasClausesForPdf[] = "WHEREAS, " . $clauseData['dropdown'] . " " . ucfirst($clauseData['text']) . ".";
    //     }
        
    //     $dompdf = new Dompdf();
    //     $html = view('generate_moa.memorandum_pdf_view', [
    //         'partner_name' => $memorandum->partner_name,
    //         'contact_person' => $memorandum->contact_person,
    //         'contact_email' => $memorandum->contact_email,
    //         'whereasClauses' => $combinedWhereasClausesForPdf, // Send combined whereas clauses
    //         'articles' => json_decode($memorandum->articles)
    //     ])->render();    
    //     $dompdf->loadHtml($html);
    //     $dompdf->render();
    //     Storage::put('public/memorandum/' . $fileName . '.pdf', $dompdf->output());
    
    //     // Redirect to the view page after generating the document
    //     return $memorandum->id;
    // }    
}