<?php

namespace App\Http\Middleware;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Paid;
use App\Models\Product;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class DeleteReserve
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $paids = Paid::where('status', 'reserve')->latest()->get();
        if ($paids) {
            foreach ($paids as $paid) {
                if ($paid->created_at->addDay() < Carbon::now()) {
                    $discount = Discount::find($paid->discount_id);
                    if ($discount) {
                        $discount->amount += 1;
                        $discount->save();
                    }

                    $ors = json_decode($paid->orders);
                    if ($ors) {
                        foreach ($ors as $or) {
                            $order = Order::find($or);
                            $order->product->quantity += $order->quantity;
                            $order->status = 'added';
                            $order->product->save();
                            $order->save();
                        }
                    }

                    $paid->delete();
                }
            }
        }

        return $next($request);
    }
}
