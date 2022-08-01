<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return Subscription::all();
    }

    public function find($id)
    {
        return Subscription::find($id);
    }

    public function getSubscription($id)
    {
        $subscription = Subscription::find($id);
        if($subscription == null){
            return 0;
        }
        else{
            return 1;
        }
    }

    public function hasSubscription($id)
    {
        $subscription = Subscription::where("customer_id", $id)->first();
        if($subscription == null){
            return 0;
        }
        else{
            return 1;
        }
    }

    public function create(Request $request)
    {
       $subscription = Subscription::create([
        'start_date'=> $request->start_date,
        'end_date'=> $request->end_date,
        'customer_id' => $request->customer_id,
        'payment_id' => $request->payment_id
       ]);

       return $subscription;
    }

    public function update($id, Request $request)
    {
        $subscription = Subscription::find($id);
        $subscription->start_date = $request->start_date;
        $subscription->end_date = $request->end_date;
        $subscription->customer_id = $request->customer_id;
        $subscription->payment_id = $request->payment_id;
        $subscription->save();

        return Subscription::all();
    }

    public function delete($id)
    {
       Subscription::findOrFail($id)->delete();
    }
}
