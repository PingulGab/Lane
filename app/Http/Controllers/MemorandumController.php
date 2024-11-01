<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Link;
use App\Models\MemorandumVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Memorandum;
use Carbon\Carbon;
use App\Mail\EndorsementFormCreated;
use Mail;
use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\FpdfTpl;

use PhpOffice\PhpWord\SimpleType\Jc;

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

    public function generateMemorandum(Request $request)
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
        $fileName = 'AUF-Memorandum-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;
    
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
        $docxFilePath = storage_path('app/public/memorandum/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
        // Generate the PDF using DOMPDF
        $combinedWhereasClausesForPdf = [];
        foreach ($combinedWhereasClauses as $index => $clauseData) {
            // Combine the dropdown and textarea content for PDF view
            $combinedWhereasClausesForPdf[] = "WHEREAS, " . $clauseData['dropdown'] . " " . ucfirst($clauseData['text']) . ".";
        }
        
        $dompdf = new Dompdf();
        $html = view('generate_moa.memorandum_pdf_view', [
            'partner_name' => $memorandum->partner_name,
            'contact_person' => $memorandum->contact_person,
            'contact_email' => $memorandum->contact_email,
            'whereasClauses' => $combinedWhereasClausesForPdf, // Send combined whereas clauses
            'articles' => json_decode($memorandum->articles)
        ])->render();    
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::put('public/memorandum/' . $fileName . '.pdf', $dompdf->output());
    
        // Redirect to the view page after generating the document
        return $memorandum->id;
    }    

    public function viewDocument($id)
    {
        $memorandum = Memorandum::findOrFail($id);
        return view('generate_moa.memorandum_view', compact('memorandum'));
    }

    public function downloadDocument($id, $format)
    {
        $documentID = session('documentID');
        $document = Document::with('memorandum')->findOrFail($documentID);

        $document->update(['is_downloaded' => true]);

        //TODO Mail::to('janjanpingul@gmail.com')->send(new EndorsementFormCreated($document));

        $memorandum = Memorandum::findOrFail($id);
        $fileName = 'AUF-Memorandum-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $memorandum->created_at->format('Ymd') . '.' . $format;
        $filePath = storage_path('app/public/memorandum/' . $fileName);

        session()->forget('documentID');
        return response()->download($filePath);
    }

    public function editDocument($id)
    {
        $memorandum = Memorandum::findOrFail($id);

        // Determine who is the logged in User
        if ($affiliate_user  = Auth::guard('affiliate')->user()) {
            // Check if it is locked
            if ($memorandum->locked_by && $memorandum->locked_by != $affiliate_user->id) {
                $document = Document::with(['memorandum'])
                                    ->where('memorandum_id', $memorandum->id)
                                    ->firstOrFail();

                return redirect()->route('affiliateShowDocument', ['id' => $document->id, 'name' => $document->memorandum->partner_name])
                                ->withErrors('Document is currently being edited by another user.');
            }

            // Lock the document for the current user
            $memorandum->update([
                'locked_by' => $affiliate_user->id,
                'locked_at' => now(),
            ]);
            
        } elseif($institutionalUnit_user = Auth::guard('institutionalUnit')->user()) {

            if ($memorandum->locked_by && $memorandum->locked_by != $institutionalUnit_user->id) {
                $document = Document::with(['memorandum'])
                                    ->where('memorandum_id', $memorandum->id)
                                    ->firstOrFail();

                return redirect()->route('affiliateShowDocument', ['id' => $document->id, 'name' => $document->memorandum->partner_name])
                                ->withErrors('Document is currently being edited by another user.');
            }

            // Lock the document for the current user
            $memorandum->update([
                'locked_by' => $institutionalUnit_user->id,
                'locked_at' => now(),
            ]);
        }

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
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|string|max:255',
            'whereas_clauses' => 'nullable|array',
            'whereas_clauses.*' => 'required|string|max:1000',
            'articles' => 'nullable|array',
            'articles.*' => 'required|string|max:1000',
        ]);
    
        // Fetch the memorandum
        $memorandum = Memorandum::findOrFail($id);

        // Determine who is the logged in User
        if ($affiliate_user  = Auth::guard('affiliate')->user()) {
            
            MemorandumVersion::create([
                'memorandum_id' => $memorandum->id,
                'edited_by' => $affiliate_user->id,
                'whereas_clauses' => $memorandum->whereas_clauses,
                'articles' => $memorandum->articles,
                'version' => $memorandum->version,
            ]);
            
        } elseif($institutionalUnit_user = Auth::guard('institutionalUnit')->user()) {

            MemorandumVersion::create([
                'memorandum_id' => $memorandum->id,
                'edited_by' => $institutionalUnit_user->id,
                'whereas_clauses' => $memorandum->whereas_clauses,
                'articles' => $memorandum->articles,
                'version' => $memorandum->version,
            ]);
        }

        // Increment the Version
        $newVersion = number_format($memorandum->version + 0.1, 1);

        // Update the memorandum fields
        $memorandum->update([
            'whereas_clauses' => json_encode($validatedData['whereas_clauses']),
            'articles' => json_encode($validatedData['articles']),
            'version' => $newVersion,
            'locked_by' => null,
            'locked_at' => null,
        ]);
    
        // Regenerate the file names with the updated partner name and creation date
        $dateCreated = $memorandum->created_at->format('Ymd');
        $fileName = 'AUF-Memorandum-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;
    
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
        $docxFilePath = storage_path('app/public/memorandum/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');
    
        // Generate the updated PDF using DOMPDF
        $dompdf = new \Dompdf\Dompdf();
        $html = view('generate_moa.memorandum_pdf_view', [
            'partner_name' => $memorandum->partner_name,
            'contact_person' => $memorandum->contact_person,
            'contact_email' => $memorandum->contact_email,
            'whereasClauses' => json_decode($memorandum->whereas_clauses),
            'articles' => json_decode($memorandum->articles)
        ])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
    
        // Save the updated PDF fileStorage::put('public/memorandum/' . $fileName . '.pdf', $dompdf->output());
        Storage::put('public/memorandum/' . $fileName . '.pdf', $dompdf->output());
    
        //Gather user Role for Affiliate
        $affiliate_user = Auth::guard('affiliate')->user();

        // Determine the redirect route based on user role
        if ($affiliate_user) {
            $document = Document::with(['memorandum'])
                                ->where('memorandum_id', $memorandum->id)
                                ->firstOrFail();

            return redirect()->route('affiliateShowDocument', ['id' => $document->id, 'name' => $document->memorandum->partner_name]);
        } else {

            $institutionalUnit_user = Auth::guard('institutionalUnit')->user();
            if ($institutionalUnit_user)
            {
                $link = Link::with([
                    'memorandum', 
                    ])->where('memorandum_fk', $memorandum->id)->firstOrFail();
    
                return redirect()->route('resultProspectivePartnerForm', ['link' => $link->link]); // replace $someLink with the appropriate value
            }
        }

        // Redirect back to the view page with the updated files
        return redirect()->route('viewMemorandum', ['id' => $memorandum->id]);
    }    

    public function compareVersion($id, $version)
    {
        // Fetch the current (latest) version from the `memorandum` table
        $currentMemorandum = Memorandum::findOrFail($id);
        $isLatestVersion = $currentMemorandum->version == $version;
    
        if ($isLatestVersion) {
            // If the selected version is the latest, use the current `memorandum` as selectedVersion
            $selectedVersion = $currentMemorandum;
    
            // Fetch the previous version from the `memorandum_versions` table
            $previousVersion = MemorandumVersion::where('memorandum_id', $id)
                                ->where('version', '<', $version)
                                ->orderBy('version', 'desc')
                                ->first();
        } else {
            // Fetch the selected version from the `memorandum_versions` table
            $selectedVersion = MemorandumVersion::where([['memorandum_id', $id], ['version', $version]])->firstOrFail();
    
            // Fetch the previous version (immediately before the selected version)
            $previousVersion = MemorandumVersion::where('memorandum_id', $id)
                                ->where('version', '<', $version)
                                ->orderBy('version', 'desc')
                                ->first();
        }
    
        // If no previous version exists, handle gracefully
        if (!$previousVersion) {
            return response()->json(['error' => 'No previous version found for comparison.']);
        }
    
        // Decode JSON fields for comparison
        $selectedWhereas = json_decode($selectedVersion->whereas_clauses, true);
        $previousWhereas = json_decode($previousVersion->whereas_clauses, true);
        
        $selectedArticles = json_decode($selectedVersion->articles, true);
        $previousArticles = json_decode($previousVersion->articles, true);
    
        // Find differences between the previous and selected versions
        $whereasDiff = $this->getDifferences($previousWhereas, $selectedWhereas);
        $articlesDiff = $this->getDifferences($previousArticles, $selectedArticles);
    
        // Render HTML with differences for PDF
        $html = view('PartnerApplication.AffiliateView.pdfFormat', [
            'partner_name' => $selectedVersion->partner_name,
            'contact_person' => $selectedVersion->contact_person,
            'contact_email' => $selectedVersion->contact_email,
            'whereasDiff' => $whereasDiff,
            'articlesDiff' => $articlesDiff,
            'currentVersion' => $selectedVersion->version,
            'previousVersion' => $previousVersion->version,
        ])->render();
    
        // Generate and display PDF on the fly without saving
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
    
        // Return the PDF as a streamed response for embedding in an iframe
        return response($dompdf->output(), 200)
                ->header('Content-Type', 'application/pdf');
    }
    

    private function getDifferences($old, $new)
    {
        $diff = [];
        foreach ($new as $index => $newClause) {
            $oldClause = $old[$index] ?? null;
            
            // Check for changed clauses
            if ($oldClause && $oldClause != $newClause) {
                $diff[] = [
                    'status' => 'changed',
                    'removed' => $oldClause, // Store removed clause content
                    'added' => $newClause    // Store added clause content
                ];
            } 
            // Check for newly added clauses
            elseif (!$oldClause) {
                $diff[] = [
                    'status' => 'added',
                    'content' => $newClause  // Store added clause content
                ];
            } 
            // Unchanged clauses
            else {
                $diff[] = [
                    'status' => 'unchanged',
                    'content' => $newClause  // Store unchanged clause content
                ];
            }
        }
        
        // Check for removed clauses (present in $old but not in $new)
        foreach ($old as $index => $oldClause) {
            if (!isset($new[$index])) {
                $diff[] = [
                    'status' => 'removed',
                    'content' => $oldClause  // Store removed clause content
                ];
            }
        }
    
        return $diff;
    }
    
    
    public function displayMemorandumComparison($id, $version)
    {
        // Fetch the current version from the `memorandum` table
        $currentMemorandum = Memorandum::findOrFail($id);
    
        // Check if the selected version is the latest version
        $isLatestVersion = $currentMemorandum->version == $version;
    
        if ($isLatestVersion) {
            // If the selected version is the latest, use the `memorandum` record as `selectedVersion`
            $selectedVersion = $currentMemorandum;
        } else {
            // If not the latest, fetch from the `memorandum_versions` table
            $selectedVersion = MemorandumVersion::where([['memorandum_id', $id], ['version', $version]])->firstOrFail();
        }
    
        return view('PartnerApplication.AffiliateView.displayPdf', [
            'id' => $id,
            'version' => $version,
            'currentVersion' => $currentMemorandum->version,
            'selectedVersion' => $selectedVersion->version,
        ]);
    }

    //TODO Appending Uploaded

    public function appendDocument(Request $request, $id)
    {
        // Validate file upload
        $request->validate([
            'document' => 'required|file|mimes:pdf,docx',
        ]);

        // Fetch the memorandum
        $memorandum = Memorandum::findOrFail($id);
        
        // Generate file names
        $dateCreated = $memorandum->created_at->format('Ymd');
        $fileName = 'AUF-Memorandum-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;

        // File paths for existing files
        $docxFilePath = storage_path('app/public/memorandum/' . $fileName . '.docx');
        $pdfFilePath = storage_path('app/public/memorandum/' . $fileName . '.pdf');

        // Load the uploaded file
        $uploadedFile = $request->file('document');
        $uploadedFilePath = $uploadedFile->getRealPath();

        if ($uploadedFile->getClientOriginalExtension() === 'docx') {
            // Handle DOCX file
            $this->appendDocx($docxFilePath, $uploadedFilePath);
        } elseif ($uploadedFile->getClientOriginalExtension() === 'pdf') {
            // Handle PDF file
            $this->appendPdf($pdfFilePath, $uploadedFilePath);
        }

        // Redirect back or to another view as needed
        return redirect()->route('viewMemorandum', ['id' => $memorandum->id])
                        ->with('success', 'Document appended successfully.');
    }

    /**
     * Append content of a DOCX file to an existing DOCX file after removing its last page.
     */
    private function appendDocx($existingFilePath, $uploadedFilePath)
    {
        // Load the existing document
        $phpWord = PhpWordIOFactory::load($existingFilePath);
    
        // Remove the last section (last page) by removing the last section's elements
        $sections = $phpWord->getSections();
        $lastSection = end($sections);

        // Remove elements from the last section
        if ($lastSection) {
            $lastSection->clearElements(); // This should clear elements correctly
        }
    
        // Load the uploaded DOCX file and append its content
        $uploadedDoc = PhpWordIOFactory::load($uploadedFilePath);
        foreach ($uploadedDoc->getSections() as $section) {
            $newSection = $phpWord->addSection($section->getSettings());
    
            // Add each element to the new section in the existing document
            foreach ($section->getElements() as $element) {
                if ($element instanceof TextRun) {
                    $textRun = $newSection->addTextRun($element->getParagraphStyle());
                    foreach ($element->getElements() as $text) {
                        $textRun->addText($text->getText(), $text->getFontStyle(), $text->getParagraphStyle());
                    }
                }
                // Handle other element types (Tables, Lists, etc.) if present
            }
        }
    
        // Save the updated document
        $phpWordWriter = PhpWordIOFactory::createWriter($phpWord, 'Word2007');
        $phpWordWriter->save($existingFilePath);
    }

    /**
     * Append content of a PDF file to an existing PDF file after removing its last page.
     */
    private function appendPdf($existingFilePath, $uploadedFilePath)
    {
        // Load the existing PDF
        $pdf = new Fpdi();
        $pdf->setSourceFile($existingFilePath);
        $totalPages = $pdf->setSourceFile($existingFilePath);

        // Copy all but the last page
        for ($i = 1; $i < $totalPages; $i++) {
            $templateId = $pdf->importPage($i);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
        }

        // Load the uploaded PDF and append its pages
        $pdf->setSourceFile($uploadedFilePath);
        $uploadedPages = $pdf->setSourceFile($uploadedFilePath);

        for ($i = 1; $i <= $uploadedPages; $i++) {
            $templateId = $pdf->importPage($i);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
        }

        // Save the updated PDF
        $outputFilePath = storage_path('app/public/memorandum/' . basename($existingFilePath));
        $pdf->Output('F',$outputFilePath);
    }
}
