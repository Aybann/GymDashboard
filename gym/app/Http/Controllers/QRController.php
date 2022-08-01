<?php

namespace App\Http\Controllers;
use App\Models\Equipment;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;

class QRController extends Controller
{
    public function generateQrCode($id) 
    {

        $equipment = Equipment::find($id);
        $msg = $equipment->name." -\r\n".$equipment->description;
    
        return \QrCode::size(200)
                ->format('png')
                ->generate($msg);

        
    }
}
