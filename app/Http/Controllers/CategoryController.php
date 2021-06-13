<?php

namespace App\Http\Controllers\CategoryController;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::all();
        return view('categories.index')->with(compact(['categories']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('categories.create')->with(compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;

        if ($category->save() ) {
            return redirect()->route('categories.index')->with(['success' => 'Category added successfully.']);
        }

        return redirect()->back()->with(['fail' => 'Unable to add category.']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::find($id);
        return view('categories.edit')->with(compact(['categories', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->name = $request->name;

        if ($request->save() ) {
            return redirect()->route('categories.index')->with(['success' => 'Category successfully updated.']);
        }

        return redirect()->back()->with(['fail' => 'Unable to update category.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {

    //     if ($id->delete()) {
    //         return redirect()->back()->with(['success' => 'Category successfully deleted.']);
    //     }

    //     return redirect()->back()->with(['fail' => 'Unable to delete category.']);
    // }

}


