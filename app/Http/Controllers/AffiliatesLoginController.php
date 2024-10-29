<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AffiliatesLoginController extends Controller
{
    public function showAffiliateLoginDocument($id, $name)
    {
        return view('PartnerApplication.AffiliateView.loginPage', ['id' => $id, 'name' => $name]);
    }
    public function affiliateLoginDocument(Request $request, $id, $name)
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
            return redirect()->intended(route('affiliateShowDocument', ['id' => $id, 'name' => $name]));
        }
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showAffiliateChangePasswordDocument($id, $name)
    {
        return view('affiliates.changePassword', ['id' => $id, 'name' => $name]);
    }

    public function affiliateChangePassword(Request $request, $id, $name)
    {
        $request->validate([
            'password' => 'required|min:4|confirmed'
        ]);

        $affiliate = Auth::guard('affiliate')->user();
        $affiliate->password = Hash::make($request->password);
        $affiliate->must_change_password = false;
        $affiliate->save();

        return redirect()->route('affiliateLoginDocument', ['id' => $id, 'name' => $name]);
    }
}
