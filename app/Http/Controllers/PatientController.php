<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Patient::with('getGender')->with('getCountry')->with('getSituation')
            ->with('getOccupation')->with('getEducation')->with('getCivil')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->nick = $request->nick;
        $patient->birthdate = $request->birthdate;
        $patient->gender = $request->gender;
        $patient->civil = $request->civil;
        $patient->education = $request->education;
        $patient->occupation = $request->occupation;
        $patient->country = $request->country;
        $patient->situation = $request->situation;
        $patient->save();
        return $patient;

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return $patient;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        return $patient->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Patient $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient = Patient::find($patient);
        $patient->delete();
        return response()->json(['status' => 'Usuário deletado']);
    }
}
