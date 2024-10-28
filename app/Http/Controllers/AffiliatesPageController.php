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
    public function affiliates()
    {
        $affiliates = Affiliate::all();
        return view('Affiliates.index', compact('affiliates'));
    }

    public function showNewAffiliateForm()
    {
        return view('layouts.layout', [
            'content' => view('affiliates.create')
        ]);
    }

    public function storeNewAffiliate(Request $request)
    {
        // Validate the incoming request
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'contact_person' => 'required|string|max:255',
            ], [
                'name.required' => 'The name field is required.',
                'username.unique' => 'This username is already taken.',
                'email.unique' => 'This email is already taken.',
                'email.email' => 'Please enter a valid email address.',
                'contact_person.required' => 'The contact number is required.',
            ]);
    
            // If validation passes, create the affiliate
            $password = Str::random(8);
    
            $newAffiliate = Affiliate::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($password),
                'contact_person' => $validatedData['contact_person'],
                'must_change_password' => true,
            ]);
    
            // Return success response
            return response()->json([
                'id' => $newAffiliate->id,
                'name' => $validatedData['name'],
                'password' => $password,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle unique constraint violation
            if ($e->getCode() === '23000') {
                return response()->json(['errors' => [
                    'email' => ['This email is already taken.'],
                    'username' => ['This username is already taken.']
                ]], 422);
            }
            
            // Return generic error message for other exceptions
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }    

}
