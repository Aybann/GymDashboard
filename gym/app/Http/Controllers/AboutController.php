<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    
    public function index()
    {
        $firstname = "Aybann";
        return view('about',
        [
            'first_name' => $firstname,
            'last_name' => 'Secret'
        ]);
    }
}
