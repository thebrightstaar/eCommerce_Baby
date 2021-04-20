<?php

namespace App\Http\Controllers\API\admainController;
use App\Http\Controllers\API\admainController\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResources;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{
    //show all product
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResources::collection($products), 'Product retrieved Successfully!');
    }


    //show one product
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found!');
        }

        return $this->sendResponse(new ProductResources($product), 'Product retrieved Successfully!');
    }


    //delete one product
    public function destroy($id)
    {
        $product=Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found!');
        }
        $product->delete();
        return $this->sendResponse(new ProductResources($product), 'Product deleted Successfully!');

    }



    //create a product by admain
    public function create(Request $request)
    {
 /* id	price	discount	description		image_2	image_3
 image_4	image_5	color	product_name	quantity
 id_departmant	created_at	updated_at  */

        $product= new Product;
        $product->price= $request->input('price');
        $product->discount= $request->input('discount');
        $product->description= $request->input('description');
        $product->image_1=$request->file('image_1')->store('products');
        $product->image_2=$request->file('image_2')->store('products');
        $product->image_3=$request->file('image_3')->store('products');
        $product->image_4=$request->file('image_4')->store('products');
        $product->image_5=$request->file('image_5')->store('products');
        $product->color= $request->input('color');
        $product->product_name= $request->input('product_name');
        $product->quantity= $request->input('quantity');
        $product->id_departmant= $request->input('id_departmant');
        $product->save();

        return $product;

    }

    // search on a product by its name
    public function search($key)
    {
        return Product::where('product_name', 'Like',"%$key%")->get();
    }
}
