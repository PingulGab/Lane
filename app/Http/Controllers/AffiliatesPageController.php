<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AffiliatesPageController extends Controller
{
    // Show list of affiliates for admin
    public function index()
    {
        $affiliates = Affiliate::all();
        return view('affiliates.affiliates-page', compact('affiliates'));
    }

    // Show form to create a new affiliates
    public function create()
    {
        return view('affiliates.affiliates-create');
    }

    // Store new affiliates account
    public function store(Request $request)
    {
        $request->validate([
            'affiliate_name' => 'required',
            'affiliate_contact_person' => 'required',
            'affiliate_email' => 'required|email|unique:affiliates',
            'username' => 'required|unique:affiliates',
        ]);

        // Generate random password
        $randomPassword = Str::random(12);

        // Create new affiliates record
        Affiliate::create([
            'affiliate_name' => $request->affiliate_name,
            'affiliate_contact_person' => $request->affiliate_contact_person,
            'affiliate_email' => $request->affiliate_email,
            'username' => $request->username,
            'password' => $randomPassword,
        ]);

        return redirect()->route('affiliatesIndex')->with('success', 'Affiliate account created. Password: ' . $randomPassword);
    }

    // Reset the password of a affiliates account
    public function resetPassword(Affiliate $affiliate)
    {
        // Generate new random password
        $newPassword = Str::random(12);

        // Update password and require a password change on next login
        $affiliate->update([
            'password' => $newPassword,
            'must_change_password' => true,
        ]);

        return redirect()->route('affiliatesIndex')->with('success', 'Password reset. New password: ' . $newPassword);
    }
    
        // Handle college login with username and password
        public function affiliateLogin(Request $request, $link)
        {
            $credentials = $request->only('username', 'password');
    
            // Try to find the college by username
            $affiliate = Affiliate::where('username', $credentials['username'])->first();
    
            if ($affiliate && Hash::check($credentials['password'], $affiliate->password)) {
                if ($affiliate->must_change_password) {
                    // If the college must change password, redirect to change password form
                    return redirect()->route('show-link', $link->link);
                }
    
                // Log the college in and grant access
                Auth::login($affiliate);
                return redirect()->route('protected.content');
            }
    
            // Invalid credentials
            return back()->withErrors(['username' => 'Invalid username or password']);
        }
}
