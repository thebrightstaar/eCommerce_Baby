<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Paid;
use App\Models\Payment;
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
            return redirect()->route('paids.deliver')->with('message', __('pay.paidEmpty'));
        }

        $paid->status = 'delivered';
        $paid->save();
        return redirect()->route('paids.deliver')->with('message', __('pay.paidDelivered'));
    }

    public function showDecline()
    {
        $paids = Paid::where('status', 'decline')->latest()->paginate(10);

        return view('paids.decline', compact('paids'));
    }

    public function showReserve()
    {
        $user = Auth::user();
        $reserve = $user->paid->where('status', 'reserve')->latest()->get();
        if (!$reserve) {
            return response()->json(['success' => false, 'message' => __('pay.paidNotReserve')], 400);
        }

        return response()->json(['success' => true, 'message' => __('pay.paidReserve'), 'data' => $reserve], 200);
    }

    public function storeReserve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => __('auth.validateError'), 'error' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $orders = $user->orders()->where('status', 'added')->latest()->get();

        if ($user->paid) {
            if (count($user->paid->where('status', 'reserve')->get()) >= 1) {
                return response()->json(['success' => false, 'message' => __('pay.paidAlready')], 400);
            }
        }
        if ($orders->isEmpty()) {
            return response()->json(['success' => false, 'message' => __('pay.paidNotOrders')], 400);
        }

        // Set Coupon
        $coupon = Discount::where('code', $request->coupon)->first();
        if ($coupon) {
            if ($coupon->status === 'disable') {
                return response()->json(['success' => false, 'message' => __('pay.couponDisabled')], 400);
            } else if (!$coupon->amount > 0) {
                $coupon->status = 'disable';
                $coupon->save();
                return response()->json(['success' => false, 'message' => __('pay.couponCompleted')], 400);
            } else if ($coupon->started_at > Carbon::now()) {
                return response()->json(['success' => false, 'message' => __('pay.couponNotStarted')], 400);
            } else if ($coupon->expired_at < Carbon::now()) {
                $coupon->status = 'disable';
                $coupon->save();
                return response()->json(['success' => false, 'message' => __('pay.couponDied')], 400);
            } else {
                $coupon->amount -= 1;
                if ($coupon->amount === 0) {
                    $coupon->status = 'disable';
                }
                $coupon->save();
            }
        } else if ($request->has('coupon')) {
            return response()->json(['success' => false, 'message' => __('pay.couponNotFound')], 400);
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
            $order->status = 'reserve';
            $order->save();
        }

        // Price After Use Coupon
        if ($coupon) {
            $sumPrice = (100 - $coupon->value) * $sumPrice / 100;
        }

        $paid = Paid::create([
            'user_id' => $user->id,
            'discount_id' => $coupon ? $coupon->id : NULL,
            'price' => $sumPrice,
            'status' => 'reserve',
            'orders' => json_encode($arrOrders),
        ]);

        return response()->json(['success' => true, 'message' => __('pay.paidWaiting'), 'data' => [
            'reserve_id' => $paid->id,
            'price' => $sumPrice
        ]], 200);
    }

    public function confirmReserve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reserve_id' => 'required|integer',
            'payment_id' => 'required|integer',
            'image' => 'required|image',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => __('auth.validateError'), 'error' => $validator->errors()], 400);
        }

        $paid = Paid::find($request->reserve_id);
        $user = Auth::user();
        $orders = json_decode($paid->orders);

        if (!$paid) {
            return response()->json(['success' => false, 'message' => __('pay.apiReserve')], 400);
        } else if ($user->id !== $paid->user_id) {
            return response()->json(['success' => false, 'message' => __('pay.apiRights')], 400);
        }

        if (!Payment::find($request->payment_id)) {
            return response()->json(['success' => false, 'message' => __('pay.payNotOffer')], 400);
        }

        if (!$orders) {
            return response()->json(['success' => false, 'message' => __('pay.paidNotOrders')], 400);
        }

        // Orders from Reseve to Waiting
        $arrOrders = array();
        foreach ($orders as $order) {
            $or = Order::find($order);
            $or->status = 'waiting';
            $or->save();
        }

        // Set Image Paid
        $image = $request->image;
        $name =  Str::of(time() . $image->getClientOriginalName())->replace(' ', '');
        $image->move(public_path() . '/upload/paid/', $name);

        $paid->image = 'upload/paid/' . $name;
        $paid->payment_id = $request->payment_id;
        $paid->address = $request->address;
        $paid->status = 'waiting';
        $paid->save();


        return response()->json(['success' => true, 'message' => __('pay.paidValide')], 200);
    }

    public function destoryReserve($id)
    {
        $paid = Paid::find($id);
        if (!$paid) {
            return response()->json(['success' => false, 'message' =>  __('pay.apiReserve')], 400);
        } else if (Auth::id() !== $paid->user_id || $paid->status !== 'reserve') {
            return response()->json(['success' => false, 'message' => __('pay.paidPermision')], 400);
        }

        $paid->delete();
        return response()->json(['success' => true, 'message' => __('pay.paidDeleted')], 200);
    }

    public function show($id)
    {
        $paid = Paid::find($id);
        if (!$paid) {
            return redirect()->route('paids.index')->with('message', __('pay.paidEmpty'));
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
            return redirect()->route('paids.index')->with('message', __('pay.paidEmpty'));
        }
        $paid->status = 'accept';
        $paid->orders = json_decode($paid->orders);
        $paid->save();
        foreach ($paid->orders as $order) {
            $or = Order::find($order);
            $or->status = 'accept';
            $or->save();
        }

        return redirect()->route('paids.index')->with('message', __('pay.paidAccept'));
    }

    public function decline($id)
    {
        $paid = Paid::find($id);
        if (!$paid) {
            return redirect()->route('paids.index')->with('message', __('pay.paidEmpty'));
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

        return redirect()->route('paids.index')->with('message', __('pay.paidDecline'));
    }
}
