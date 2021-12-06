<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function index()
    {
        return Patient::with('getGender')->with('getCountry')->with('getSituation')
            ->with('getOccupation')->with('getEducation')->with('getCivil')->with('getHealth')
            ->with('getCards')->with('getAddress')->get();
    }


    public function store(Request $request)
    {
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->nick = $request->nick;
        $patient->birthdate = $request->birthdate;
        $patient->admission = $request->admission;
        $patient->gender = $request->gender;
        $patient->civil = $request->civil;
        $patient->education = $request->education;
        $patient->occupation = $request->occupation;
        $patient->country = $request->country;
        $patient->situation = 1;
        return $patient->save();

    }


    public function show(Patient $patient)
    {
        return Patient::with('getGender')->with('getCountry')->with('getSituation')
            ->with('getOccupation')->with('getEducation')->with('getCivil')
            ->with('getHealth')->with('getAddress')->with('getCards')->find($patient->id);
    }


    public function update(Request $request, Patient $patient)
    {

        $patient->name = $request->name;
        $patient->nick = $request->nick;
        //$patient->additional = $request->additional;
        $patient->birthdate = $request->birthdate;
        $patient->gender = $request->gender;
        $patient->civil = $request->civil;
        $patient->education = $request->education;
        $patient->occupation = $request->occupation;
        $patient->admission = $request->admission;
        $patient->country = $request->country;
        $patient->situation = $request->situation;
        return $patient->save();
    }


    public function destroy(Patient $patient)
    {
        return $patient->delete();
    }
}
