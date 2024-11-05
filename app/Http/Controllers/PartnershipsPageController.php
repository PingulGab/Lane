<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;

class PartnershipsPageController extends Controller
{
    public function partnerships()
    {
        $partnership = Partnership::all();
        if (request()->ajax()) {
            return view('Partnerships.index', ['partnership' => $partnership]); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('Partnerships.index', ['partnership' => $partnership])
        ]);
    }

    public function viewPartnership($id, $name)
    {
        $partnership = Partnership::where('id', $id)->firstOrFail();
        return view('Partnerships.viewPartnership', ['partnership' => $partnership]);
    }
}
