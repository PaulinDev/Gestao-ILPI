<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function index()
    {
        return Activity::all();
    }


    public function store(Request $request)
    {
        $activity = new Activity();
        $activity->name = $request->name;
        $activity->group = $request->group;
        $activity->save();
    }


    public function show(Activity $activity)
    {
        //
    }


    public function update(Request $request, Activity $activity)
    {
        //
    }


    public function destroy(Activity $activity)
    {
        //
    }
}
