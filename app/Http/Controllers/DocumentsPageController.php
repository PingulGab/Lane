<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentsPageController extends Controller
{
    public function documents()
    {
        if (request()->ajax()) {
            return view('documents_page'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('documents_page')
        ]);
    }
}
