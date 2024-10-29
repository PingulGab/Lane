<?php

namespace App\Http\Controllers;

use App\Mail\EndorsementFormCreated;
use App\Models\Document;
use App\Models\DocumentApproval;
use App\Models\EndorsementForm;
use App\Models\Link;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Memorandum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\IOFactory;

class EndorsementFormController extends Controller
{
    public function create()
    {
        if (request()->ajax()) {
            return view('generate_endorsementForm.endorsement_create'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('generate_endorsementForm.endorsement_create')
        ]);
    }

    public function generateEndorsement(Request $request, $link)
    {
        //! Validate all the inputs from the multi-step form
        $validatedData = $request->validate([
            'Description_1' => 'required|string|max:255',
            'Description_2' => 'required|string|max:255',
        ]);
    
        //! Create a new Memorandum entry in the database
        $endorsement = new EndorsementForm();
        $endorsement->Description_1 = $validatedData['Description_1'];
        $endorsement->Description_2 = $validatedData['Description_2'];
        $endorsement->save();

        //! Establish the Relationship of the created Endorsement Form to the Link Table
        $linkModel = Link::where('link', $link)->firstOrFail();
        $linkModel->update([
            'endorsement_form_fk' => $endorsement->id,
        ]);
    
        //! PHP WORD: Setting Capitalizations
        $Description1 = strtoupper($endorsement->Description_1);

        //! PHP WORD: Generate the Word document using PHPWord
        $phpWord = new PhpWord();
        
        //! PHP WORD:Global Styles
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(14);

        $sectionStyle = [
            'marginLeft' => 1799.887,  // 1.25 inch
            'marginRight' => 1799.887, // 1.25 inch
            'marginTop' => 1440,   // Default (1 inch)
            'marginBottom' => 1440 // Default (1 inch)
        ];

        //! PHP WORD:Custom Styles
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

        //! PHP WORD:Creation of Section for FIRST PAGE
        $firstPageSection = $phpWord->addSection([
            'marginTop' => 4000,
            'marginBottom' => 1000,
        ]);

        //! PHP WORD: Content of the First Page
        $firstPageSection->addTextBreak(2);
        $firstPageSection->addTitle('ENDORSEMENT FORM', 1);
        $firstPageSection->addTitle('Description #1' . $Description1, 1);
        $firstPageSection->addTitle('Description #2:'. $endorsement->Description_2, 1);

        //! Generatin of File Name
        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-EndorsementForm-' . str_replace(' ', '-', $endorsement->Description_1) . '-' . $dateCreated;

        //! Save the .docx file
        $docxFilePath = storage_path('app/public/endorsement-form/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
        //! Generate the PDF using DOMPDF        
        $dompdf = new Dompdf();
        $html = view('generate_endorsementForm.endorsement_pdf_view', [
            'Description_1' => $endorsement->Description_1,
            'Description_2' => $endorsement->Description_2,
        ])->render();    
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::put('public/endorsement-form/' . $fileName . '.pdf', $dompdf->output());
    
        //Mail::to('janjanpingul@gmail.com')->send(new ProspectivePartnerFormSubmitted($link));
        // TODO: Initiate the Approval Tracking Process
        // Step 3: Create Document record to track approvals
        $document = Document::create([
            'memorandum_id' => $linkModel->memorandum_fk,
            'proposal_form_id' => $linkModel->proposal_form_fk,
            'endorsement_form_id' => $linkModel->endorsement_form_fk
        ]);
    
        // Step 4: Fetch affiliates linked to the specified link for approvals
        $affiliates = $linkModel->affiliates; // Assuming a relationship exists on the Link model
    
        // Step 5: Create DocumentApproval records for each required affiliate
        foreach ($affiliates as $affiliate) {
            DocumentApproval::create([
                'document_id' => $document->id,
                'affiliate_id' => $affiliate->id,
                'is_approved' => false,
            ]);
        }

        // Send email after submission
        //TODO Mail::to('janjanpingul@gmail.com')->send(new EndorsementFormCreated($document));

        //! Redirect to the view page after generating the document
        return redirect()->route('viewEndorsement', ['link' => $link]);
    }    

    public function viewEndorsement($link)
    {
        $linkModel = Link::with([
            'memorandum', 
            'proposalForm', 
            'endorsementForm'
            ])->where('link', $link)->firstOrFail();

        // Load related data if available
        $memorandum = $linkModel->memorandum;
        $proposalForm = $linkModel->proposalForm;

        $endorsement = EndorsementForm::findOrFail($linkModel->endorsement_form_fk);
        return view('PartnerApplication.CollegeView.EndorsementSubmitted', compact('endorsement', 'memorandum', 'proposalForm'));
    }

    public function downloadDocument($id, $format)
    {
        $endorsement = EndorsementForm::findOrFail($id);
        $fileName = 'AUF-EndorsementForm-' . str_replace(' ', '-', $endorsement->Description_1) . '.' . $format;
        $filePath = storage_path('app/public/' . $fileName);

        return response()->download($filePath);
    }

    public function editDocument($id)
    {
        $endorsement = EndorsementForm::findOrFail($id);
        
        return view('generate_endorsementForm.endorsement_edit', compact('endorsement'));
    }

    public function updateDocument(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'Description_1' => 'required|string|max:255',
            'Description_2' => 'required|string|max:255'
        ]);
    
        // Fetch the memorandum to update
        $endorsement = EndorsementForm::findOrFail($id);
    
        // Update the memorandum fields
        $endorsement->Description_1 = $validatedData['Description_1'];
        $endorsement->Description_2 = $validatedData['Description_2'];
        $endorsement->save();
    
        // Regenerate the file names with the updated partner name and creation date
        $dateCreated = $endorsement->created_at->format('Ymd');
        $fileName = 'AUF-EndorsementForm-' . str_replace(' ', '-', $endorsement->Description_1) . '-' . $dateCreated;
    
        $Description1 = strtoupper($endorsement->Description_1);
        $Description2 = strtoupper($endorsement->Description_2);

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
        $firstPageSection->addTitle('ENDORSEMENT FORM', 1);
        $firstPageSection->addTitle('Description #1: ' . $Description1, 1);
        $firstPageSection->addTitle('Description #2: ' . $Description2, 1);
    
        // Save the updated .docx file
        $docxFilePath = storage_path('app/public/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
        // Generate the updated PDF using DOMPDF
        $dompdf = new \Dompdf\Dompdf();
        $html = view('generate_endorsementForm.endorsement_pdf_view', [
            'Description_1' => $endorsement->Description_1,
            'Description_2' => $endorsement->Description_2
        ])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
    
        // Save the updated PDF file
        Storage::disk('public')->put($fileName . '.pdf', $dompdf->output());
    
        // Redirect back to the view page with the updated files
        return redirect()->route('viewEndorsement', ['id' => $endorsement->id]);
    }    
}
