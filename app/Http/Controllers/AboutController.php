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

        return redirect()->route('about.index')->with('message', __('contact.aboutCreate'));
    }

    public function edit($id)
    {
        $about = About::find($id);
        if (!$about) {
            return redirect()->route('about.index')->with('message', __('contact.aboutNoFound'));
        }

        if (!Auth::id() === $about->user_id) {
            return redirect()->route('about.index')->with('message', __('contact.aboutNotAccess'));
        }

        return view('abouts.edit', compact("about"));
    }

    public function update(Request $request, $id)
    {
        $about = About::find($id);
        if (!$about) {
            return redirect()->route('about.index')->with('message', __('contact.aboutNotFound'));
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

        return redirect()->route('about.index')->with('message', __('contact.aboutUpdate'));
    }

    public function destroy($id)
    {
        $about = About::find($id);
        if (!$about) {
            return redirect()->route('about.index')->with('message', __('contact.aboutNotFound'));
        }

        $about->delete();

        return redirect()->route('about.index')->with('message', __('contact.aboutDelete'));
    }
}
