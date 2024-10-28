<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function showLoginForm($link)
    {

        $data = [
            'link' => $link,
        ];

        return view('link_generation.affiliate-login', $data);
    }

    public function login(Request $request, $link)
    {
        $credentials = $request->only('username', 'password');

        // Debugging: Check credentials and their hash in the database
        $affiliate = Affiliate::where('username', $credentials['username'])->first();
        
        if (!$affiliate) {
            return back()->withErrors([
                'username' => 'Username does not exist.',
            ]);
        }
    
        // Check if the entered password matches the stored password hash
        if (!\Hash::check($credentials['password'], $affiliate->password)) {
            return back()->withErrors([
                'password' => 'Password does not match.',
            ]);
        }
    
        // Attempt authentication using the guard
        if (Auth::guard('affiliate')->attempt($credentials)) {
            return redirect()->intended('/result/' . $link);
        }
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
}