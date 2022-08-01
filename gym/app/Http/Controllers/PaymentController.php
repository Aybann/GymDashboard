<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
  
    public function index()
    {
        return Payment::all();
    }

    public function find($id)
    {
        return Payment::find($id);
    }

    public function hasPaid($id)
    {
        $subscription = Subscription::where("payment_id", $id)->first();
        if($subscription == null){
            return 0;
        }
        else{
            return 1;
        }
    }

    public function create(Request $request)
    {
       Payment::create([
        'payment_total' => $request->payment_total,
        'payment_date' => $request->payment_date,
        'subscription_id' => $request->subscription_id,
        'customer_id' => $request->customer_id
       ]);

       return Payment::all();
    }

    public function update($id, Request $request)
    {
       $payment = Payment::find($id);
       $payment->payment_total = $request->payment_total;
       $payment->payment_date = $request->payment_date;
       $payment->subscription_id = $request->subscription_id;
       $payment->customer_id = $request->customer_id;
       $payment->save();

       return $payment;
    }

    public function delete($id)
    {   
        Payment::findOrFail($id)->delete();
     
    }
}
