<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnershipsPageController extends Controller
{
    public function partnerships()
    {
        if (request()->ajax()) {
            return view('partnerships_page'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('partnerships_page')
        ]);
    }
}
