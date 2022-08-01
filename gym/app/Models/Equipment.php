<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'name',
        'description',
        'date_checking',
        'customer_id'
    ];

    public function customer(){
        return $this->beloingsTo(Customer::class);
    }
}
