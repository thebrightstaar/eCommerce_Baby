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
            'images' => 'required|image|array|max:5',
        ]);

        $images = array();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = time() . $img->getClientOriginalName();
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
        return Product::where('product_name', 'Like', "%$key%")->get();
    }
}
