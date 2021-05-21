<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    public function index()
    {
        $payments = Payment::latest()->get();
        return view('payments.index', compact($payments, 'payments'));
    }


    public function create()
    {
        return view('payments.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'logo' => 'required|image',
            'address' => 'required',
            'number' => 'required|integer'
        ]);

        $image = $request->logo;
        $name =  Str::of(time() . $image->getClientOriginalName())->replace(' ', '');
        $image->move(public_path() . '/upload/payments/', $name);

        $payment = Payment::create([
            'title' => $request->title,
            'logo' => 'upload/payments/' . $name,
            'address' => $request->address,
            'number' => $request->number,
        ]);

        return redirect()->route('payments.index')->with('status', 'Method Payment Created Successfully');
    }


    public function show($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return redirect()->route('payments.index')->with('status', 'Do Not Found Payment');
        }

        return view('payments.show', compact($payment, 'payment'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return redirect()->route('payments.index')->with('status', 'Do Not Found Payment');
        }

        $payment->delete();
        return redirect()->route('payments.index')->with('status', 'Payment Deleted Successfully');
    }
}
