<?php

namespace App\Http\Controllers;

use App\Models\PatientCard;
use Illuminate\Http\Request;

class PatientCardController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $card = new PatientCard();
        $card->card = $request->card;
        $card->contribution = $request->contribution;
        $card->systemHealth = $request->systemHealth;
        $card->securitySocial = $request->securitySocial;
        $card->patient = $request->patient;
        return $card->save();
    }

    public function show(PatientCard $patientCard)
    {

    }

    public function update(Request $request, PatientCard $patientCard)
    {
        $card = PatientCard::find($request->id);
        $card->card = $request->card;
        $card->contribution = $request->contribution;
        $card->securitySocial = $request->securitySocial;
        $card->systemHealth = $request->systemHealth;
        return $card->save();
    }

    public function destroy(PatientCard $patientCard)
    {

    }
}
