<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Memorandum;
use Carbon\Carbon;

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
        $validatedData = $request->validate([
            'partner_name' => 'required|string|max:255',
            'whereas_clauses' => 'nullable|array',
            'whereas_clauses.*' => 'required|string|max:1000',
            'articles' => 'nullable|array',
            'articles.*' => 'required|string|max:1000',
        ]);

        $memorandum = new Memorandum();
        $memorandum->partner_name = $validatedData['partner_name'];
        $memorandum->whereas_clauses = json_encode($validatedData['whereas_clauses']);
        $memorandum->articles = json_encode($validatedData['articles']);
        $memorandum->save();

        $dateCreated = Carbon::now()->format('Ymd');
        $fileName = 'AUF-MOA-' . str_replace(' ', '-', $memorandum->partner_name) . '-' . $dateCreated;

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 16, 'name' => 'Times New Roman'], ['alignment' => 'center']);
        $phpWord->addFontStyle('paragraphStyle', ['size' => 12, 'name' => 'Times New Roman']);
        $phpWord->addParagraphStyle('justify', ['alignment' => 'both']);
        
        $section->addTitle('Memorandum of Agreement', 1);
        $section->addText('This Memorandum of Agreement is made by and between:', 'paragraphStyle');
        $section->addText($memorandum->partner_name, ['bold' => true, 'size' => 12, 'name' => 'Times New Roman']);

        $section->addText('Whereas Clauses', 'paragraphStyle');
        foreach (json_decode($memorandum->whereas_clauses, true) as $index => $clause) {
            $section->addText(($index + 1) . ". " . $clause, 'paragraphStyle', 'justify');
        }

        $section->addText('Article 3: Scope of Collaboration', 'paragraphStyle');
        foreach (json_decode($memorandum->articles, true) as $index => $article) {
            $section->addText('3.' . ($index + 1) . ' ' . $article, 'paragraphStyle', 'justify');
        }

        $docxFilePath = storage_path('app/public/' . $fileName . '.docx');
        $phpWord->save($docxFilePath, 'Word2007');

        $dompdf = new Dompdf();
        $html = view('generate_moa.pdf_view', ['partner_name' => $memorandum->partner_name, 'whereasClauses' => json_decode($memorandum->whereas_clauses), 'articles' => json_decode($memorandum->articles)])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::put('public/' . $fileName . '.pdf', $dompdf->output());

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
