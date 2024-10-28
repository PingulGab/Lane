<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsPageController extends Controller
{
    public function statistics()
    {
        if (request()->ajax()) {
            return view('Statistics.index'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('Statistics.index')
        ]);
    }
}
