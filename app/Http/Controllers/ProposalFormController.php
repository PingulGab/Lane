<?php

namespace App\Http\Controllers;

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

    public function generate(Request $request)
    {
        // Validate all the inputs from the multi-step form
        $validatedData = $request->validate([
            'institution_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
    
        // Create a new Memorandum entry in the database
        $proposal = new ProposalForm();
        $proposal->institution_name = $validatedData['institution_name'];
        $proposal->country = $validatedData['country'];
        $proposal->save();
    
        // Generate the file name: AUF-MOA-[partner_name]-[datecreated]
        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-ProposalForm-' . str_replace(' ', '-', $proposal->institution_name) . '-' . $dateCreated;
    
        //Setting Capitalizations
        $institutionName = strtoupper($proposal->institution_name);

        // Generate the Word document using PHPWord
        $phpWord = new PhpWord();
        
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
        $firstPageSection->addTitle('Country'.$proposal->country, 1);

        // Save the .docx file
        $docxFilePath = storage_path('app/public/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
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
        return redirect()->route('viewProposal', ['id' => $proposal->id]);
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
