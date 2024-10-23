<?php

namespace App\Http\Controllers;

use App\Models\EndorsementForm;
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

    public function generate(Request $request)
    {
        // Validate all the inputs from the multi-step form
        $validatedData = $request->validate([
            'Description_1' => 'required|string|max:255',
            'Description_2' => 'required|string|max:255',
        ]);
    
        // Create a new Memorandum entry in the database
        $endorsement = new EndorsementForm();
        $endorsement->Description_1 = $validatedData['Description_1'];
        $endorsement->Description_2 = $validatedData['Description_2'];
        $endorsement->save();
    
        // Generate the file name: AUF-MOA-[partner_name]-[datecreated]
        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-EndorsementForm-' . str_replace(' ', '-', $endorsement->Description_1) . '-' . $dateCreated;
    
        //Setting Capitalizations
        $Description1 = strtoupper($endorsement->Description_1);

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
        $firstPageSection->addTitle('ENDORSEMENT FORM', 1);
        $firstPageSection->addTitle('Description #1' . $Description1, 1);
        $firstPageSection->addTitle('Description #2:'. $endorsement->Description_2, 1);

        // Save the .docx file
        $docxFilePath = storage_path('app/public/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
        // Generate the PDF using DOMPDF        
        $dompdf = new Dompdf();
        $html = view('generate_endorsementForm.endorsement_pdf_view', [
            'Description_1' => $endorsement->Description_1,
            'Description_2' => $endorsement->Description_2,
        ])->render();    
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::put('public/' . $fileName . '.pdf', $dompdf->output());
    
        // Redirect to the view page after generating the document
        return redirect()->route('viewEndorsement', ['id' => $endorsement->id]);
    }    

    public function viewDocument($id)
    {
        $endorsement = EndorsementForm::findOrFail($id);
        return view('generate_endorsementForm.endorsement_view', compact('endorsement'));
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
