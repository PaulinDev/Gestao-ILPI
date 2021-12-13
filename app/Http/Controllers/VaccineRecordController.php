<?php

namespace App\Http\Controllers;

use App\Models\VaccineRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineRecordController extends Controller
{

    public function index()
    {
        return VaccineRecord::with('getVaccine')->with('getPatient')->get();
    }


    public function store(Request $request)
    {
        $records = [];

        foreach ($request->users as $x) {
            array_push($records,
                [
                    'patient' => $x,
                    'vaccine' => $request->vaccine,
                    'vaccineBrand' => $request->vaccineBrand,
                    'batch' => $request->batch,
                    'comments' => $request->comments,
                    'date' => $request->data,
                    'returnDate' => $request->returnDate
                ]
            );
        }
        return DB::table('vaccine_records')->insert($records);
    }

    public function show(VaccineRecord $vaccineRecord)
    {
        return $vaccineRecord;
    }


    public function update(Request $request, VaccineRecord $vaccineRecord)
    {
        $vaccineRecord->patient = $request->patient;
        $vaccineRecord->vaccine = $request->vaccine;
        $vaccineRecord->vaccineBrand = $request->vaccineBrand;
        $vaccineRecord->batch = $request->batch;
        $vaccineRecord->comments = $request->comments;
        $vaccineRecord->date = $request->date;
        $vaccineRecord->returnDate = $request->returnDate;
        return $vaccineRecord->save();
    }


    public function destroy(VaccineRecord $vaccineRecord)
    {
        return $vaccineRecord->delete();
    }
}
