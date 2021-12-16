<?php

namespace App\Http\Controllers;

use App\Models\GuardianType;
use Illuminate\Http\Request;

class GuardianTypeController extends Controller
{

    public function index()
    {
        return GuardianType::all();
    }


    public function store(Request $request)
    {
        $type = new GuardianType();
        $type->name = $request->name;
        return $type->save();
    }


    public function show(GuardianType $guardianType)
    {
        //
    }


    public function update(Request $request, GuardianType $guardianType)
    {
        //
    }


    public function destroy(GuardianType $guardianType)
    {
        //
    }
}
