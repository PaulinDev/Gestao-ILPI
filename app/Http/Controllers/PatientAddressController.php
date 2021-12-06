<?php

namespace App\Http\Controllers;

use App\Models\PatientAddress;
use Illuminate\Http\Request;

class PatientAddressController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $address = new PatientAddress();
        $address->address = $request->address;
        $address->cep = $request->cep;
        $address->phone = $request->phone;
        $address->email = $request->email;
        $address->patient = $request->patient;
        return $address->save();
    }

    public function show(PatientAddress $patientAddress)
    {

    }

    public function update(Request $request, PatientAddress $patientAddress)
    {
        $address = PatientAddress::find($request->id);
        $address->address = $request->address;
        $address->cep = $request->cep;
        $address->phone = $request->phone;
        $address->email = $request->email;
        return $address->save();
    }

    public function destroy(PatientCard $patientCard)
    {

    }
}
