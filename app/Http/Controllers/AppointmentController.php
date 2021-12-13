<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    public function index()
    {
        return Appointment::all();
    }


    public function store(Request $request)
    {
        $appointments = [];

        foreach ($request->users as $x) {
            array_push($appointments,
                [
                    'title' => $request->title.' '.$x['text'],
                    'patientId' => $x['value'],
                    'dateAppointment' => $request->dateAppointment,
                    'startAppointment' => $request->startAppointment,
                    'endAppointment' => $request->endAppointment,
                    'additional' => $request->additional,
                    'internal' => 1,
                ]
            );
        }
        return DB::table('appointments')->insert($appointments);
    }


    public function show(Appointment $appointment)
    {
        //
    }

    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    public function destroy(Appointment $appointment)
    {
        //
    }
}
