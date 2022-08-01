<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_total',
        'payment_date',
        'subscription_id',
        'customer_id'
    ];


    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
