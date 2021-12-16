<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\EventActivity;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventActivityController extends Controller
{

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
        $events = [];
        $activity = Activity::find($request->activity);
        foreach ($request->patient as $p) {
            $patient = Patient::find($p);
            array_push($events, [
                'activity' => $request->activity,
                'patient' => $p,
                'title' => $activity->name.' - '.$patient->name,
                'allDay' => $request->allDay,
                'date' => $request->date,
                'end' => $request->end,
                'repeatDays' => json_encode($request->repeatDays),
                'timeEnd' => $request->timeEnd,
                'timeStart' => $request->timeStart,
            ]);
        }

        return DB::table('event_activities')->insert($events);
    }


    public function show(EventActivity $activityPatient)
    {
        return $activityPatient;
    }

    public function findActivity(Request $request)
    {
        return EventActivity::where('activity', '=', $request->id)->get();
    }



    public function update(Request $request, EventActivity $activityPatient)
    {
        $activity = Activity::find($request->activity);
        $patient = Patient::find($activityPatient->patient);

        $activityPatient->activity = $request->activity;
        $activityPatient->patient = $patient->id;
        $activityPatient->title = $activity->name.' - '.$patient->name;
        $activityPatient->allDay = $request->allDay;
        $activityPatient->date = $request->date;
        $activityPatient->end = $request->end;
        $activityPatient->repeatDays = json_encode($request->repeatDays);
        $activityPatient->timeEnd = $request->timeEnd;
        $activityPatient->timeStart = $request->timeStart;

        return $activityPatient->save();
    }


    public function destroy(EventActivity $activityPatient)
    {
        return $activityPatient->delete();
    }
}
