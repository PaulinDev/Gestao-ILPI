<?php

namespace App\Http\Controllers;

use App\Models\EventActivity;
use App\Models\Patient;
use Illuminate\Http\Request;

class EventActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EventActivity::all();
    }

    public function listPatient()
    {
        return Patient::with('getActivities')->get();
    }

    public function store(Request $request)
    {
        $data = json_decode($request->data);
        $events = $data->events;
        $insertEvents = [];
        foreach ($events as $x) {
            $patient = Patient::find($x->patient);
            array_push(
                $insertEvents,
                [
                    'patient' => intval($x->patient),
                    'activity' => $x->activity,
                    'title' => $x->title . $patient->name,
                    'backgroundColor' => $x->backgroundColor,
                    'date' => $x->date,
                    'end' => $x->end
                ]
            );
        }
        return  EventActivity::insert($insertEvents);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\EventActivity $eventActivity
     * @return \Illuminate\Http\Response
     */
    public function show(EventActivity $event)
    {
        return $event;
    }

    public function findActivity(Request $request)
    {
        return EventActivity::where('activity', '=', $request->id)->get();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EventActivity $eventActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventActivity $eventActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\EventActivity $eventActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventActivity $eventActivity)
    {
        //
    }
}
