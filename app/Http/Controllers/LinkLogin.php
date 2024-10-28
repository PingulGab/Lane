<?php
namespace App\Http\Controllers;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LinkLogin extends Controller
{
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


}
