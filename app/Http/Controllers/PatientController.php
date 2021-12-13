<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function index()
    {
        return Patient::with('getGender')->with('getCountry')->with('getSituation')->with('getGuardians')
            ->with('getOccupation')->with('getEducation')->with('getCivil')->with('getHealth')
            ->with('getCards')->with('getAddress')->with('getInventory')->with('getPathology')->with('getTherapy')->get();
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
        return Patient::with('getGender')->with('getCountry')->with('getSituation')->with('getGuardians')
            ->with('getOccupation')->with('getEducation')->with('getCivil')
            ->with('getHealth')->with('getAddress')->with('getInventory')->with('getTherapy')->with('getCards')->with('getPathology')->find($patient->id);
    }


    public function update(Request $request, Patient $patient)
    {

        $patient->name = $request->name;
        $patient->nick = $request->nick;

//        $nameFile = null;
//
//        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
//
//            $name = uniqid(date('HisYmd'));
//            $extension = $request->photo->extension();
//
//            $nameFile = "{$name}.{$extension}";
//
//            $upload = $request->photo->storeAs('patients', $nameFile);
//
//            if (!$upload){
//                return response()->json(['error' => 'Houve um erro ao enviar imagem'], 500);
//            }else{
//                $patient->photo = $nameFile;
//            }
//
//
//        }

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
