<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('discounts.index')->with('discounts', $discounts);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'code' => 'required|string|unique:discounts,code',
            'value' => 'required|integer',
            'started' => 'required|date',
            'expired' => 'required|date',
            'amount' => 'integer'
        ]);

        $startTime = Carbon::create($request->started);
        $endTime = Carbon::create($request->expired);

        Discount::create([
            'name' => $request->name,
            'code' => $request->code,
            'value' => $request->value,
            'amount' => $request->amount,
            'status' => $startTime >= Carbon::now() ? 'enable' : 'waiting',
            'started_at' => $startTime,
            'expired_at' => $endTime,
        ]);

        return redirect()->route('discounts.index')->with('message', 'Coupon Created Successfully');
    }

    public function show($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return redirect()->route('discounts.index')->with('message', 'Coupon Not Found');
        }

        return redirect()->route('discounts.show', compact('discount'));
    }

    public function edit($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return redirect()->route('discounts.index')->with('message', 'Coupon Not Found');
        }
        return view('discounts.edit')->with('discount', $discount);
    }

    public function update(Request $request, $id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return redirect()->route('discounts.index')->with('message', 'Coupon Not Found');
        }
        $this->validate($request, [
            'name' => 'required|string',
            'code' => 'required|string',
            'value' => 'required|integer',
            'started' => 'required|date',
            'expired' => 'required|date',
            'amount' => 'integer'
        ]);

        $discount->name = $request->name;
        $discount->code = $request->code;
        $discount->value = $request->value;
        $discount->started_at = Carbon::create($request->started);
        $discount->expired_at = Carbon::create($request->expired);
        $discount->amount = $request->amount;
        $discount->save();

        return redirect()->route('discounts.index')->with('message', 'Update Coupon Successfully');
    }

    public function destroy($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return redirect()->route('discounts.index')->with('message', 'Coupon Not Found');
        }
        $discount->delete();

        return redirect()->route('discounts.index')->with('message', 'Deleted Coupon Successfully');
    }
}
