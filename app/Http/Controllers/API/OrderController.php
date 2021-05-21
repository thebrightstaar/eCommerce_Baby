<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->where('status', 'added')->latest()->get();
        $sumPrice = 0;
        foreach ($orders as $order) {
            $sumPrice += $order->price;
        }
        return response()->json([
            'success' => true,
            'total price' => $sumPrice,
            'message' => 'Orders Retrived Successfuly', 'data' => $orders
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validate Error', 'error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product Not Found'], 400);
        }

        if ($user->orders()->where('product_id', $product_id)
            ->where('status', 'added')->first()
        ) {
            return response()->json(['success' => false, 'message' => 'Product Already Added'], 400);
        }

        if ($product->quantity >= $quantity) {
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'price' => $quantity * $product->price,
                'status' => 'added'
            ]);
            return response()->json(['success' => true, 'message' => 'Add Order Successfuly', 'data' => $order], 200);
        }

        return response()->json([
            'success' => false, 'message' => 'Quantity Is Not Enough',
            'Quantity Remaining' => $product->quantity
        ], 400);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validate Error', 'error' => $validator->errors()], 400);
        }

        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::find($product_id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product Not Found'], 400);
        }

        if ($product->quantity >= $quantity) {
            $order = Auth::user()->orders()->where('product_id', $product_id)->first();
            if ($order) {
                $order->quantity = $quantity;
                $order->price = $product->price * $quantity;
                $order->save();
                return response()->json(['success' => true, 'message' => 'Update Order Successfuly', 'data' => $order], 200);
            }
            return response()->json(['success' => false, 'message' => 'Do Not Have Rights For Updating'], 200);
        }

        return response()->json([
            'success' => false, 'message' => 'Quantity Is Not Enough',
            'Quantity Remaining' => $product->quantity
        ], 400);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (Auth::user()->id !== $order->user_id) {
            return response()->json(['success' => false, 'message' => 'Do Not Have Rights For Deleting'], 400);
        }
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order Is Not Found'], 400);
        } else if ($order->status !== 'added') {
            return response()->json(['success' => false, 'message' => 'Can Not Delete Order Is Paid'], 400);
        }

        $order->delete();

        return response()->json(['success' => true, 'message' => 'Order Deleted Successfully'], 200);
    }
}
