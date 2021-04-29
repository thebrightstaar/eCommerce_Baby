<?php

namespace App\Http\Controllers\API\admainController;

use App\Http\Controllers\API\admainController\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResources;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    //show all product
    public function index()
    {
        $products = Product::latest()->get();
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
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found!');
        }
        $product->delete();
        return $this->sendResponse(new ProductResources($product), 'Product deleted Successfully!');
    }



    //create a product by admain
    public function store(Request $request)
    {
        $this->validate($request, [
            'images' => 'required|array|max:5',
            'images.*' => 'image'
        ]);

        $images = array();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = Str::of(time() . $img->getClientOriginalName())->replace(' ', '');
                $img->move(public_path() . '/upload/products/', $name);
                $images[] = $name;
            }
        }

        $product = new Product;
        $product->title = $request->title;
        $product->id_departmant = $request->id_departmant;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->color = $request->color;
        $product->quantity = $request->quantity;
        $product->image = json_encode($images);
        $product->discount = $request->discount;
        $product->save();

        return $product;
    }

    // search on a product by its name
    public function search($key)
    {
        return Product::where('title', 'Like', "%$key%")->get();
    }

    public function image($fileName)
    {
        $path = public_path() . '/upload/products/' . $fileName;
        return Response::file($path);
    }
}
