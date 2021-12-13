<?php

namespace App\Http\Controllers;

use App\Models\Therapy;
use Illuminate\Http\Request;

class TherapyController extends Controller
{

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        $therapy = new Therapy();
        $therapy->additional = $request->additional;
        $therapy->dateEnd = $request->dateEnd;
        $therapy->dateStart = $request->dateStart;
        $therapy->medicine = $request->medicine;
        $therapy->patientId = $request->patientId;
        $therapy->title = $request->title;
        return $therapy->save();
    }


    public function show(Therapy $therapy)
    {
        return $therapy;
    }


    public function update(Request $request, Therapy $therapy)
    {
        $therapy->additional = $request->additional;
        $therapy->dateEnd = $request->dateEnd;
        $therapy->dateStart = $request->dateStart;
        $therapy->medicine = $request->medicine;
        $therapy->patientId = $request->patientId;
        $therapy->title = $request->title;
        return $therapy->save();
    }


    public function destroy(Therapy $therapy)
    {
        return $therapy->delete();
    }
}
