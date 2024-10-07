<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function landing()
    {
        return view('landing_page');
    }

    public function authenticateUser() 
    {
        return redirect()->route('dashboard'); 
    }
}
