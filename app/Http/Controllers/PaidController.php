<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Paid;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PaidController extends Controller
{

    public function index()
    {
        $paids = Paid::where('status', 'waiting')->latest()->paginate(10);
        foreach ($paids as $paid) {
            $paid->orders = json_decode($paid->orders);
            $paid->name = User::find($paid->user_id)->name;
        }
        return view('paids.index')->with('paids', $paids);
    }

    public function showAccept()
    {
        $paids = Paid::where('status', 'accept')->latest()->paginate(5);
        $deliverPaids = Paid::where('status', 'delivered')->latest()->paginate(5);

        return view('paids.accept', compact('paids', 'deliverPaids'));
    }

    public function confirmDeliver($id)
    {
        $paid = Paid::find($id);
        if (!$paid) {
            return redirect()->route('paids.deliver')->with('message', 'This Paid Is Not Found');
        }

        $paid->status = 'delivered';
        $paid->save();
        return redirect()->route('paids.deliver')->with('message', 'These Orders Delivered');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            'address' => 'required|string',
            'coupon' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validate Error', 'error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $orders = $user->orders()->where('status', 'added')->latest()->get();

        if ($orders->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'You Do Not Have Orders'], 400);
        }

        // Set Coupon
        $coupon = Discount::where('code', $request->coupon)->first();
        if ($coupon) {
            if ($coupon->status === 'disable') {
                return response()->json(['success' => false, 'message' => 'This Coupon is Disabled'], 400);
            } else if (!$coupon->amount > 0) {
                $coupon->status = 'disable';
                $coupon->save();
                return response()->json(['success' => false, 'message' => 'This Coupon is Completed'], 400);
            } else if ($coupon->started_at > Carbon::now()) {
                return response()->json(['success' => false, 'message' => 'This Coupon is not Started Yet'], 400);
            } else if ($coupon->expired_at < Carbon::now()) {
                $coupon->status = 'disable';
                $coupon->save();
                return response()->json(['success' => false, 'message' => 'This Coupon is Died'], 400);
            } else {
                $coupon->amount -= 1;
                if ($coupon->amount === 0) {
                    $coupon->status = 'disable';
                }
                $coupon->save();
            }
        } else if ($request->has('coupon')) {
            return response()->json(['success' => false, 'message' => 'This Coupon is not Found'], 400);
        }

        // Price && Quantity Products
        $sumPrice = 0;
        $arrOrders = array();
        foreach ($orders as $order) {
            // Decrease Products
            $product = $order->product;
            $product->quantity -= $order->quantity;
            $product->save();
            // Sum Price
            $sumPrice += $order->price;
            $arrOrders[] = $order->id;
            $order->status = 'waiting';
            $order->save();
        }

        // Price After Use Coupon
        if ($coupon) {
            $sumPrice = (100 - $coupon->value) * $sumPrice / 100;
        }

        // Set Image Paid
        $image = $request->image;
        $name =  Str::of(time() . $image->getClientOriginalName())->replace(' ', '');
        $image->move(public_path() . '/upload/paid/', $name);

        $paid = Paid::create([
            'user_id' => $user->id,
            'discount_id' => $coupon ? $coupon->id : NULL,
            'image' => 'upload/paid/' . $name,
            'address' => $request->address,
            'price' => $sumPrice,
            'status' => 'waiting',
            'orders' => json_encode($arrOrders),
        ]);

        return response()->json(['success' => true, 'message' => 'Wait for Validate Orders'], 200);
    }

    public function show($id)
    {
        $paid = Paid::find($id);
        if (!$paid) {
            return redirect()->route('paids.index')->with('message', 'This Paid Is Not Found');
        }
        $paid->orders = json_decode($paid->orders);
        $user = User::find($paid->user_id);
        $orders = array();
        foreach ($paid->orders as $order) {
            $orders[] = Order::find($order);
        }

        return view('paids.show', compact($paid, 'paid'))->with('user', $user)->with('orders', $orders);
    }

    public function accept($id)
    {
        $paid = Paid::find($id);
        if (!$paid) {
            return redirect()->route('paids.index')->with('message', 'This Paid Is Not Found');
        }
        $paid->status = 'accept';
        $paid->orders = json_decode($paid->orders);
        $paid->save();
        foreach ($paid->orders as $order) {
            $or = Order::find($order);
            $or->status = 'accept';
            $or->save();
        }

        return redirect()->route('paids.index')->with('message', 'Orders Accepted Successfully!');
    }

    public function decline($id)
    {
        $paid = Paid::find($id);
        if (!$paid) {
            return redirect()->route('paids.index')->with('message', 'This Paid Is Not Found');
        }
        $paid->status = 'decline';
        $paid->orders = json_decode($paid->orders);
        $paid->save();
        foreach ($paid->orders as $order) {
            $or = Order::find($order);
            $or->status = 'decline';
            $or->product->quantity += $or->quantity;
            $or->product->save();
            $or->save();
        }

        $discount = Discount::find($paid->discount_id);
        if ($discount) {
            if ($discount->status === 'disable' && $discount->amount === 0) {
                $discount->status === 'enable';
            }
            $discount->amount += 1;
            $discount->save();
        }

        return redirect()->route('paids.index')->with('message', 'Orders Declined Successfully!');
    }
}
