<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsPageController extends Controller
{
    public function statistics()
    {
        if (request()->ajax()) {
            return view('statistics_page'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('statistics_page')
        ]);
    }
}
