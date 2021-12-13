<?php

namespace App\Http\Controllers;

use App\Models\GroupActivity;
use Illuminate\Http\Request;

class GroupActivityController extends Controller
{

    public function index()
    {
        return GroupActivity::with('getActivities')->get();
    }

    public function store(Request $request)
    {
        $newGroup = new GroupActivity();
        $newGroup->name = $request->name;
        $newGroup->status = 1;
        $newGroup->save();
    }

    public function show(GroupActivity $groupActivity)
    {
        //
    }

    public function update(Request $request, GroupActivity $activityGroup)
    {
        $activityGroup->name = $request->name;
        $activityGroup->status = $request->status;
        return $activityGroup->save();
    }

    public function destroy(GroupActivity $groupActivity)
    {
        //
    }
}
