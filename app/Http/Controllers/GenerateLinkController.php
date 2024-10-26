<?php

namespace App\Http\Controllers;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GenerateLinkController extends Controller
{
    public function viewGenerate()
    {
        $links = Link::where('isActive', true)->get();
        
        if (request()->ajax()) {
            return view('link_generation.link-generation', ['links' => $links]); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('link_generation.link-generation', ['links' => $links])
        ]);
    }

    public function generateLink(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $link = Str::random(10);
        $password = Str::random(8);

        $newLink = Link::create([
            'name' => $request->name,
            'link' => $link,
            'password' => bcrypt($password),
        ]);

        return response()->json([
            'id' => $newLink->id,
            'name' => $request->name,
            'link' => url("/link/{$link}"),
            'password' => $password,
        ]);
    }

    // Display the link page
    public function showLink($link)
    {
        $link = Link::where('link', $link)->firstOrFail();

        // Check if the user is authenticated and if session timestamp exists
        $authSessionKey = "authenticated_{$link->id}";
        $authTimestampKey = "authenticated_{$link->id}_time";

        if (Session::has($authSessionKey) && Session::has($authTimestampKey)) {
            $authenticatedTime = Carbon::parse(Session::get($authTimestampKey));

            // Check if the session has expired (after 1 hour)
            if ($authenticatedTime->diffInMinutes(now()) <= 180) {
                // Session is valid, show protected content
                return view('link_generation.protected-content', ['link' => $link]);
            } else {
                // Session expired, remove the session variables
                Session::forget($authSessionKey);
                Session::forget($authTimestampKey);
            }
        }

        // If not authenticated or session expired, show the password form
        return view('link_generation.password-form', ['link' => $link]);
    }
    
    // Validate the password entered by the user
    public function validatePassword(Request $request, $link)
    {
        $link = Link::where('link', $link)->firstOrFail();

        if (password_verify($request->password, $link->password)) {
            // Password is correct, store authentication status in session
            $authSessionKey = "authenticated_{$link->id}";
            $authTimestampKey = "authenticated_{$link->id}_time";

            Session::put($authSessionKey, true);
            Session::put($authTimestampKey, now()); // Store the current time for expiry check

            // Redirect back to the same link (so the content is displayed)
            return redirect()->route('show-link', $link->link);
        }

        // Password is incorrect, return back with an error
        return back()->withErrors(['password' => 'Invalid password.']);
    }

    public function deleteLink($id)
    {
        $link = Link::findOrFail($id);
        $link->update(['isActive' => false]);

        return back();
    }
}
