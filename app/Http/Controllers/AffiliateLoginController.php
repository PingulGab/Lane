<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AffiliateLoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('college.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        $affiliate = Affiliate::where('username', $credentials['username'])->first();

        if ($affiliate && Hash::check($credentials['password'], $affiliate->password)) {
            if ($affiliate->must_change_password) {
                // Redirect to change password page
                return redirect()->route('college.showChangePasswordForm');
            }

            Auth::login($affiliate);
            return redirect()->route('protected.content');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    // Show password change form
    public function showChangePasswordForm()
    {
        return view('affiliate.change-password');
    }

    // Handle password change
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|confirmed|min:8',
        ]);

        $affiliate = Auth::user();
        $affiliate->update([
            'password' => Hash::make($request->new_password),
            'must_change_password' => false,
        ]);

        return redirect()->route('protected.content')->with('success', 'Password changed successfully');
    }
}
