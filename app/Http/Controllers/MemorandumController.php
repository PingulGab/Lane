<?php

namespace App\Http\Controllers;

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

class MemorandumController extends Controller
{
    public function create()
    {
        if (request()->ajax()) {
            return view('generate_moa.memorandum_create'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('generate_moa.memorandum_create')
        ]);
    }

    public function generate(Request $request)
    {
        // Validate all the inputs from the multi-step form
        $validatedData = $request->validate([
            'partner_name' => 'required|string|max:255',
            'whereas_clauses' => 'nullable|array',
            'whereas_clauses.*' => 'required|string|max:1000',
            'whereas_clause_texts' => 'nullable|array',
            'whereas_clause_texts.*' => 'required|string|max:1000',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'articles' => 'nullable|array',
            'articles.*' => 'required|string|max:1000',
        ]);
    
        // Combine the Whereas dropdown and textarea into a structured array
        $combinedWhereasClauses = [];
        foreach ($validatedData['whereas_clauses'] as $index => $dropdownClause) {
            $textClause = $validatedData['whereas_clause_texts'][$index] ?? ''; // Textarea content
            $combinedWhereasClauses[] = [
                'dropdown' => $dropdownClause,
                'text' => $textClause
            ];
        }

        // Create a new Memorandum entry in the database
        $memorandum = new Memorandum();
        $memorandum->partner_name = $validatedData['partner_name'];
        $memorandum->contact_person = $validatedData['contact_person'];
        $memorandum->contact_email = $validatedData['contact_email'];
        $memorandum->whereas_clauses = json_encode($combinedWhereasClauses); // Save both dropdown and text
        $memorandum->articles = json_encode($validatedData['articles']);
        $memorandum->save();
    
        // Generate the file name: AUF-MOA-[partner_name]-[datecreated]
        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-MOA-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;
    
        //Setting Capitalizations
        $partnerName = strtoupper($memorandum->partner_name);
        $partnerRepresentative = strtoupper($memorandum->contact_person);

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
        $firstPageSection->addTitle('ANGELES UNIVERSITY FOUNDATION (PHILIPPINES)', 1);
        $firstPageSection->addTitle('AND', 1);
        $firstPageSection->addTitle($memorandum->partner_name, 1);
        //Space
        $firstPageSection->addTextBreak(5,['size'=>16]);
        //Description (First Page)
        $firstPageSection->addTitle('MEMORANDUM OF AGREEMENT FOR {Reason, change this to be dynamic}', 1);
    
        // Memorandum of Agreement Section
        $moaPageSection = $phpWord->addSection($sectionStyle);
        
        $moaPageSection->addTitle('MEMORANDUM OF AGREEMENT', 2);
        $moaPageSection->addTextBreak(2);
        $moaPageSection->addText('KNOW ALL MEN BY THESE PRESENTS:', null, 'leadingParagraph');
        $moaPageSection->addTextBreak();
        $moaPageSection->addText('This Memorandum of Agreement ("Agreement") is executed on {Date}, in Angeles City, Philippines, by and between:', null, 'indentedParagraph');
        $moaPageSection->addTextBreak();
        $moaSection_auf_TextRun = $moaPageSection->addTextRun('indentedSpacedParagraph');
        $moaSection_auf_TextRun->addText('ANGELES UNIVERSITY FOUNDATION (PHILIPPINES)',['bold'=>true]);
        $moaSection_auf_TextRun->addText(', a higher education institution duly organized and existing under the laws of the Republic of the Philippines, with principal address at MacArthur Highway, Angeles City, Philippines, duly represented herein by its President, ');
        $moaSection_auf_TextRun->addText('DR. JOSEPH EMMANUEL L. ANGELES ',['bold'=>true]);
        $moaSection_auf_TextRun->addText('(hereafter referred to as ');
        $moaSection_auf_TextRun->addText('"AUF"', ['bold'=>true]);
        
        $moaPageSection->addTextBreak();
        $moaPageSection->addText('and', null,['alignment'=>Jc::CENTER]);
        $moaPageSection->addTextBreak();

        $moaSection_partner_TextRun = $moaPageSection->addTextRun('indentedSpacedParagraph');
        $moaSection_partner_TextRun->addText($partnerName. ', ',['bold'=>true]);
        $moaSection_partner_TextRun->addText('a time-honored and well-acclaimed institution of higher learning duly organized and existing under the laws of the People’s Republic of China, with principal address at No.1 Keji Road, Shangjie, Minhou, Fuzhou, Fujian, People’s Republic of China, herein represented by its President, ');
        $moaSection_partner_TextRun->addText($partnerRepresentative . ' ',['bold'=>true]);
        $moaSection_partner_TextRun->addText('(hereafter referred to as ');
        $moaSection_partner_TextRun->addText('"{PartnerName_Abbreviation}"', ['bold'=>true]);

        // Witnesseth That Section
        $witnessethPageSection = $phpWord->addSection($sectionStyle);

        // !Add Whereas Clauses
        $witnessethPageSection->addTitle('WITNESSETH THAT:', 1);
        foreach ($validatedData['whereas_clauses'] as $index => $dropdownClause) {
            $textClause = $validatedData['whereas_clause_texts'][$index] ?? '';
            $combinedClause = "WHEREAS, " . $dropdownClause . " " . ucfirst($textClause); // Combining both
            $witnessethPageSection->addText($combinedClause, null, ['align' => 'both']); // Justify alignment
        }

        // !Add Contact Information
        /*$section->addText('Contact Person: ' . $memorandum->contact_person, 'paragraphStyle');
        $section->addText('Contact Email: ' . $memorandum->contact_email, 'paragraphStyle');
    
        // !Add Article Clauses
        $section->addText('Article 3: Scope of Collaboration', 'paragraphStyle');
        foreach (json_decode($memorandum->articles, true) as $index => $article) {
            $section->addText('3.' . ($index + 1) . ' ' . $article, 'paragraphStyle', 'justify');
        }*/
    
        // Save the .docx file
        $docxFilePath = storage_path('app/public/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
        // Generate the PDF using DOMPDF
        $combinedWhereasClausesForPdf = [];
        foreach ($combinedWhereasClauses as $index => $clauseData) {
            // Combine the dropdown and textarea content for PDF view
            $combinedWhereasClausesForPdf[] = "WHEREAS, " . $clauseData['dropdown'] . " " . ucfirst($clauseData['text']) . ".";
        }
        
        $dompdf = new Dompdf();
        $html = view('generate_moa.pdf_view', [
            'partner_name' => $memorandum->partner_name,
            'contact_person' => $memorandum->contact_person,
            'contact_email' => $memorandum->contact_email,
            'whereasClauses' => $combinedWhereasClausesForPdf, // Send combined whereas clauses
            'articles' => json_decode($memorandum->articles)
        ])->render();    
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::put('public/' . $fileName . '.pdf', $dompdf->output());
    
        // Redirect to the view page after generating the document
        return redirect()->route('viewDocument', ['id' => $memorandum->id]);
    }    

    public function viewDocument($id)
    {
        $memorandum = Memorandum::findOrFail($id);
        return view('generate_moa.memorandum_view', compact('memorandum'));
    }

    public function downloadDocument($id, $format)
    {
        $memorandum = Memorandum::findOrFail($id);
        $fileName = 'AUF-MOA-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $memorandum->created_at->format('Ymd') . '.' . $format;
        $filePath = storage_path('app/public/' . $fileName);

        return response()->download($filePath);
    }

    public function editDocument($id)
    {
        $memorandum = Memorandum::findOrFail($id);
    
        // Decode JSON data for whereas_clauses and articles
        $memorandum->whereas_clauses = json_decode($memorandum->whereas_clauses, true);
        $memorandum->articles = json_decode($memorandum->articles, true);
    
        return view('generate_moa.memorandum_edit', compact('memorandum'));
    }

    public function updateDocument(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'partner_name' => 'required|string|max:255',
            'whereas_clauses' => 'nullable|array',
            'whereas_clauses.*' => 'required|string|max:1000',
            'articles' => 'nullable|array',
            'articles.*' => 'required|string|max:1000',
        ]);
    
        // Fetch the memorandum to update
        $memorandum = Memorandum::findOrFail($id);
    
        // Update the memorandum fields
        $memorandum->partner_name = $validatedData['partner_name'];
        $memorandum->whereas_clauses = json_encode($validatedData['whereas_clauses']);
        $memorandum->articles = json_encode($validatedData['articles']);
        $memorandum->save();
    
        // Regenerate the file names with the updated partner name and creation date
        $dateCreated = $memorandum->created_at->format('Ymd');
        $fileName = 'AUF-MOA-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;
    
        // Regenerate the Word document using PHPWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'name' => 'Times New Roman'], ['alignment' => 'center']);
        $phpWord->addFontStyle('paragraphStyle', ['size' => 12, 'name' => 'Times New Roman']);
        $phpWord->addParagraphStyle('justify', ['alignment' => 'both']);
    
        // Add title and partner name
        $section->addTitle('Memorandum of Agreement', 1);
        $section->addText('This Memorandum of Agreement is made by and between:', 'paragraphStyle');
        $section->addText($memorandum->partner_name, ['bold' => true, 'size' => 12, 'name' => 'Times New Roman']);
    
        // Add Whereas Clauses
        $section->addText('Whereas Clauses', 'paragraphStyle');
        foreach (json_decode($memorandum->whereas_clauses, true) as $index => $clause) {
            $section->addText(($index + 1) . ". " . $clause, 'paragraphStyle', 'justify');
        }
    
        // Add Article Clauses
        $section->addText('Article 3: Scope of Collaboration', 'paragraphStyle');
        foreach (json_decode($memorandum->articles, true) as $index => $article) {
            $section->addText('3.' . ($index + 1) . ' ' . $article, 'paragraphStyle', 'justify');
        }
    
        // Save the updated .docx file
        $docxFilePath = storage_path('app/public/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
        // Generate the updated PDF using DOMPDF
        $dompdf = new \Dompdf\Dompdf();
        $html = view('generate_moa.pdf_view', [
            'partner_name' => $memorandum->partner_name,
            'whereasClauses' => json_decode($memorandum->whereas_clauses),
            'articles' => json_decode($memorandum->articles)
        ])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
    
        // Save the updated PDF file
        Storage::disk('public')->put($fileName . '.pdf', $dompdf->output());
    
        // Redirect back to the view page with the updated files
        return redirect()->route('viewDocument', ['id' => $memorandum->id]);
    }    
}
