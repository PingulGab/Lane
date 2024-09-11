<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliatesPageController extends Controller
{
    public function affiliates()
    {
        if (request()->ajax()) {
            return view('affiliates_page'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('affiliates_page')
        ]);
    }
}
