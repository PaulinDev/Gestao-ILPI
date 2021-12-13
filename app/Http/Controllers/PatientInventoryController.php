<?php

namespace App\Http\Controllers;

use App\Models\PatientInventory;
use Illuminate\Http\Request;

class PatientInventoryController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $inventory = new PatientInventory();
        $inventory->name = $request->name;
        $inventory->type = $request->type;
        $inventory->quantity = $request->quantity;
        $inventory->expirationDate = $request->expirationDate;
        $inventory->manufacturingDate = $request->manufacturingDate;
        $inventory->patientId = $request->patientId;
        $inventory->userId = $request->userId;
        return $inventory->save();
    }

    public function getInventoryPatient($id)
    {
        return PatientInventory::where('patientId', '=', $id)->get();
    }

    public function show(PatientInventory $patientInventory)
    {
        return $patientInventory;
    }

    public function update(Request $request, PatientInventory $patientInventory)
    {
        $patientInventory->name = $request->name;
        $patientInventory->type = $request->type;
        $patientInventory->quantity = $request->quantity;
        $patientInventory->expirationDate = $request->expirationDate;
        $patientInventory->manufacturingDate = $request->manufacturingDate;
        $patientInventory->patientId = $request->patientId;
        $patientInventory->userId = $request->userId;
        return $patientInventory->save();
    }

    public function destroy(PatientInventory $patientInventory)
    {
        return $patientInventory->delete();
    }
}
