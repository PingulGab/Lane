<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CollegeLogin extends Controller
{
    public function resultLogin(Request $request, $link)
    {
        $credentials = $request->only('username', 'password');

        // Debugging: Check credentials and their hash in the database
        $college = College::where('username', $credentials['username'])->first();
        
        if (!$college) {
            return back()->withErrors([
                'username' => 'Username does not exist.',
            ]);
        }
    
        // Check if the entered password matches the stored password hash
        if (!\Hash::check($credentials['password'], $college->password)) {
            return back()->withErrors([
                'password' => 'Password does not match.',
            ]);
        }
    
        // Attempt authentication using the guard
        if (Auth::guard('college')->attempt($credentials)) {
            return redirect()->intended(route('resultProspectivePartnerForm', ['link'=>$link]));
        }
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showCollegeChangePassword($link)
    {
        return view('affiliates.College.changePassword', compact('link'));
    }

    public function collegeChangePassword(Request $request, $link)
    {
        $request->validate([
            'password' => 'required|min:4|confirmed'
        ]);

        $college = Auth::guard('college')->user();
        $college->password = Hash::make($request->password);
        $college->must_change_password = false;
        $college->save();

        return redirect()->route('resultLogin', ['link' => $link]);
    }
}
