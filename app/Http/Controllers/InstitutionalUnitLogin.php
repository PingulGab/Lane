<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\InstitutionalUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InstitutionalUnitLogin extends Controller
{
    public function resultLogin(Request $request, $link)
    {
        $credentials = $request->only('username', 'password');

        // Debugging: Check credentials and their hash in the database
        $institutionalUnit = InstitutionalUnit::where('username', $credentials['username'])->first();
        
        if (!$institutionalUnit) {
            return back()->withErrors([
                'username' => 'Username does not exist.',
            ]);
        }
    
        // Check if the entered password matches the stored password hash
        if (!\Hash::check($credentials['password'], $institutionalUnit->password)) {
            return back()->withErrors([
                'password' => 'Password does not match.',
            ]);
        }
    
        // Attempt authentication using the guard
        if (Auth::guard('institutionalUnit')->attempt($credentials)) {
            return redirect()->intended(route('resultProspectivePartnerForm', ['link'=>$link]));
        }
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showInstitutionalUnitChangePassword($link)
    {
        return view('affiliates.InstitutionalUnit.changePassword', compact('link'));
    }

    public function institutionalUnitChangePassword(Request $request, $link)
    {
        $request->validate([
            'password' => 'required|min:4|confirmed'
        ]);

        $institutionalUnit = Auth::guard('institutionalUnit')->user();
        $institutionalUnit->password = Hash::make($request->password);
        $institutionalUnit->must_change_password = false;
        $institutionalUnit->save();

        return redirect()->route('resultLogin', ['link' => $link]);
    }

    public function showSignPendingLogin($id, $name)
    {
        return view('PartnerApplication.InstitutionalUnitView.signPending.loginPage', ['id' => $id, 'name' => $name]);
    }
    public function signPendingLogin(Request $request, $id, $name)
    {
        $credentials = $request->only('username', 'password');

        // Debugging: Check credentials and their hash in the database
        $institutionalUnit = InstitutionalUnit::where('username', $credentials['username'])->first();
        
        if (!$institutionalUnit) {
            return back()->withErrors([
                'username' => 'Username does not exist.',
            ]);
        }
    
        // Check if the entered password matches the stored password hash
        if (!\Hash::check($credentials['password'], $institutionalUnit->password)) {
            return back()->withErrors([
                'password' => 'Password does not match.',
            ]);
        }
    
        // Attempt authentication using the guard
        if (Auth::guard('institutionalUnit')->attempt($credentials)) {
            return redirect()->intended(route('showSignPendingView', ['id'=>$id, 'name' => $name]));
        }
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
}
