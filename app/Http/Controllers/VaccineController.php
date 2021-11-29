<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{

    public function index()
    {
        return Vaccine::all();
    }

    public function store(Request $request)
    {
        $vaccine = new Vaccine();
        $vaccine->name = $request->name;
        $vaccine->status = $request->status;
        $vaccine->save();

    }

    public function show(Vaccine $vaccine)
    {
        return $vaccine;
    }

    public function showPatientVaccine()
    {
        return Patient::with('getVaccines')->get();
    }

    public function update(Request $request, Vaccine $vaccine)
    {
        $vaccine->status = $request->status;
        $vaccine->save();
    }

    public function destroy(Vaccine $vaccine)
    {
        //
    }
}
