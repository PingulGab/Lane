<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class ProspectivePartnerResultController extends Controller
{
    public function showResult($link)
    {
        $link = Link::with(['memorandum', 'proposalForm', 'endorsementForm'])->where('link', $link)->firstOrFail();

        // Load related data if available
        $data = [
            'link' => $link,
            'memorandum' => $link->memorandum,
            'proposalForm' => $link->proposalForm,
            'endorsementForm' => $link->endorsementForm,
        ];

        return view('result', $data);
    }
}