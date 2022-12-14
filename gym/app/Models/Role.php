<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_type'
    ];
    
    public function user(){
        return $this->beloingsTo(User::class);
    }

    public function permissions(){
        return $this->hasMany(Permission::class);
    }
}
