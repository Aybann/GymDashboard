<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Subscription;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class CustomerController extends Controller
{ 
    public function index()
    {
        return Customer::all();
    }

    public function find($id)
    {
        return Customer::findOrFail($id); 
    }

    public function getCustomer($id)
    {
        $customer = Customer::find($id);
        if($customer == null){
            return 0;
        }
        else{
            return 1;
        }
    }

    public function create(Request $request)
    {
        Customer::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'address' => $request->address,
        'phone' => $request->phone,
        'email' => $request->email
       ]);

       return Customer::all();
    }

    public function getCustomerSubcription($id)
    {
        $subscription = Subscription::where("customer_id", $id)->first();
        if($subscription == null){
            return 0;
        }
        else{
            return $subscription;
        }
    }

    public function update(Request $request, $id)
    {
       $customer = Customer::find($id);
       $customer->first_name = $request->first_name;
       $customer->last_name = $request->last_name;
       $customer->address = $request->address;
       $customer->phone = $request->phone;
       $customer->email = $request->email; 
       $customer->save();

       return Customer::all();

    }

    public function delete($id)
    {
        Customer::find($id)->delete();
    }
}
