<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsPageController extends Controller
{
    public function settings()
    {
        if (request()->ajax()) {
            return view('settings_page'); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('settings_page')
        ]);
    }
}
