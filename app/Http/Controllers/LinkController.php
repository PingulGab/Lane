<?php

namespace App\Http\Controllers;
use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function viewLink()
    {
        $links = Link::where('isActive', true)->get();
        
        if (request()->ajax()) {
            return view('LinkGeneration.index', ['links' => $links]); // Only return the content part
        }
    
        return view('layouts.layout', [
            'content' => view('LinkGeneration.index', ['links' => $links])
        ]);
    }

    public function storeNewLink(Request $request)
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
            'link' => route("prospectPartnerViewLink",$link),
            'password' => $password,
        ]);
    }

    public function deleteLink($id)
    {
        $link = Link::findOrFail($id);
        $link->update(['isActive' => false]);

        return back();
    }
}
