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
    public function showAllProduct()
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

        $input=$request->all();
        $validator = Validator::make($input, [
            'price'=>'required',
            'discount'=>'required',
            'description'=>'required',
            'image_1'=>'required|image',
            'color'=>'required',
            'product_name'=>'required',
            'quantity'=>'required',
            'id_departmant'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }
        $input['image_1']=$request->file('image_1')->store('products');
        $product=Product::create($input);
        return $this->sendResponse(new ProductResources($product), 'Product deleted Successfully!');
    }

    // search on a product by its name
    public function search($key)
    {
        $products=Product::where('product_name', 'Like',"%$key%")->get();
        return $this->sendResponse(ProductResources::collection($products), 'Product retrieved Successfully!');

    }

    // adding image_2
    public function addImage_2(Request $request, $id)
    {
        $product=Product::find($id);
        $product->image_2=$request->file('image_2')->store('products');
        $validator = Validator::make($request->all(), [

            'image_2'=>'required|image',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }
        $product->save();
        return $this->sendResponse(ProductResources::make($product), 'Product retrieved Successfully!');

    }

    // adding image_3
    public function addImage_3(Request $request, $id)
    {
        $product=Product::find($id);
        $product->image_3=$request->file('image_3')->store('products');
        $validator = Validator::make($request->all(), [

            'image_3'=>'required|image',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }
        $product->save();
        return $this->sendResponse(ProductResources::make($product), 'Product retrieved Successfully!');

    }

    // adding image_4
    public function addImage_4(Request $request, $id)
    {
        $product=Product::find($id);
        $product->image_4=$request->file('image_4')->store('products');
        $validator = Validator::make($request->all(), [

            'image_4'=>'required|image',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }
        $product->save();
        return $this->sendResponse(ProductResources::make($product), 'Product retrieved Successfully!');

    }

    // adding image_5
    public function addImage_5(Request $request, $id)
    {
        $product=Product::find($id);
        $product->image_5=$request->file('image_5')->store('products');
        $validator = Validator::make($request->all(), [

            'image_5'=>'required|image',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }
        $product->save();
        return $this->sendResponse(ProductResources::make($product), 'Product retrieved Successfully!');

    }

    // function for edit () product and it will need an id
    public function update(Request $request, $id)
    {
        $product=Product::find($id);
        $validator = Validator::make($request->all(), [
            'price'=>'required',
            'discount'=>'required',
            'description'=>'required',
            'image_1'=>'required|image',
            'color'=>'required',
            'product_name'=>'required',
            'quantity'=>'required',
            'id_departmant'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validate Error',$validator->errors());
        }

        $product->price= $request->input('price');
        $product->discount= $request->input('discount');
        $product->description= $request->input('description');
        $product->image_1=$request->file('image_1')->store('products');
        $product->color= $request->input('color');
        $product->product_name= $request->input('product_name');
        $product->quantity= $request->input('quantity');
        $product->id_departmant= $request->input('id_departmant');

        $product->save();
        return $this->sendResponse(new ProductResources($product), 'Product updated Successfully!');

    }


}
