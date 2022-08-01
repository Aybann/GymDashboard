<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        return Equipment::all();
    }

    public function find($id)
    {
        return Equipment::find($id);
    }

    public function create(Request $request)
    {
       Equipment::create([
        'name' => $request->name,
        'description' => $request->description,
        'date_checking' => $request->date_checking,
        'customer_id' => $request->customer_id
       ]);

       return Equipment::all();
    }

    public function update($id, Request $request)
    {
       $equipment = Equipment::find($id);
       $equipment->name = $request->name;
       $equipment->description = $request->description;
       $equipment->date_checking = $request->date_checking;
       $equipment->customer_id = $request->customer_id;
       $equipment->save();

       return $equipment;
    }

    public function delete($id)
    {
        Equipment::findOrFail($id)->delete();
    }
}
