<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'contact_number' => 'required|string|max:15',
        ], [
            'name.required' => 'The name field is required.',
            'username.unique' => 'This username is already taken.',
            'email.email' => 'Please enter a valid email address.',
            'password.confirmed' => 'The password confirmation does not match.',
            'contact_number.required' => 'The contact number is required.'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'role' => 'Employee', // Default role
            'isActive' => true,
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Please enter your username.',
            'password.required' => 'Please enter your password.',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['loginError' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showLoginForm()
    {
        return view('landing_page');
    }

    public function showRegistrationForm()
    {
        return view('register');
    }
}
