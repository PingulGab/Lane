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
            'partnership_title' => 'string',
            'combined_duration' => 'string|max:255',
            'whereas_clauses' => 'nullable|array',
            'whereas_clauses.*' => 'required|string',
            'whereas_clause_texts' => 'nullable|array',
            'whereas_clause_texts.*' => 'required|string',

            'article1' => 'nullable|array',
            'article1.*' => 'required|string',

            'article2' => 'required|array',
            'article2.*' => 'required|string',

            'article3' => 'required|array',
            'article3.*' => 'required|string',

            'article5' => 'required|array',
            'article5.*' => 'required|string',

            'article6' => 'required|array',
            'article6.*' => 'required|string',

            'article7' => 'required|array',
            'article7.*' => 'required|string',

            'article8' => 'required|array',
            'article8.*' => 'required|string',

            'article9' => 'required|array',
            'article9.*' => 'required|string',

            'article10' => 'required|array',
            'article10.*' => 'required|string',

            'article11' => 'required|array',
            'article11.*' => 'required|string',

            'article12' => 'required|array',
            'article12.*' => 'required|string',

            'article13' => 'required|array',
            'article13.*' => 'required|string',

            'article14' => 'required|array',
            'article14.*' => 'required|string',

            'article15' => 'required|array',
            'article15.*' => 'required|string',

            'article16' => 'required|array',
            'article16.*' => 'required|string',

            'article17' => 'required|array',
            'article17.*' => 'required|string',

            'article18' => 'required|array',
            'article18.*' => 'required|string',

            'article19' => 'required|array',
            'article19.*' => 'required|string',

            'article20' => 'required|array',
            'article20.*' => 'required|string',

            'article21' => 'required|array',
            'article21.*' => 'required|string',
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
        $memorandum->partnership_title = $validatedData['partnership_title'];
        $memorandum->whereas_clauses = json_encode($combinedWhereasClauses); // Save both dropdown and text
        $memorandum->validity_period = $validatedData['combined_duration'];
        $memorandum->article_1 = json_encode($validatedData['article1']);
        $memorandum->article_2_partner = json_encode($validatedData['article2']);
        $memorandum->article_3 = json_encode($validatedData['article3']);
        $memorandum->article_5 = json_encode($validatedData['article5']);
        $memorandum->article_6 = json_encode($validatedData['article6']);
        $memorandum->article_7 = json_encode($validatedData['article7']);
        $memorandum->article_8 = json_encode($validatedData['article8']);
        $memorandum->article_9 = json_encode($validatedData['article9']);
        $memorandum->article_10 = json_encode($validatedData['article10']);
        $memorandum->article_11 = json_encode($validatedData['article11']);
        $memorandum->article_12 = json_encode($validatedData['article12']);
        $memorandum->article_13 = json_encode($validatedData['article13']);
        $memorandum->article_14 = json_encode($validatedData['article14']);
        $memorandum->article_15 = json_encode($validatedData['article15']);
        $memorandum->article_16 = json_encode($validatedData['article16']);
        $memorandum->article_17 = json_encode($validatedData['article17']);
        $memorandum->article_18 = json_encode($validatedData['article18']);
        $memorandum->article_19 = json_encode($validatedData['article19']);
        $memorandum->article_20 = json_encode($validatedData['article20']);
        $memorandum->article_21 = json_encode($validatedData['article21']);
        $memorandum->save();
    
        // Call the Link Model from Session (Set in ProspectivePartnerFormController@SubmittedProposalForm)
        $link_id = session('link_id');
        $linkModel = Link::where('id', $link_id)->firstOrFail();
        session()->forget('link_id');

        // Generate the file name: AUF-MOA-[partner_name]-[datecreated]
        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-Memorandum-' . str_replace(' ', '-', $linkModel->proposalForm->institution_name) . '-' . $dateCreated;
    
        // Generate the PDF using DOMPDF
        $combinedWhereasClausesForPdf = [];
        $partnerAcronym = $linkModel->proposalForm->institution_name_acronym;
        foreach ($combinedWhereasClauses as $index => $clauseData) {
            $dropdownText = $clauseData['dropdown'];
            $textContent = ucfirst($clauseData['text']); // Capitalize the first letter of the text
        
            // Define logic for conditional bolding
            if ($dropdownText === 'the AUF') {
                $formattedClause = '<span class="bold">WHEREAS,</span> the <span class="bold">AUF</span> ' . $textContent;
            } elseif ($dropdownText === "the AUF and {$partnerAcronym}") {
                $formattedClause = '<span class="bold">WHEREAS,</span> the <span class="bold">AUF and ' . $partnerAcronym . '</span> ' . $textContent;
            } elseif ($dropdownText === "the {$partnerAcronym}") {
                $formattedClause = '<span class="bold">WHEREAS,</span> the <span class="bold">' . $partnerAcronym . '</span> ' . $textContent;
            } else {
                $formattedClause = '<span class="bold">WHEREAS,</span> <span class="bold">' . $dropdownText . '</span> ' . $textContent;
            }
        
            // Add the formatted clause to the array for PDF rendering
            $combinedWhereasClausesForPdf[] = $formattedClause;
        }
        
        $dompdf = new Dompdf();
        $html = view('components.memorandum.memorandum_template', [
            'link' => $linkModel,
            'partnership_title' => $validatedData['partnership_title'],
            'sign_date' => 'TBA',
            'sign_location' => 'TBA',
            'validity_period' => $memorandum->validity_period,
            'article1' => json_decode($memorandum->article_1),
            'article2' => json_decode($memorandum->article_2_partner),
            'article3' => json_decode($memorandum->article_3),
            'article4' => json_decode($memorandum->article_4),
            'article5' => json_decode($memorandum->article_5),
            'article6' => json_decode($memorandum->article_6),
            'article7' => json_decode($memorandum->article_7),
            'article8' => json_decode($memorandum->article_8),
            'article9' => json_decode($memorandum->article_9),
            'article10' => json_decode($memorandum->article_10),
            'article11' => json_decode($memorandum->article_11),
            'article12' => json_decode($memorandum->article_12),
            'article13' => json_decode($memorandum->article_13),
            'article14' => json_decode($memorandum->article_14),
            'article15' => json_decode($memorandum->article_15),
            'article16' => json_decode($memorandum->article_16),
            'article17' => json_decode($memorandum->article_17),
            'article18' => json_decode($memorandum->article_18),
            'article19' => json_decode($memorandum->article_19),
            'article20' => json_decode($memorandum->article_20),
            'article21' => json_decode($memorandum->article_21),
            'whereasClauses' => $combinedWhereasClausesForPdf, // Send combined whereas clauses
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

    public function partnerEditMemorandum($link)
    {    
        $linkModel = Link::where('link', $link)->firstOrFail();
        $memorandumModel = $linkModel->memorandum;

        return view('PartnerApplication.PartnerView.editMemorandum', ['link' => $linkModel, 'memorandum' => $memorandumModel]);
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
            'whereas_clauses.*' => 'required|string',
            'articles' => 'nullable|array',
            'articles.*' => 'required|string',
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
            'date_of_signing' => 'required|date',
            'valid_until' => 'required|date',
            'intl_students_outbound' => 'nullable|integer|min:0',
            'intl_students_inbound' => 'nullable|integer|min:0',
            'intl_faculty_outbound' => 'nullable|integer|min:0',
            'intl_faculty_inbound' => 'nullable|integer|min:0',
            'local_students_auf' => 'nullable|integer|min:0',
            'local_students_other' => 'nullable|integer|min:0',
            'local_faculty_auf' => 'nullable|integer|min:0',
            'local_faculty_other' => 'nullable|integer|min:0',
        ]);

        // Fetch the memorandum
        $documentModel = Document::findOrFail($id);
        $memorandum = Memorandum::findOrFail($documentModel->memorandum->id);
        
        // Update 'is_signed' status
        $documentModel->update([
            'is_signed' => true
        ]);

        // Generate file names
        $dateCreated = $memorandum->created_at->format('Ymd');
        $fileName = 'AUF-Memorandum-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;

        // File paths for existing files
        $pdfFilePath = storage_path('app/public/memorandum/' . $fileName . '.pdf');

        // Load the uploaded file
        $uploadedFile = $request->file('document');
        $uploadedFilePath = $uploadedFile->getRealPath();

        // Check file type and append
        if ($uploadedFile->getClientOriginalExtension() === 'pdf') {
            $uploadedFilePath = $uploadedFile->getRealPath();
            $this->appendPdf($pdfFilePath, $uploadedFilePath);

            // Redirect back with success message
            return redirect()->route('showSignPendingView', [
                'id' => $memorandum->id,
                'name' => $memorandum->partner_name
            ])->with('success', 'Document appended successfully.');
        } else {
            // Redirect back with error message if not a PDF
            return redirect()->route('showSignPendingView', [
                'id' => $memorandum->id,
                'name' => $memorandum->partner_name
            ])->withErrors(['error' => 'File must be a PDF.']);
        }
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
