<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use Illuminate\Http\Request;

class VaccineController extends Controller
{

    public function index()
    {
        $patients = Patient::count();
        $vaccine = Vaccine::withCount('getRecords')->get();
        $vaccineWithReturn = VaccineRecord::where('returnDate', '>', date("Y-m-d H:i:s"))->get();
        foreach ($vaccine as $x){
            $x->returnDate = 0;
            $x->PatientsWithoutRecords = $patients - $x->get_records_count;
            foreach ($vaccineWithReturn as $y){
                if($x->id === $y->vaccine){
                    $x->returnDate += 1;
                }
            }
        }
        return $vaccine;
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
