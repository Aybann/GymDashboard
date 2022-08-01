<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone',
        'email'
    ];

    public function equipments(){
        return $this->hasMany(Equipment::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function subscription(){
        return $this->hasOne(Subscription::class);
    }
}
