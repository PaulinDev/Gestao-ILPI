<?php

namespace App\Http\Controllers;

use App\Models\InventoryType;
use Illuminate\Http\Request;

class InventoryTypeController extends Controller
{

    public function index()
    {
        return InventoryType::all();
    }


    public function store(Request $request)
    {
        $type = new InventoryType();
        $type->name = $request->name;
        return $type->save();
    }


    public function show(InventoryType $inventoryType)
    {
        //
    }


    public function update(Request $request, InventoryType $inventoryType)
    {
        //
    }


    public function destroy(InventoryType $inventoryType)
    {
        //
    }
}
