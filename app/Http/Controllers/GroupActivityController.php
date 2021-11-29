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
        $newGroup->save();
    }

    public function show(GroupActivity $groupActivity)
    {
        //
    }

    public function update(Request $request, GroupActivity $groupActivity)
    {
        //
    }

    public function destroy(GroupActivity $groupActivity)
    {
        //
    }
}
