<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.add_product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $request->all();
        $this->validate($request, [

            'name' => 'required|string',
            'slug' =>  'required|slug',
            'short_description'=> 'required|string',
            'description'=> 'required|text',
            'price'=> 'required|decimal',
            'SKU'=> 'required|string',
            'stock_status'=> 'required|enum',
            'featured'=> 'required|boolean',
            'quantity'=> 'required|integer',
            'image_1'=> 'required|image',
            'image_2'=> 'required|image',
            'image_3'=> 'required|image',
            'image_4'=> 'required|image',
            'image_5'=> 'required|image',
            'color'=> 'required|string'
        ]);


       Product::create( $product,[

            'name' => 'required|string',
            'slug' =>  'required|slug',
            'short_description'=> 'required|string',
            'description'=> 'required|text',
            'price'=> 'required|decimal',
            'SKU'=> 'required|string',
            'stock_status'=> 'required|enum',
            'featured'=> 'required|boolean',
            'quantity'=> 'required|integer',
            'image_1'=> 'required|image',
            'image_2'=> 'required|image',
            'image_3'=> 'required|image',
            'image_4'=> 'required|image',
            'image_5'=> 'required|image',
            'color'=> 'required|string'
       ]);

        //    return redirect()->route('product.store')->with('message', 'product Created Successfully');
        // return view('product.add_product');
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
        $product = Product::find($id);
        return view('product.edit_product');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
