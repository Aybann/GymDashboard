<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Customer::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $names = array("Aybann", "Vanz", "Vanny", "Wafu");
        $emails = array("secret@02gmail.com", "vanz@02gmail.com", "vanny@02gmail.com", "wafu@02gmail.com");

        for($i = 0; $i < count($names); $i++)
        {
            $customer = new Customer;
            $customer->first_name = $names[$i];
            $customer->last_name = "Secret";
            $customer->address = "San Antonio Northern Samar";
            $customer->phone = "908012384";
            $customer->email = $emails[$i]; 
            $customer->save();
        } 

        //equipments
        $customer = Customer::find(1);
        $customer->equipments()->create([
            'name' => "Dumble",
            'description' => "Equipments Description About this",
            'date_checking' => "2026-01-22",
        ]);


        //Subscription
        $customer = Customer::find(1);
        $customer->subscription()->create([
            'start_date' => "2022-12-16",
            'end_date' => "2026-01-22",
            'payment_id' => '1',
            'customer_id' => '1'
        ]);

        //payment
        $subscription = Subscription::find(1);
        $subscription->payment()->create([
            'payment_total' => "728",
            'payment_date' => "2022-12-16",
            'customer_id' => '1',
            'subscription_id' => '1',
        ]);

        //user
        // $payment = Payment::find(1);
        // $payment->users()->create([
        //     'name' => "Vans",
        //     'email' => "secret123@gmail.com",
        //     'password' => "123456789",
        // ]);

        //role
        // $user = User::find(1);
        // $user->roles()->create([
        //     'role_type' => "admin"
        // ]);

        //permisison
        // $role = Role::find(1);
        // $role->permission()->create([
        //     'role_type' => "admin"
        // ]);

    }
}
