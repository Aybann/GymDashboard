<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'customer_id',
        'payment_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
