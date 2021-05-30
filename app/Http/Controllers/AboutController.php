<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function indexApi()
    {
        $about = About::latest()->get();
        return response()->json(['success' => true, 'data' => $about], 200);
    }

    public function index()
    {
        $about = About::latest()->first();
        return view('abouts.index', compact('about'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'email' => 'required|email',
            'address' => 'string|nullable',
            'whatsapp' => 'integer|nullable'
        ]);

        About::create($request->toArray());

        return redirect()->route('about.index')->with('message', 'About Us Created Successfully!');
    }

    public function edit($id)
    {
        $about = About::find($id);
        if (!$about) {
            return redirect()->route('about.index')->with('message', 'About Us Is Not Found');
        }

        if (!Auth::id() === $about->user_id) {
            return redirect()->route('about.index')->with('message', 'You Do Not Have Rights To Access');
        }

        return view('abouts.edit', compact("about"));
    }

    public function update(Request $request, $id)
    {
        $about = About::find($id);
        if (!$about) {
            return redirect()->route('about.index')->with('message', 'About Us Is Not Found');
        }

        $this->validate($request, [
            'description' => 'required',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'email' => 'required|email',
            'address' => 'string|nullable',
            'whatsapp' => 'integer|nullable'
        ]);

        $about->description = $request->description;
        $about->facebook = $request->facebook;
        $about->instagram = $request->instagram;
        $about->email = $request->email;
        $about->address = $request->address;
        $about->whatsapp = $request->whatsapp;
        $about->save();

        return redirect()->route('about.index')->with('message', 'About Us Updated Successfully');
    }

    public function destroy($id)
    {
        $about = About::find($id);
        if (!$about) {
            return redirect()->route('about.index')->with('message', 'About Us Is Not Found');
        }

        $about->delete();

        return redirect()->route('about.index')->with('message', 'About Us Deleted Successfully');
    }
}
