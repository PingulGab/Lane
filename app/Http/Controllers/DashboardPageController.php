<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPageController extends Controller
{
    public function dashboard()
    {
        if (request()->ajax()) {
            return view('Dashboard.index'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('Dashboard.index')
        ]);
    }
}
