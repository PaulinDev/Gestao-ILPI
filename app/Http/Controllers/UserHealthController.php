<?php

namespace App\Http\Controllers;

use App\Models\UserHealth;
use Illuminate\Http\Request;

class UserHealthController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $health = new UserHealth();
        $health->bloodGroup = $request->bloodGroup;
        $health->healthCenter = $request->healthCenter;
        $health->doctor = $request->doctor;
        $health->contact = $request->contact;
        $health->patient = $request->patient;
        return $health->save();
    }

    public function show(UserHealth $userHealth)
    {

    }

    public function update(Request $request, UserHealth $userHealth)
    {
        $health = UserHealth::find($request->id);
        $health->bloodGroup = $request->bloodGroup;
        $health->healthCenter = $request->healthCenter;
        $health->doctor = $request->doctor;
        $health->contact = $request->contact;
        $health->patient = $request->patient;
        return $health->save();
    }

    public function destroy(UserHealth $userHealth)
    {

    }
}
